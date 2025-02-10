<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Dish;
use App\Models\Order;
use App\Models\UserAddress;
use App\Models\WishlistItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function addToCart(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'wishlist_id' => 'nullable|integer',
            'dish_id' => 'required|integer',
            'quantity_id' => 'required|integer',
            'cart_quantity' => 'required|integer|min:1', // Renamed quantity to cart_quantity
            'total_amount' => 'required|numeric',
        ]);

        $wishlist_id = $validatedData['wishlist_id'] ?? null;
        if ($wishlist_id) {
            $wishlist_item = WishlistItem::find($wishlist_id);
            if ($wishlist_item) {
                $wishlist_item->delete();
            }
        }

        $user_id = auth()->user()->id;

        // Check if the same dish with the same quantity_id exists in the cart
        $cartItem = Order::where('user_id', $user_id)
            ->where('dish_id', $validatedData['dish_id'])
            ->where('quantity_id', $validatedData['quantity_id'])
            ->where('order_stage', 'in_cart')
            ->first();

        if ($cartItem) {
            // If item exists, update the cart_quantity and total_amount
            $cartItem->cart_quantity += $validatedData['cart_quantity'];
            $cartItem->total_amount += $validatedData['total_amount'];
            $cartItem->updated_at = now();
            $cartItem->save();
        } else {
            // If no existing cart item, create a new one
            Order::create([
                'user_id' => $user_id,
                'dish_id' => $validatedData['dish_id'],
                'quantity_id' => $validatedData['quantity_id'],
                'cart_quantity' => $validatedData['cart_quantity'],
                'total_amount' => $validatedData['total_amount'],
            ]);
        }

        // Recalculate the cart total
        $cartTotal = Order::where('user_id', $user_id)
            ->where('order_stage', 'in_cart')
            ->sum('total_amount');

        // Apply coupon discount if available
        $couponDiscount = session('coupon_discount', 0);
        $newTotal = ($couponDiscount > 0) ? max($cartTotal - $couponDiscount, 0) : $cartTotal;
        session(['new_total' => $newTotal]);

        return response()->json([
            'success' => true,
            'message' => 'Item added to Cart successfully!',
        ]);
    }


    public function viewCart()
    {
        $user = auth()->user();
        $user_id = $user->id;

        $cartItems = Order::where('user_id', $user_id)
            ->where('order_stage', 'in_cart')
            ->with(['dish', 'quantity'])
            ->get();

        $cartTotal = $cartItems->sum('total_amount');
        $discountTotal = $cartItems->sum('discount_amount');
        $finalTotal = $cartTotal - $discountTotal;

        $addresses = UserAddress::where('user_id', $user_id)->get();

        // Fetch used and unused coupons logic remains the same
        $usedCouponIds = CouponUsage::where('user_id', $user_id)->pluck('coupon_id')->toArray();
        $allCoupons = Coupon::where('active', true)
            ->whereDate('expiry_date', '>=', now())
            ->where(function ($query) use ($cartTotal) {
                $query->whereNull('minimum_order_value')
                    ->orWhere('minimum_order_value', '<=', $cartTotal);
            })
            ->get();
        $usedCoupons = $allCoupons->whereIn('id', $usedCouponIds);
        $unusedCoupons = $allCoupons->whereNotIn('id', $usedCouponIds);

        return view('cart', [
            'cartItems' => $cartItems,
            'addresses' => $addresses,
            'usedCoupons' => $usedCoupons,
            'unusedCoupons' => $unusedCoupons,
            'cartTotal' => $cartTotal,
            'discountTotal' => $discountTotal,
            'finalTotal' => $finalTotal,
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['promo_code' => 'required|string']);

        $user = auth()->user();
        $coupon = Coupon::where('code', $request->promo_code)
            ->where('active', true)
            ->whereDate('expiry_date', '>=', now())
            ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon.']);
        }

        $alreadyUsed = $user->couponUsages()->where('coupon_id', $coupon->id)->exists();

        if ($alreadyUsed) {
            return response()->json(['success' => false, 'message' => 'You have already used this coupon.']);
        }

        $cartItems = Order::where('user_id', $user->id)
            ->where('order_stage', 'in_cart')
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.']);
        }

        $cartTotal = $cartItems->sum('total_amount');
        \Log::info("Cart Total =$cartTotal");

        if ($coupon->minimum_order_value && $cartTotal < $coupon->minimum_order_value) {
            return response()->json(['success' => false, 'message' => 'Cart total is less than the minimum required.']);
        }

        $discount = $coupon->type === 'percentage'
            ? ($cartTotal * ($coupon->value / 100))
            : $coupon->value;

        $newTotal = max(0, $cartTotal - $discount);

        // Update orders with coupon and discount
        foreach ($cartItems as $item) {
            \Log::info('Updating Order ID: ' . $item->id, [
                'applied_coupon_id' => $coupon->id,
                'discount_amount' => $discount / $cartItems->count(),
            ]);

            $item->update([
                'applied_coupon_id' => $coupon->id,
                'discount_amount' => $discount / $cartItems->count(),
            ]);
        }



        // Save coupon usage
        $user->couponUsages()->create(['coupon_id' => $coupon->id]);

        return response()->json([
            'success' => true,
            'discount' => $discount,
            'new_total' => $newTotal,
        ]);
    }






    public function checkout(Request $request)
    {
        $request->validate([
            "payment_method" => "required",
            'total_amount' => "required",
        ]);

        $user = auth()->user();
        $orderIds = explode(',', $request->input('order_ids'));
        $paymentMethod = $request->input('payment_method');
        $totalAmountInput = $request->input('total_amount');
        $totalAmount = intval(round((float) str_replace(',', '', $totalAmountInput) * 100));
        $selected_address = UserAddress::where(
            [
                'is_default' => 1,
                'user_id' => $user->id
            ]
        )->first();

        if (!$selected_address) {
            return redirect()->back()->withErrors('No default address available.');
        }

        if ($paymentMethod === 'COD') {
            // Update orders
            Order::whereIn('id', $orderIds)->where('user_id', $user->id)->update([
                'order_stage' => 'confirmed',
                'payment_state' => 'pending',
                'selected_address' => json_encode($selected_address),
            ]);

            // Notify the admin
            // $admin = Admin::first(); // Assuming a single admin user
            // if ($admin) {
            //     $orderDetails = [
            //         'user_id' => $user->id,
            //         'order_ids' => $orderIds,
            //         'payment_method' => $paymentMethod,
            //         'total_amount' => $totalAmount / 100,
            //         'selected_address' => $selected_address,
            //         'order_stage' => 'confirmed',
            //     ];
            //     $admin->notify(new OrderPlacedNotification($orderDetails));
            // }

            return redirect()->route('order-confirmation')->with('success', 'Order placed successfully.');
        }


    }

    public function order_confirmation()
    {
        return view('order-confirmation');
    }



    public function destroy($id)
    {
        // Find the order item by ID
        $order = Order::findOrFail($id);

        // Ensure the item belongs to the current user (optional for security)
        if ($order->user_id !== auth()->user()->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        if ($order && $order->order_stage === 'in_cart') {
            $order->order_stage = 'removed_from_cart';
            $order->applied_coupon_id = 0;
            $order->discount_amount = 0;

        }
        // Delete the item
        $order->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Item removed from your cart!');
    }
}

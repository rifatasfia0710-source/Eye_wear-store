<?php

// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
  
   public function index()
{
    // -----------------------------
    // 👉 LOGGED IN USER
    // -----------------------------
    if (Auth::check()) {

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(
            fn($item) => $item->quantity * $item->product->price
        );

        return view('cart.index', compact('cartItems', 'total'));
    }
$cartItems = Cart::with('product.images')  // ← add .images
    ->where('user_id', Auth::id())
    ->get();
    // -----------------------------
    // 👉 GUEST USER (SESSION)
    // -----------------------------
    $cartItems = session()->get('cart', []);
    $total = collect($cartItems)->sum(
        fn($item) => $item['quantity'] * $item['price']
    );

    return view('cart.index', compact('cartItems', 'total'));
}

    // -------------------------------------------------------
    // ADD TO CART
    // -------------------------------------------------------
   public function store(Request $request)
{
    $request->validate([
        'product_id'  => 'required|exists:products,id',
        'quantity'    => 'required|integer|min:1',
        'lens_type'   => 'nullable|string|max:100',
        'frame_color' => 'nullable|string|max:100',
        'sph_left'    => 'nullable|numeric',
        'sph_right'   => 'nullable|numeric',
    ]);

    $product = Product::findOrFail($request->product_id);

    // -----------------------------
    // 👉 GUEST USER → SESSION CART
    // -----------------------------
    if (!Auth::check()) {

        $cart = session()->get('cart', []);

        $key = $request->product_id.'_'.$request->lens_type.'_'.$request->frame_color;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $request->quantity;
        } else {
            $cart[$key] = [
                'product_id'  => $product->id,
                'name'        => $product->name,
                'price'       => $product->price,
                'quantity'    => $request->quantity,
                'lens_type'   => $request->lens_type,
                'frame_color' => $request->frame_color,
                'sph_left'    => $request->sph_left,
                'sph_right'   => $request->sph_right,
                'image'       => optional($product->images->first())->image_path,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')
            ->with('success', 'Product added to cart');
    }

    // -----------------------------
    // 👉 LOGGED IN USER → DB CART
    // -----------------------------
    $cartItem = Cart::where('user_id', Auth::id())
        ->where('product_id', $request->product_id)
        ->where('lens_type', $request->lens_type)
        ->where('frame_color', $request->frame_color)
        ->first();

    if ($cartItem) {
        $cartItem->increment('quantity', $request->quantity);
    } else {
        Cart::create([
            'user_id'     => Auth::id(),
            'product_id'  => $request->product_id,
            'quantity'    => $request->quantity,
            'lens_type'   => $request->lens_type,
            'frame_color' => $request->frame_color,
            'sph_left'    => $request->sph_left,
            'sph_right'   => $request->sph_right,
        ]);
    }

    return redirect()->route('cart.index')
        ->with('success', 'Product added to cart');
}

    // -------------------------------------------------------
    // UPDATE QUANTITY
    // -------------------------------------------------------
    public function update(Request $request, Cart $cart)
    {
        // Make sure the cart item belongs to the logged-in user
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Optional: Stock check
        if ($cart->product->stock_quantity < $request->quantity)  {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated.');
    }

    // -------------------------------------------------------
    // REMOVE ITEM
    // -------------------------------------------------------
    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    // -------------------------------------------------------
    // CLEAR ENTIRE CART
    // -------------------------------------------------------
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Cart cleared.');
    }
}
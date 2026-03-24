<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the wishlist
     */
    public function index()
    {
        $wishlists = Wishlist::with('product.images')
            ->forUser(Auth::id())
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    /**
     * Add product to wishlist
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product is active
        if (!$product->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Product is not available'
            ], 400);
        }

        // Check if already in wishlist
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Product is already in your wishlist'
            ], 400);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'note' => $request->note
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist successfully',
            'count' => Wishlist::forUser(Auth::id())->count()
        ]);
    }

    /**
     * Remove product from wishlist
     */
    public function remove($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->findOrFail($id);

        $wishlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist',
            'count' => Wishlist::forUser(Auth::id())->count()
        ]);
    }

    /**
     * Toggle wishlist (add/remove)
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Product removed from wishlist';
            $action = 'removed';
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ]);
            $message = 'Product added to wishlist';
            $action = 'added';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'action' => $action,
            'count' => Wishlist::forUser(Auth::id())->count()
        ]);
    }

    /**
     * Move wishlist item to cart
     */
    public function moveToCart($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->findOrFail($id);

        $product = $wishlist->product;

        // Check if product is in stock
        if (!$product->in_stock) {
            return response()->json([
                'success' => false,
                'message' => 'Product is out of stock'
            ], 400);
        }

        // Add to cart (using CartController logic)
        $cartController = new CartController();
        $request = new Request([
            'product_id' => $product->id,
            'quantity' => 1
        ]);
        
        $cartResponse = $cartController->add($request);
        
        if ($cartResponse->getData()->success) {
            // Remove from wishlist
            $wishlist->delete();
        }

        return $cartResponse;
    }

    /**
     * Get wishlist count
     */
    public function count()
    {
        $count = Wishlist::forUser(Auth::id())->count();

        return response()->json([
            'count' => $count
        ]);
    }

    /**
     * Clear entire wishlist
     */
    public function clear()
    {
        Wishlist::where('user_id', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wishlist cleared successfully'
        ]);
    }

    /**
     * Check if product is in wishlist
     */
    public function check(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->exists();

        return response()->json([
            'in_wishlist' => $exists
        ]);
    }
}
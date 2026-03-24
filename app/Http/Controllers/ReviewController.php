<?php
namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Already reviewed check
        $existing = Review::where('user_id', auth()->id())
                          ->where('product_id', $product->id)
                          ->first();

        if ($existing) {
            // Update existing review
            $existing->update([
                'rating'  => $request->rating,
                'comment' => $request->comment,
            ]);
            return back()->with('success', 'Review updated successfully!');
        }

        Review::create([
            'user_id'    => auth()->id(),
            'product_id' => $product->id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }

    public function destroy(Review $review)
    {
        // শুধু নিজের review delete করতে পারবে
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->delete();
        return back()->with('success', 'Review deleted.');
    }
}
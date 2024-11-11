<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Trait\SendResponse;

class ProductController extends Controller
{
    use SendResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('user')->paginate(2);
        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found'], 404);
        }

        $products = ProductResource::collection($products);

        return response()->json([
            'data' => $products,
            'pagination' => [
                'total' => $products->count(),
                'current_page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'total_pages' => $products->lastPage(),
                'next_page_url' => $products->nextPageUrl(),
                'prev_page_url' => $products->previousPageUrl(),
            ]
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

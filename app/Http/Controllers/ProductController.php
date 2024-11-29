<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;

class ProductController extends Controller
{

    // function to display all products
    public function index()
    {
        $products = Product::all();

        return view('products.index', [
            'products' => $products,
        ]);
    }

    // function to display create product page
    public function create()
    {
        return view('products.create');
    }

    // function to add new product
    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required|unique:products,sku|max:255',
            'name' => 'required|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        Product::create([
            'sku' => $request->sku,
            'name' => $request->name,
            'stock' => $request->stock,
        ]);

        return redirect()->route('products.create')
            ->with('success', 'Product created successfully!');
    }

    // function to delete product by id
    public function delete($id)
    {
        // Find the product by ID
        $product = Product::find($id);

        // Check if the product exists
        if (!$product) {
            return response()->json([
                'message' => 'Product not found.',
            ], 404);
        }

        // Delete the product
        $product->deleted_at = Carbon::now(); // Set to current timestamp or any specific value
        $product->save(); // Save the updated product

        return response()->json([
            'message' => 'Product deleted successfully.',
        ], 200);
    }

    public function edit(Product $product)
    {
        // Return the view with the product data for editing
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Validate the input
        $request->validate([
            'sku' => 'required|max:255|unique:products,sku,' . $product->id,
            'name' => 'required|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        // Update the product with the new data
        $product->update([
            'sku' => $request->sku,
            'name' => $request->name,
            'stock' => $request->stock,
        ]);

        // Redirect to the product detail page with success message
        return redirect()->route('products.edit', $product)->with('success', 'Product updated successfully!');
    }
}

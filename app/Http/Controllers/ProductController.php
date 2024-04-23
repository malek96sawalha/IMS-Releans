<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Response;


class ProductController extends Controller
{
    private Product $product;
    /**
     * Display a listing of the resource.
     */

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $products = $this->product->all();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

        /**
 * @OA\Post(
 *     path="/api/products",
 *     tags={"products"},
 *     summary="Create a new product",
 *     description="Endpoint to create a new products.",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Request Body Description",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="name",
 *                 type="string",
 *                 description="The title of the product"
 *             ),
 *             @OA\Property(
 *                 property="description",
 *                 type="text",
 *                 description="The description of the product"
 *             ),
 *             @OA\Property(
 *                 property="price",
 *                 type="integer",
 *                 description="The price of the product"
 *             ),
 *             @OA\Property(
 *                 property="created_at",
 *                 type="date",
 *                 description="The roles to which the product is targeted"
 *             ),
 *             @OA\Property(
 *                 property="updated_at",
 *                 type="date",
 *                 description="The roles to which the product is targeted"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Notification created successfully"
 *     ),
 *     @OA\Response(
 *         response="400",
 *         description="Bad request, validation failed"
 *     )
 * )
 */

    public function store(Request $request, Response $response)
{
    try {
        $product = $this->product->create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);

        return response()->json(['message' => 'Product Created Successfully', 'product' => $product], 201);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed To Create Product: ' . $e->getMessage()], 500);
    }
}


    /**
 * @OA\Get(
 *     path="/api/products",
 *     tags={"products"},
 *     summary="Get all products",
 *     description="Endpoint to retrieve a list of all products.",
 *     @OA\Response(
 *         response="200",
 *         description="List of products"
 *     )
 * )
 */

    public function show(Request $request, Response $response)
{
    $products = $this->product::all();

    if ($products->isEmpty()) {
        // If no results found, return a response indicating no results
        return response()->json(['message' => 'No Products found'], 404);
    }

    // If results found, return them as JSON
    return response()->json($products);
}


    public function select(Request $request, Product $product)
{
    $products = $this->product::find($product);

    if ($products->isEmpty()) {
        // If no results found, return a response indicating no results
        return response()->json(['status' => 404,
        'message' => 'No Products found'], 404);
    }

    // If results found, return them as JSON
    return response()->json($products);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

/**
 * @OA\Put(
 *     path="/api/products/{product_id}",
 *     tags={"products"},
 *     summary="Update product details",
 *     description="Endpoint to update product details.",
 *     @OA\Parameter(
 *         name="product_id",
 *         in="path",
 *         required=true,
 *         description="ID of the product to update",
 *         @OA\Schema(
 *             type="integer",
 *             format="int64"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Request Body Description",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="name",
 *                 type="string",
 *                 description="The title of the product"
 *             ),
 *             @OA\Property(
 *                 property="description",
 *                 type="text",
 *                 description="The description of the product"
 *             ),
 *             @OA\Property(
 *                 property="price",
 *                 type="integer",
 *                 description="The price of the product"
 *             ),
 *             @OA\Property(
 *                 property="created_at",
 *                 type="date",
 *                 description="The roles to which the product is targeted"
 *             ),
 *             @OA\Property(
 *                 property="updated_at",
 *                 type="date",
 *                 description="The roles to which the product is targeted"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="product details updated successfully"
 *     ),
 *     @OA\Response(
 *         response="400",
 *         description="Bad request, validation failed"
 *     )
 * )
 */

    public function update(Request $request, Product $product_id)
    {
        try {
            $product_id->update($request->only(['name', 'description', 'price']));
            return response()->json(['message' => 'Product updated successfully', 'product' => $product_id]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update product: ' . $e->getMessage()], 500);
        }
    }

/**
 * @OA\Delete(
 *     path="/api/products/{product_id}",
 *     tags={"products"},
 *     summary="Delete a product",
 *     description="Endpoint to delete a product by ID.",
 *     @OA\Parameter(
 *         name="product_id",
 *         in="path",
 *         required=true,
 *         description="ID of the product to delete",
 *         @OA\Schema(
 *             type="integer",
 *             format="int64"
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="product deleted successfully"
 *     ),
 *     @OA\Response(
 *         response="404",
 *         description="product not found"
 *     )
 * )
 */

    public function destroy(Product $product_id)
    {
        try {
            $product_id->delete();
            return response()->json(['message' => 'Product deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete product: ' . $e->getMessage()], 500);
        }
    }
}

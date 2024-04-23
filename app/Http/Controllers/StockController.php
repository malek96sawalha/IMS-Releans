<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StockController extends Controller
{

    private Stock $stock;
    
    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    public function index()
    {
        $stocks = $this->stock->all();
        return response()->json($stocks);
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
 *     path="/api/stocks",
 *     tags={"stocks"},
 *     summary="Create a new stocks",
 *     description="Endpoint to create a new notifiactions.",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Request Body Description",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="product_id",
 *                 type="integer",
 *                 description="The ID of the product for which the stock is intended"
 *             ),
 *             @OA\Property(
 *                 property="quantity",
 *                 type="integer",
 *                 description="The quantity of the stock"
 *             ),
 *             @OA\Property(
 *                 property="minimum_quantity",
 *                 type="integer",
 *                 description="The minimum quantity of the stock"
 *             ),
 *             @OA\Property(
 *                 property="maximum_quantity",
 *                 type="integer",
 *                 description="The maximum quantity of the stock"
 *             ),
 *             @OA\Property(
 *                 property="created_at",
 *                 type="string",
 *                 format="date-time",
 *                 description="The creation date and time of the stock"
 *             ),
 *             @OA\Property(
 *                 property="updated_at",
 *                 type="string",
 *                 format="date-time",
 *                 description="The last update date and time of the stock"
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
            $stock = $this->stock->create([
                'quantity' => $request->quantity,
                'minimum_quantity' => $request->minimum_quantity,
                'maximum_quantity' => $request->maximum_quantity,
                'product_id' => $request->product_id
                
            ]);
    
            return response()->json(['message' => 'stock successfully Placed', 'order' => $stock], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something Wwent Wrong: ' . $e->getMessage()], 500);
        }
    }

        /**
 * @OA\Get(
 *     path="/api/stocks",
 *     tags={"stocks"},
 *     summary="Get all stocks",
 *     description="Endpoint to retrieve a list of all stocks.",
 *     @OA\Response(
 *         response="200",
 *         description="List of notifications"
 *     )
 * )
 */

    public function show(Request $request,  Response $response)
    {
        $stocks = $this->stock::all();
        
        if ($stocks->isEmpty()){
            return response()->json(['message' => 'No stocks found'], 404);
        }
        return response()->json($stocks);
    }

    public function select(Request $request, Stock $stock)
    {
        $stocks = $this->stock::find($stock);
    
        if ($stocks->isEmpty()) {
            // If no results found, return a response indicating no results
            return response()->json(['status' => 404,
            'message' => 'No Order Found'], 404);
        }
    
        // If results found, return them as JSON
        return response()->json($stocks);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

 /**
 * @OA\Put(
 *     path="/api/stocks/{stock_id}",
 *     tags={"stocks"},
 *     summary="Update stock details",
 *     description="Endpoint to update stock details.",
 *     @OA\Parameter(
 *         name="stock_id",
 *         in="path",
 *         required=true,
 *         description="ID of the stock to update",
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
 *                 property="product_id",
 *                 type="integer",
 *                 description="The ID of the product for which the stock is intended"
 *             ),
 *             @OA\Property(
 *                 property="quantity",
 *                 type="integer",
 *                 description="The quantity of the stock"
 *             ),
 *             @OA\Property(
 *                 property="minimum_quantity",
 *                 type="integer",
 *                 description="The minimum quantity of the stock"
 *             ),
 *             @OA\Property(
 *                 property="maximum_quantity",
 *                 type="integer",
 *                 description="The maximum quantity of the stock"
 *             ),
 *             @OA\Property(
 *                 property="created_at",
 *                 type="string",
 *                 format="date-time",
 *                 description="The creation date and time of the stock"
 *             ),
 *             @OA\Property(
 *                 property="updated_at",
 *                 type="string",
 *                 format="date-time",
 *                 description="The last update date and time of the stock"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Notification details updated successfully"
 *     ),
 *     @OA\Response(
 *         response="400",
 *         description="Bad request, validation failed"
 *     )
 * )
 */

    public function update(Request $request, Stock $stock_id)
    {
        try {
            $stock_id->update($request->only(['quantity','minimum_quantity','maximum_quantity','product_id']));
            return response()->json(['message' => 'stock updated successfully', 'stock' => $stock_id]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update stock: ' . $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Delete(
 *     path="/api/stocks/{stock_id}",
 *     tags={"stocks"},
 *     summary="Delete a stock",
 *     description="Endpoint to delete a notification by ID.",
 *     @OA\Parameter(
 *         name="stock_id",
 *         in="path",
 *         required=true,
 *         description="ID of the stock to delete",
 *         @OA\Schema(
 *             type="integer",
 *             format="int64"
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Notification deleted successfully"
 *     ),
 *     @OA\Response(
 *         response="404",
 *         description="Notification not found"
 *     )
 * )
 */

    public function destroy(Stock $stock_id)
    {
        try {
            $stock_id->delete();
            return response()->json(['message' => 'stock deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete stock: ' . $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    private Order $order;
   

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    
    public function index()
    {
        $orders = $this->order->all();
        return response()->json($orders);
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
 *     path="/api/orders",
 *     tags={"orders"},
 *     summary="Create a new orders",
 *     description="Endpoint to create a new orders.",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Request Body Description",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="user_id",
 *                 type="integer",
 *                 description="The ID of the user for whom the order is placed"
 *             ),
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 description="The title of the order"
 *             ),
 *             @OA\Property(
 *                 property="total_price",
 *                 type="integer",
 *                 description="The description of the order"
 *             ),
 *             @OA\Property(
 *                 property="created_at",
 *                 type="string",
 *                 format="date-time",
 *                 description="The creation date and time of the order"
 *             ),
 *             @OA\Property(
 *                 property="updated_at",
 *                 type="string",
 *                 format="date-time",
 *                 description="The last update date and time of the order"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="order created successfully"
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
            $order = $this->order->create([
                'total_price' => $request->total_price,
                'status' => $request->status,
                'user_id' => $request->user_id
                
            ]);
    
            return response()->json(['message' => 'Order successfully Placed', 'order' => $order], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something Wwent Wrong: ' . $e->getMessage()], 500);
        }
    }
        /**
 * @OA\Get(
 *     path="/api/orders",
 *     tags={"orders"},
 *     summary="Get all orders",
 *     description="Endpoint to retrieve a list of all orders.",
 *     @OA\Response(
 *         response="200",
 *         description="List of orders"
 *     )
 * )
 */
    public function show(Request $request,  Response $response)
    {
        $orders = $this->order::all();
        
        if ($orders->isEmpty()){
            return response()->json(['message' => 'No Orders found'], 404);
        }
        return response()->json($orders);
    }



    public function select(Request $request, Order $order)
    {
        $orders = $this->order::find($order);
    
        if ($orders->isEmpty()) {
            // If no results found, return a response indicating no results
            return response()->json(['status' => 404,
            'message' => 'No Order Found'], 404);
        }
    
        // If results found, return them as JSON
        return response()->json($orders);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
 * @OA\Put(
 *     path="/api/orders/{order_id}",
 *     tags={"orders"},
 *     summary="Update order details",
 *     description="Endpoint to update order details.",
 *     @OA\Parameter(
 *         name="order_id",
 *         in="path",
 *         required=true,
 *         description="ID of the order to update",
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
 *                 property="user_id",
 *                 type="integer",
 *                 description="The ID of the user for whom the order is placed"
 *             ),
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 description="The title of the order"
 *             ),
 *             @OA\Property(
 *                 property="total_price",
 *                 type="integer",
 *                 description="The description of the order"
 *             ),
 *             @OA\Property(
 *                 property="created_at",
 *                 type="string",
 *                 format="date-time",
 *                 description="The creation date and time of the order"
 *             ),
 *             @OA\Property(
 *                 property="updated_at",
 *                 type="string",
 *                 format="date-time",
 *                 description="The last update date and time of the order"
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
    public function update(Request $request, Order $order_id)
    {
        try {
            $order_id->update($request->only(['total_price', 'status']));
            return response()->json(['message' => 'order updated successfully', 'order' => $order_id]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update order: ' . $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Delete(
 *     path="/api/orders/{order_id}",
 *     tags={"orders"},
 *     summary="Delete a order",
 *     description="Endpoint to delete a notification by ID.",
 *     @OA\Parameter(
 *         name="order_id",
 *         in="path",
 *         required=true,
 *         description="ID of the order to delete",
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
    public function destroy(Order $order_id)
    {
        try {
            $order_id->delete();
            return response()->json(['message' => 'Order deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete order: ' . $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Notifiaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class NotifiactionController extends Controller
{
    private Notifiaction $notifiaction;

    public function __construct(Notifiaction $notifiaction)
    {
        $this->notifiaction = $notifiaction;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifiactions = $this->notifiaction->all();
        return response()->json($notifiactions);
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
 *     path="/api/notifiactions",
 *     tags={"notifiactions"},
 *     summary="Create a new notifiactions",
 *     description="Endpoint to create a new notifiactions.",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Request Body Description",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="user_id",
 *                 type="integer",
 *                 description="The ID of the user receiving the notifiactions"
 *             ),
 *             @OA\Property(
 *                 property="title",
 *                 type="string",
 *                 description="The title of the notification"
 *             ),
 *             @OA\Property(
 *                 property="description",
 *                 type="string",
 *                 description="The description of the notification"
 *             ),
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 description="The roles to which the notification is targeted"
 *             ),
 *             @OA\Property(
 *                 property="id",
 *                 type="integer",
 *                 description="The roles to which the notification is targeted"
 *             ),
 *             @OA\Property(
 *                 property="created_at",
 *                 type="date",
 *                 description="The roles to which the notification is targeted"
 *             ),
 *             @OA\Property(
 *                 property="updated_at",
 *                 type="date",
 *                 description="The roles to which the notification is targeted"
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
            $notifiaction = $this->notifiaction->create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'user_id' => $request->user_id

            ]);

            return response()->json(['message' => 'Notifiaction successfully Posted', 'order' => $notifiaction], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something Wwent Wrong: ' . $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/api/notifiactions",
 *     tags={"notifiactions"},
 *     summary="Get all notifiactions",
 *     description="Endpoint to retrieve a list of all notifications.",
 *     @OA\Response(
 *         response="200",
 *         description="List of notifications"
 *     )
 * )
 */


    public function show(Notifiaction $notifiaction)
    {
        $notifiactions = $this->notifiaction::all();

        if ($notifiactions->isEmpty()) {
            return response()->json(['message' => 'No Notifiactions found'], 404);
        }
        return response()->json($notifiactions);
    }


    public function select(Request $request, Notifiaction $notifiaction)
    {
        $notifiactions = $this->notifiaction::find($notifiaction);

        if ($notifiactions->isEmpty()) {
            // If no results found, return a response indicating no results
            return response()->json([
                'status' => 404,
                'message' => 'No Notifiaction Found'
            ], 404);
        }

        // If results found, return them as JSON
        return response()->json($notifiactions);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notifiaction $notifiaction)
    {
        //
    }

/**
 * @OA\Put(
 *     path="/api/notifiactions/{notifiaction_id}",
 *     tags={"notifiactions"},
 *     summary="Update notifiaction details",
 *     description="Endpoint to update notifiaction details.",
 *     @OA\Parameter(
 *         name="notifiaction_id",
 *         in="path",
 *         required=true,
 *         description="ID of the notifiaction to update",
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
 *                 description="The ID of the user for whom the notification is intended"
 *             ),
 *             @OA\Property(
 *                 property="title",
 *                 type="string",
 *                 description="The title of the notification"
 *             ),
 *             @OA\Property(
 *                 property="description",
 *                 type="string",
 *                 description="The description of the notification"
 *             ),
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 description="The status of the notification"
 *             ),
 *             @OA\Property(
 *                 property="created_at",
 *                 type="string",
 *                 format="date-time",
 *                 description="The creation date and time of the notification"
 *             ),
 *             @OA\Property(
 *                 property="updated_at",
 *                 type="string",
 *                 format="date-time",
 *                 description="The last update date and time of the notification"
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



    public function update(Request $request, Notifiaction $notifiaction_id)
    {
        try {
            $notifiaction_id->update($request->only(['title', 'status', 'description']));
            return response()->json(['message' => 'notifiaction updated successfully', 'order' => $notifiaction_id]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update notifiaction: ' . $e->getMessage()], 500);
        }
    }

/**
 * @OA\Delete(
 *     path="/api/notifiactions/{notifiaction_id}",
 *     tags={"notifiactions"},
 *     summary="Delete a notifiaction",
 *     description="Endpoint to delete a notification by ID.",
 *     @OA\Parameter(
 *         name="notifiaction_id",
 *         in="path",
 *         required=true,
 *         description="ID of the notification to delete",
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



    public function destroy(Notifiaction $notifiaction_id)
    {
        try {
            $notifiaction_id->delete();
            return response()->json(['message' => 'Notifiaction deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete notifiaction: ' . $e->getMessage()], 500);
        }
    }
}

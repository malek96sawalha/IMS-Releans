<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private User $user;


    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function index()
    {
        $users = $this->user->all();
        return response()->json($users);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     tags={"users"},
     *     summary="Create a new users",
     *     description="Endpoint to create a new users.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="The name of the user"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 description="The email of the user"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 description="The password pf the user account"
     *             ),
     *             @OA\Property(
     *                 property="role",
     *                 type="string",
     *                 description="The role of the user"
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => ['required', 'email', 'unique:users', 'regex:/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
            'role' => 'required|string',
        ]);

        if ($validator->fails()) {

            // Return response with validation errors
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 400);
        }
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password')); // Hash the password
        $user->role = $request->input('role');

        // Save the user to the database
        $user->save();
        return response()->json(['message' => 'success'], 200);

        try {
            // Your existing code...
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create user: ' . $e->getMessage()], 500);
        }
    }



    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"users"},
     *     summary="Get all users",
     *     description="Endpoint to retrieve a list of all users.",
     *     @OA\Response(
     *         response="200",
     *         description="List of users"
     *     )
     * )
     */


    public function show(Request $request,  Response $response)
    {
        $users = $this->user::all();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No Users found'], 404);
        }
        return response()->json($users);
    }



    public function select(Request $request, User $user)
    {
        $users = $this->user::find($user);

        if ($users->isEmpty()) {
            // If no results found, return a response indicating no results
            return response()->json([
                'status' => 404,
                'message' => 'No Order Found'
            ], 404);
        }

        // If results found, return them as JSON
        return response()->json($users);
    }


    /**
     * @OA\Put(
     *     path="/api/users/{user_id}",
     *     tags={"users"},
     *     summary="Update user details",
     *     description="Endpoint to update user details.",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="ID of the user to update",
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
     *                 description="The name of the user"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 description="The email of the user"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 description="The password of the user account"
     *             ),
     *             @OA\Property(
     *                 property="role",
     *                 type="string",
     *                 description="The role of the user (e.g., administrator, manager, user)"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="User details updated successfully"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad request, validation failed"
     *     )
     * )
     */

     public function update(Request $request, $user_id)
     {
         try {
             // Find the user by user_id
             $user = User::find($user_id);
     
             // Check if the user exists
             if (!$user) {
                 return response()->json(['message' => 'User not found'], 404);
             }
     
             // Validate the request data
             $validator = Validator::make($request->all(), [
                 'name' => 'required|string',
                 'email' => ['required', 'email', Rule::unique('users')->ignore($user_id), 'regex:/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/'],
                 'password' => 'nullable|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                 'role' => 'required|string',
             ]);
     
             // Check if validation fails
             if ($validator->fails()) {
                 return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 400);
             }
     
             // Update user data
             $user->name = $request->input('name');
             $user->email = $request->input('email');
             
             // Check if password is provided and update it
             if ($request->has('password')) {
                 $user->password = bcrypt($request->input('password'));
             }
             
             $user->role = $request->input('role');
     
             // Save the updated user data
             $user->save();
     
             // Return success response
             return response()->json(['message' => 'User data updated successfully', 'user' => $user]);
         } catch (\Exception $e) {
             // Return error response if an exception occurs
             return response()->json(['message' => 'Failed to update data: ' . $e->getMessage()], 500);
         }
     }
     


    /**
     * @OA\Delete(
     *     path="/api/users/{user_id}",
     *     tags={"users"},
     *     summary="Delete a user",
     *     description="Endpoint to delete a user by ID.",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="ID of the user to delete",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="user deleted successfully"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="user not found"
     *     )
     * )
     */

    public function destroy($user_id)
    {
        try {
            $user = User::find($user_id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            if ($user->delete()) {
                return response()->json(['message' => 'User deleted successfully']);
            } else {
                return response()->json(['message' => 'Failed to delete user']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete user: ' . $e->getMessage()], 500);
        }
    }
}

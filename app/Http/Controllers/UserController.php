<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        $data = [
            'status' => 'success',
            'message' => 'User data retrieved successfully',
            'data' => $users
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            $data = [
                'status' => 'error',
                'message' => 'Validation error',
                'data' => $validator->errors()
            ];
            return response()->json($data, 422);
        }

        $request->merge([
            'password' => Hash::make(trim($request->password))
        ]);
        $user = User::create($request->all());

        $data = [
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => $user
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if ($user) {
            $data = [
                'status' => 'success',
                'message' => 'User retrieved successfully',
                'data' => $user
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 'error',
                'message' => 'User not found',
                'data' => null
            ];
            return response()->json($data, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if ($user) {
            $validator = Validator::make($request->all(), [
                'name' => 'string|max:255',
                'email' => 'string|email|max:255|unique:users',
                'password' => 'string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                $data = [
                    'status' => 'error',
                    'message' => 'Validation error',
                    'data' => $validator->errors()
                ];
                return response()->json($data, 422);
            }

            if ($request->has('password') && !empty($request->password)) {
                $request->merge([
                    'password' => Hash::make(trim($request->password))
                ]);
            } else {
                $request->request->remove('password');
            }

            $user->update($request->all());

            $data = [
                'status' => 'success',
                'message' => 'User updated successfully',
                'data' => $user
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 'error',
                'message' => 'User not found',
                'data' => null
            ];
            return response()->json($data, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();

            $data = [
                'status' => 'success',
                'message' => 'User deleted successfully',
                'data' => null
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 'error',
                'message' => 'User not found',
                'data' => null
            ];
            return response()->json($data, 404);
        }
    }
}

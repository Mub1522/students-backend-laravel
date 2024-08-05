<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::latest()->get();

        $data = [
            'status' => 'success',
            'message' => 'Students retrieved successfully',
            'data' => $students
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $data = [
                'status' => 'error',
                'message' => 'Validation error',
                'data' => $validator->errors()
            ];
            return response()->json($data, 422);
        }

        $student = Student::create($request->all());

        $data = [
            'status' => 'success',
            'message' => 'Estudiante creado correctamente',
            'data' => $student
        ];
        return response()->json($data, 201);
    }

    /**
     * Show the specified resource in storage.
     */
    public function show(string $id)
    {
        $student = Student::find($id);

        if ($student) {
            $data = [
                'status' => 'success',
                'message' => 'Student retrieved successfully',
                'data' => $student
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Student not found',
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
        $student = Student::find($id);

        if ($student) {
            $validator = Validator::make($request->all(), [
                'first_name' => 'string|max:255',
                'last_name' => 'string|max:255',
            ]);

            if ($validator->fails()) {
                $data = [
                    'status' => 'error',
                    'message' => 'Validation error',
                    'data' => $validator->errors()
                ];
                return response()->json($data, 422);
            }

            $student->update($request->all());

            $data = [
                'status' => 'success',
                'message' => 'Estudiante actualizado correctamente',
                'data' => $student
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Estudiante no encontrado',
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
        $student = Student::find($id);

        if ($student) {
            $student->delete();

            $data = [
                'status' => 'success',
                'message' => 'Estudiante eliminado correctamente',
                'data' => null
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Estudiante no encontrado',
                'data' => null
            ];
            return response()->json($data, 404);
        }
    }
}

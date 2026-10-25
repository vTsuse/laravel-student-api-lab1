<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // GET /api/students
    public function index()
    {
        return response()->json(
            Student::latest()->get()
        );
    }

    // POST /api/students
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students',
            'course' => 'required|string|max:255',
        ]);

        $student = Student::create($validated);
        return response()->json($student, 201);
    }

    // GET /api/students/{student}
    public function show(Student $student)
    {
        return response()->json($student);
    }

    // PUT/PATCH /api/students/{student}
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255|unique:students,email,' . $student->id,
            'course' => 'sometimes|required|string|max:255',
        ]);

        $student->update($validated);
        return response()->json($student);
    }

    // DELETE /api/students/{student}
    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json([
            'message' => 'Student deleted successfully.'
        ]);
    }
}
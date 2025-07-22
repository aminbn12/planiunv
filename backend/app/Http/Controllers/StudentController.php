<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->get()->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->user->name,
                'email' => $student->user->email,
                'role' => 'student',
                'year' => $student->year,
                'average' => $student->average,
                'status' => $student->status,
                'phone' => $student->user->phone,
                'enrollmentDate' => $student->enrollment_date->format('Y-m-d'),
            ];
        });

        return response()->json($students);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'year' => 'required|string',
            'phone' => 'nullable|string',
            'enrollmentDate' => 'required|date',
            'status' => 'required|in:active,inactive,graduated',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password123'),
                'role' => 'student',
                'phone' => $request->phone,
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'student_id' => 'UM6D' . date('Y') . str_pad($user->id, 3, '0', STR_PAD_LEFT),
                'year' => $request->year,
                'status' => $request->status,
                'enrollment_date' => $request->enrollmentDate,
                'average' => $request->average ?? 0,
            ]);

            DB::commit();

            return response()->json([
                'id' => $student->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => 'student',
                'year' => $student->year,
                'average' => $student->average,
                'status' => $student->status,
                'phone' => $user->phone,
                'enrollmentDate' => $student->enrollment_date->format('Y-m-d'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Erreur lors de la création de l\'étudiant'], 500);
        }
    }

    public function show($id)
    {
        $student = Student::with('user')->findOrFail($id);

        return response()->json([
            'id' => $student->id,
            'name' => $student->user->name,
            'email' => $student->user->email,
            'role' => 'student',
            'year' => $student->year,
            'average' => $student->average,
            'status' => $student->status,
            'phone' => $student->user->phone,
            'enrollmentDate' => $student->enrollment_date->format('Y-m-d'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $student = Student::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->user->id,
            'year' => 'required|string',
            'phone' => 'nullable|string',
            'status' => 'required|in:active,inactive,graduated',
        ]);

        DB::beginTransaction();
        try {
            $student->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            $student->update([
                'year' => $request->year,
                'status' => $request->status,
                'average' => $request->average ?? $student->average,
            ]);

            DB::commit();

            return response()->json([
                'id' => $student->id,
                'name' => $student->user->name,
                'email' => $student->user->email,
                'role' => 'student',
                'year' => $student->year,
                'average' => $student->average,
                'status' => $student->status,
                'phone' => $student->user->phone,
                'enrollmentDate' => $student->enrollment_date->format('Y-m-d'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Erreur lors de la mise à jour de l\'étudiant'], 500);
        }
    }

    public function destroy($id)
    {
        $student = Student::with('user')->findOrFail($id);
        
        DB::beginTransaction();
        try {
            $student->user->delete(); // Cascade delete will handle student record
            DB::commit();
            
            return response()->json(['message' => 'Étudiant supprimé avec succès']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Erreur lors de la suppression de l\'étudiant'], 500);
        }
    }
}
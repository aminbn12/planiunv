<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProfessorController extends Controller
{
    public function index()
    {
        $professors = Professor::with('user', 'courses')->get()->map(function ($professor) {
            return [
                'id' => $professor->id,
                'name' => $professor->user->name,
                'email' => $professor->user->email,
                'role' => 'professor',
                'specialty' => $professor->specialty,
                'department' => $professor->department,
                'courses' => $professor->courses->pluck('name')->toArray(),
                'hireDate' => $professor->hire_date->format('Y-m-d'),
            ];
        });

        return response()->json($professors);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'specialty' => 'required|string',
            'department' => 'required|string',
            'hireDate' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password123'),
                'role' => 'professor',
            ]);

            $professor = Professor::create([
                'user_id' => $user->id,
                'employee_id' => 'UM6D-PROF-' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
                'specialty' => $request->specialty,
                'department' => $request->department,
                'hire_date' => $request->hireDate,
            ]);

            DB::commit();

            return response()->json([
                'id' => $professor->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => 'professor',
                'specialty' => $professor->specialty,
                'department' => $professor->department,
                'courses' => [],
                'hireDate' => $professor->hire_date->format('Y-m-d'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Erreur lors de la création du professeur'], 500);
        }
    }

    public function show($id)
    {
        $professor = Professor::with('user', 'courses')->findOrFail($id);

        return response()->json([
            'id' => $professor->id,
            'name' => $professor->user->name,
            'email' => $professor->user->email,
            'role' => 'professor',
            'specialty' => $professor->specialty,
            'department' => $professor->department,
            'courses' => $professor->courses->pluck('name')->toArray(),
            'hireDate' => $professor->hire_date->format('Y-m-d'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $professor = Professor::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $professor->user->id,
            'specialty' => 'required|string',
            'department' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $professor->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $professor->update([
                'specialty' => $request->specialty,
                'department' => $request->department,
            ]);

            DB::commit();

            return response()->json([
                'id' => $professor->id,
                'name' => $professor->user->name,
                'email' => $professor->user->email,
                'role' => 'professor',
                'specialty' => $professor->specialty,
                'department' => $professor->department,
                'courses' => $professor->courses->pluck('name')->toArray(),
                'hireDate' => $professor->hire_date->format('Y-m-d'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Erreur lors de la mise à jour du professeur'], 500);
        }
    }

    public function destroy($id)
    {
        $professor = Professor::with('user')->findOrFail($id);
        
        DB::beginTransaction();
        try {
            $professor->user->delete();
            DB::commit();
            
            return response()->json(['message' => 'Professeur supprimé avec succès']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Erreur lors de la suppression du professeur'], 500);
        }
    }
}
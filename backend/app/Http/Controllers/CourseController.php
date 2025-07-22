<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Professor;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('professor.user')->get()->map(function ($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
                'professor' => $course->professor->user->name,
                'professorId' => $course->professor_id,
                'year' => $course->year,
                'day' => $course->day,
                'time' => $course->time->format('H:i'),
                'duration' => $course->duration,
                'room' => $course->room,
                'maxStudents' => $course->max_students,
                'enrolledStudents' => $course->enrolled_students,
                'date' => $course->date->format('Y-m-d'),
            ];
        });

        return response()->json($courses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'professorId' => 'required|exists:professors,id',
            'year' => 'required|string',
            'day' => 'required|string',
            'time' => 'required|string',
            'duration' => 'required|integer|min:30',
            'room' => 'nullable|string',
            'maxStudents' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);

        $course = Course::create([
            'name' => $request->name,
            'professor_id' => $request->professorId,
            'year' => $request->year,
            'day' => $request->day,
            'time' => $request->time,
            'duration' => $request->duration,
            'room' => $request->room,
            'max_students' => $request->maxStudents,
            'enrolled_students' => $request->enrolledStudents ?? 0,
            'date' => $request->date,
        ]);

        $course->load('professor.user');

        return response()->json([
            'id' => $course->id,
            'name' => $course->name,
            'professor' => $course->professor->user->name,
            'professorId' => $course->professor_id,
            'year' => $course->year,
            'day' => $course->day,
            'time' => $course->time->format('H:i'),
            'duration' => $course->duration,
            'room' => $course->room,
            'maxStudents' => $course->max_students,
            'enrolledStudents' => $course->enrolled_students,
            'date' => $course->date->format('Y-m-d'),
        ], 201);
    }

    public function show($id)
    {
        $course = Course::with('professor.user')->findOrFail($id);

        return response()->json([
            'id' => $course->id,
            'name' => $course->name,
            'professor' => $course->professor->user->name,
            'professorId' => $course->professor_id,
            'year' => $course->year,
            'day' => $course->day,
            'time' => $course->time->format('H:i'),
            'duration' => $course->duration,
            'room' => $course->room,
            'maxStudents' => $course->max_students,
            'enrolledStudents' => $course->enrolled_students,
            'date' => $course->date->format('Y-m-d'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'professorId' => 'required|exists:professors,id',
            'year' => 'required|string',
            'day' => 'required|string',
            'time' => 'required|string',
            'duration' => 'required|integer|min:30',
            'room' => 'nullable|string',
            'maxStudents' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);

        $course->update([
            'name' => $request->name,
            'professor_id' => $request->professorId,
            'year' => $request->year,
            'day' => $request->day,
            'time' => $request->time,
            'duration' => $request->duration,
            'room' => $request->room,
            'max_students' => $request->maxStudents,
            'enrolled_students' => $request->enrolledStudents ?? $course->enrolled_students,
            'date' => $request->date,
        ]);

        $course->load('professor.user');

        return response()->json([
            'id' => $course->id,
            'name' => $course->name,
            'professor' => $course->professor->user->name,
            'professorId' => $course->professor_id,
            'year' => $course->year,
            'day' => $course->day,
            'time' => $course->time->format('H:i'),
            'duration' => $course->duration,
            'room' => $course->room,
            'maxStudents' => $course->max_students,
            'enrolledStudents' => $course->enrolled_students,
            'date' => $course->date->format('Y-m-d'),
        ]);
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json(['message' => 'Cours supprimé avec succès']);
    }
}
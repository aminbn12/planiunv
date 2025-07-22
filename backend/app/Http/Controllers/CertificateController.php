<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Student;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with('student.user')->get()->map(function ($certificate) {
            return [
                'id' => $certificate->id,
                'studentId' => $certificate->student_id,
                'studentName' => $certificate->student->user->name,
                'type' => $certificate->type,
                'status' => $certificate->status,
                'requestDate' => $certificate->request_date->format('Y-m-d'),
                'completionDate' => $certificate->completion_date?->format('Y-m-d'),
                'reason' => $certificate->reason,
                'copies' => $certificate->copies,
            ];
        });

        return response()->json($certificates);
    }

    public function store(Request $request)
    {
        $request->validate([
            'studentId' => 'required|exists:students,id',
            'type' => 'required|in:inscription,reussite,notes,stage',
            'reason' => 'nullable|string',
            'copies' => 'required|integer|min:1|max:10',
        ]);

        $student = Student::with('user')->findOrFail($request->studentId);

        $certificate = Certificate::create([
            'student_id' => $request->studentId,
            'type' => $request->type,
            'status' => 'pending',
            'request_date' => now(),
            'reason' => $request->reason,
            'copies' => $request->copies,
        ]);

        return response()->json([
            'id' => $certificate->id,
            'studentId' => $certificate->student_id,
            'studentName' => $student->user->name,
            'type' => $certificate->type,
            'status' => $certificate->status,
            'requestDate' => $certificate->request_date->format('Y-m-d'),
            'completionDate' => $certificate->completion_date?->format('Y-m-d'),
            'reason' => $certificate->reason,
            'copies' => $certificate->copies,
        ], 201);
    }

    public function show($id)
    {
        $certificate = Certificate::with('student.user')->findOrFail($id);

        return response()->json([
            'id' => $certificate->id,
            'studentId' => $certificate->student_id,
            'studentName' => $certificate->student->user->name,
            'type' => $certificate->type,
            'status' => $certificate->status,
            'requestDate' => $certificate->request_date->format('Y-m-d'),
            'completionDate' => $certificate->completion_date?->format('Y-m-d'),
            'reason' => $certificate->reason,
            'copies' => $certificate->copies,
        ]);
    }

    public function update(Request $request, $id)
    {
        $certificate = Certificate::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,processing,ready,delivered',
        ]);

        $updateData = ['status' => $request->status];
        
        if ($request->status === 'ready' && !$certificate->completion_date) {
            $updateData['completion_date'] = now();
        }

        $certificate->update($updateData);

        $certificate->load('student.user');

        return response()->json([
            'id' => $certificate->id,
            'studentId' => $certificate->student_id,
            'studentName' => $certificate->student->user->name,
            'type' => $certificate->type,
            'status' => $certificate->status,
            'requestDate' => $certificate->request_date->format('Y-m-d'),
            'completionDate' => $certificate->completion_date?->format('Y-m-d'),
            'reason' => $certificate->reason,
            'copies' => $certificate->copies,
        ]);
    }

    public function destroy($id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->delete();

        return response()->json(['message' => 'Demande d\'attestation supprimée avec succès']);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Professor;
use App\Models\Course;
use App\Models\Event;
use App\Models\Certificate;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Dr. Ahmed Ben Ali',
            'email' => 'admin@um6d.ma',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '0661234567',
        ]);

        // Create Professor Users
        $prof1 = User::create([
            'name' => 'Dr. Hassan Alami',
            'email' => 'hassan.alami@um6d.ma',
            'password' => Hash::make('password123'),
            'role' => 'professor',
            'phone' => '0662345678',
        ]);

        $prof2 = User::create([
            'name' => 'Prof. Fatima Zahra',
            'email' => 'fatima.zahra@um6d.ma',
            'password' => Hash::make('password123'),
            'role' => 'professor',
            'phone' => '0663456789',
        ]);

        $prof3 = User::create([
            'name' => 'Dr. Mohamed Tazi',
            'email' => 'mohamed.tazi@um6d.ma',
            'password' => Hash::make('password123'),
            'role' => 'professor',
            'phone' => '0664567890',
        ]);

        // Create Professor records
        $professor1 = Professor::create([
            'user_id' => $prof1->id,
            'employee_id' => 'UM6D-PROF-001',
            'specialty' => 'Cardiologie',
            'department' => 'Médecine Interne',
            'hire_date' => '2018-09-01',
        ]);

        $professor2 = Professor::create([
            'user_id' => $prof2->id,
            'employee_id' => 'UM6D-PROF-002',
            'specialty' => 'Pédiatrie',
            'department' => 'Pédiatrie',
            'hire_date' => '2015-09-01',
        ]);

        $professor3 = Professor::create([
            'user_id' => $prof3->id,
            'employee_id' => 'UM6D-PROF-003',
            'specialty' => 'Chirurgie',
            'department' => 'Chirurgie',
            'hire_date' => '2020-09-01',
        ]);

        // Create Student Users
        $student1 = User::create([
            'name' => 'Marie Dupont',
            'email' => 'marie.dupont@um6d.ma',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'phone' => '0612345678',
        ]);

        $student2 = User::create([
            'name' => 'Ahmed Ben Ali',
            'email' => 'ahmed.benali@um6d.ma',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'phone' => '0623456789',
        ]);

        $student3 = User::create([
            'name' => 'Sarah Martin',
            'email' => 'sarah.martin@um6d.ma',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'phone' => '0634567890',
        ]);

        // Create Student records
        Student::create([
            'user_id' => $student1->id,
            'student_id' => 'UM6D2021001',
            'year' => '3ème année',
            'average' => 15.2,
            'status' => 'active',
            'enrollment_date' => '2021-09-15',
        ]);

        Student::create([
            'user_id' => $student2->id,
            'student_id' => 'UM6D2020001',
            'year' => '4ème année',
            'average' => 14.8,
            'status' => 'active',
            'enrollment_date' => '2020-09-15',
        ]);

        Student::create([
            'user_id' => $student3->id,
            'student_id' => 'UM6D2022001',
            'year' => '2ème année',
            'average' => 16.1,
            'status' => 'active',
            'enrollment_date' => '2022-09-15',
        ]);

        // Create Courses
        Course::create([
            'name' => 'Cardiologie Clinique',
            'professor_id' => $professor1->id,
            'year' => '4ème année',
            'day' => 'Lundi',
            'time' => '09:00',
            'duration' => 120,
            'room' => 'Amphi A',
            'max_students' => 80,
            'enrolled_students' => 75,
            'date' => '2024-01-15',
        ]);

        Course::create([
            'name' => 'Pédiatrie Générale',
            'professor_id' => $professor2->id,
            'year' => '3ème année',
            'day' => 'Mardi',
            'time' => '14:00',
            'duration' => 90,
            'room' => 'Salle 201',
            'max_students' => 50,
            'enrolled_students' => 48,
            'date' => '2024-01-16',
        ]);

        Course::create([
            'name' => 'Chirurgie Générale',
            'professor_id' => $professor3->id,
            'year' => '5ème année',
            'day' => 'Mercredi',
            'time' => '10:00',
            'duration' => 150,
            'room' => 'Bloc Opératoire',
            'max_students' => 25,
            'enrolled_students' => 22,
            'date' => '2024-01-17',
        ]);

        // Create Events
        Event::create([
            'title' => 'Réunion pédagogique',
            'description' => 'Réunion mensuelle du conseil pédagogique',
            'date' => '2024-01-15',
            'time' => '14:00',
            'location' => 'Salle de conférence',
            'type' => 'meeting',
            'organizer' => 'Dr. Ahmed Ben Ali',
        ]);

        Event::create([
            'title' => 'Examens finaux',
            'description' => 'Session d\'examens de fin de semestre',
            'date' => '2024-01-20',
            'time' => '08:00',
            'location' => 'Toutes les salles',
            'type' => 'exam',
            'organizer' => 'Administration',
        ]);

        Event::create([
            'title' => 'Conférence médicale',
            'description' => 'Conférence sur les nouvelles technologies médicales',
            'date' => '2024-02-10',
            'time' => '15:00',
            'location' => 'Amphithéâtre principal',
            'type' => 'conference',
            'organizer' => 'Prof. Sarah Martin',
        ]);

        // Create Certificates
        Certificate::create([
            'student_id' => 1,
            'type' => 'inscription',
            'status' => 'pending',
            'request_date' => '2024-01-10',
            'reason' => 'Demande de bourse',
            'copies' => 2,
        ]);

        Certificate::create([
            'student_id' => 2,
            'type' => 'reussite',
            'status' => 'processing',
            'request_date' => '2024-01-08',
            'reason' => 'Candidature master',
            'copies' => 1,
        ]);

        Certificate::create([
            'student_id' => 3,
            'type' => 'notes',
            'status' => 'ready',
            'request_date' => '2024-01-05',
            'completion_date' => '2024-01-12',
            'reason' => 'Transfert universitaire',
            'copies' => 3,
        ]);
    }
}
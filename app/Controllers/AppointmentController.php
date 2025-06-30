<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AppointmentModel;
use App\Models\StudentModel;
use App\Models\UserModel;

class AppointmentController extends BaseController
{
    public function index()
    {
        $appointmentModel = new AppointmentModel();
        $studentModel = new StudentModel();
        $userModel = new UserModel();

        // Jika Guru BK, filter hanya jadwal miliknya
        $userId = session('user_id');
        $role = session('role');
        if ($role === 'guru_bk') {
            $appointments = $appointmentModel->where('counselor_id', $userId)->orderBy('appointment_date', 'DESC')->findAll();
        } else {
            $appointments = $appointmentModel->orderBy('appointment_date', 'DESC')->findAll();
        }

        // Ambil nama siswa dan guru
        foreach ($appointments as &$a) {
            $student = $studentModel->find($a['student_id']);
            $a['student_name'] = $student['name'] ?? '-';
            $guru = $userModel->find($a['counselor_id']);
            $a['guru_name'] = $guru['full_name'] ?? '-';
        }

        return view('appointments/index', ['appointments' => $appointments]);
    }
}

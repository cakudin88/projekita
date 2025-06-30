<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class StudentsController extends BaseController
{
    public function index()
    {
        $studentModel = new \App\Models\StudentModel();
        $students = $studentModel->getStudentsWithClass();
        return view('students/index', ['students' => $students]);
    }

    // Endpoint untuk detail siswa (AJAX/modal)
    public function detail($id)
    {
        $studentModel = new \App\Models\StudentModel();
        $counselingModel = new \App\Models\CounselingModel();
        $student = $studentModel->getStudentWithUser($id);
        if (!$student) {
            return '<div class="alert alert-danger">Data siswa tidak ditemukan.</div>';
        }
        // Ambil riwayat konseling siswa
        $sessions = $counselingModel->where('student_id', $id)->orderBy('session_date', 'DESC')->findAll(5);
        // Render detail + rekap naratif
        $detail = view('students/detail_modal', ['student' => $student]);
        $rekap = view('students/rekap_naratif', ['student' => $student, 'sessions' => $sessions]);
        return $detail . '<hr>' . $rekap;
    }
}

<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CounselingRequestModel;
use App\Models\StudentModel;

class CounselingRequestController extends BaseController
{
    public function approve($id)
    {
        $model = new CounselingRequestModel();
        $request = $model->find($id);
        if (!$request || $request['status'] !== 'pending') {
            return redirect()->back()->with('error', 'Permintaan tidak valid atau sudah diproses.');
        }

        // Update status permintaan
        $model->update($id, [
            'status' => 'approved',
            'approved_by' => session()->get('user_id'),
            'approved_at' => date('Y-m-d H:i:s'),
        ]);

        // Integrasi ke jadwal konseling (appointments) & sesi konseling (counseling_sessions)
        $student_id = $request['student_id'];
        $counselor_id = session()->get('user_id');
        $appointment_date = date('Y-m-d H:i:s'); // Default: sekarang
        $purpose = $request['description'] ?? $request['theme'];

        // Insert ke tabel appointments
        $appointmentModel = new \App\Models\AppointmentModel();
        $appointmentModel->insert([
            'student_id' => $student_id,
            'counselor_id' => $counselor_id,
            'requested_by' => $request['student_id'],
            'appointment_date' => $appointment_date,
            'purpose' => $purpose,
            'status' => 'approved',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Cari/mapping kategori jika ada (berdasarkan theme)
        $category_id = null;
        if (!empty($request['theme'])) {
            $categoryModel = new \App\Models\CategoryModel();
            $cat = $categoryModel->where('name', $request['theme'])->first();
            if ($cat) {
                $category_id = $cat['id'];
            }
        }

        // Insert ke tabel counseling_sessions
        $counselingModel = new \App\Models\CounselingModel();
        $counselingModel->insert([
            'student_id' => $student_id,
            'counselor_id' => $counselor_id,
            'category_id' => $category_id,
            'title' => $request['theme'] ?? 'Konseling',
            'description' => $request['description'] ?? '-',
            'session_date' => $appointment_date,
            'status' => 'scheduled',
            'created_by' => $counselor_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Permintaan konseling disetujui & jadwal + sesi konseling dibuat.');
    }

    public function decline($id)
    {
        $model = new CounselingRequestModel();
        $request = $model->find($id);
        if (!$request || $request['status'] !== 'pending') {
            return redirect()->back()->with('error', 'Permintaan tidak valid atau sudah diproses.');
        }
        $model->update($id, [
            'status' => 'rejected',
            'approved_by' => session()->get('user_id'),
            'approved_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->back()->with('success', 'Permintaan konseling ditolak.');
    }

    public function index()
    {
        $model = new CounselingRequestModel();
        $studentModel = new StudentModel();
        $requests = $model->orderBy('created_at', 'DESC')->findAll();
        // Join student name
        foreach ($requests as &$req) {
            $student = $studentModel->find($req['student_id']);
            $req['student_name'] = $student['name'] ?? '-';
        }
        return view('counseling_requests/index', ['requests' => $requests]);
    }

    public function create()
    {
        return view('counseling_requests/create');
    }

    public function store()
    {
        $model = new CounselingRequestModel();
        $data = [
            'student_id' => session()->get('student_id'),
            'type' => $this->request->getPost('type'),
            'theme' => $this->request->getPost('theme'),
            'group_name' => $this->request->getPost('group_name'),
            'description' => $this->request->getPost('description'),
            'requested_at' => date('Y-m-d H:i:s'),
            'status' => 'pending',
        ];
        $model->insert($data);
        return redirect()->to('/counseling-requests')->with('success', 'Permintaan konseling berhasil diajukan!');
    }
}

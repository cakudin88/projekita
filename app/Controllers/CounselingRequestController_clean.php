<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CounselingRequestModel;
use App\Models\UserModel;

class CounselingRequestController extends BaseController
{
    protected $requestModel;
    protected $userModel;

    public function __construct()
    {
        $this->requestModel = new CounselingRequestModel();
        $this->userModel = new UserModel();
    }

    /**
     * Check if user has required role
     */
    private function checkRole($allowedRoles)
    {
        $userRole = session()->get('role_name');
        if (!in_array($userRole, $allowedRoles)) {
            throw new \Exception('Akses ditolak. Role Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    /**
     * Display counseling requests list (role-based)
     */
    public function index()
    {
        try {
            $userRole = session()->get('role_name');
            $userId = session()->get('user_id');

            $data = [
                'title' => 'Permintaan Konseling'
            ];

            if ($userRole === 'murid') {
                // Murid hanya bisa melihat permintaan mereka sendiri
                $data['requests'] = $this->requestModel->getStudentRequests($userId);
                $data['can_create'] = true;
                $data['can_manage'] = false;
            } elseif (in_array($userRole, ['guru_bk', 'super_admin', 'kepala_sekolah'])) {
                // Guru BK dapat melihat semua permintaan
                $data['requests'] = $this->requestModel->getRequestsWithDetails();
                $data['can_create'] = false;
                $data['can_manage'] = true;
            } else {
                throw new \Exception('Role Anda tidak memiliki akses ke halaman ini.');
            }

            return view('counseling_requests/index', $data);

        } catch (\Exception $e) {
            log_message('error', 'CounselingRequest Index Error: ' . $e->getMessage());
            return view('counseling_requests/emergency', [
                'title' => 'Error',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show create form (only for students)
     */
    public function create()
    {
        try {
            $this->checkRole(['murid']);

            $data = [
                'title' => 'Ajukan Permintaan Konseling'
            ];

            return view('counseling_requests/create', $data);

        } catch (\Exception $e) {
            return redirect()->to('/counseling-requests')->with('error', $e->getMessage());
        }
    }

    /**
     * Store new counseling request (only for students)
     */
    public function store()
    {
        try {
            $this->checkRole(['murid']);

            $rules = [
                'type' => 'required|in_list[individu,kelompok,klasikal]',
                'theme' => 'required|max_length[255]',
                'description' => 'required'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }

            $data = [
                'student_id' => session()->get('user_id'),
                'type' => $this->request->getPost('type'),
                'theme' => $this->request->getPost('theme'),
                'group_name' => $this->request->getPost('group_name'),
                'description' => $this->request->getPost('description'),
                'status' => CounselingRequestModel::STATUS_PENDING
            ];

            if ($this->requestModel->insert($data)) {
                return redirect()->to('/counseling-requests')
                    ->with('success', 'Permintaan konseling berhasil diajukan! Silakan tunggu persetujuan dari Guru BK.');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal menyimpan permintaan konseling.');
            }

        } catch (\Exception $e) {
            log_message('error', 'CounselingRequest Store Error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi error: ' . $e->getMessage());
        }
    }

    /**
     * Show approve/reject form (only for counselors)
     */
    public function manage($id)
    {
        try {
            $this->checkRole(['guru_bk', 'super_admin']);

            $request = $this->requestModel->getRequestsWithDetails(['counseling_requests.id' => $id]);
            
            if (empty($request)) {
                return redirect()->to('/counseling-requests')
                    ->with('error', 'Permintaan konseling tidak ditemukan.');
            }

            $data = [
                'title' => 'Kelola Permintaan Konseling',
                'request' => $request[0]
            ];

            return view('counseling_requests/manage', $data);

        } catch (\Exception $e) {
            return redirect()->to('/counseling-requests')->with('error', $e->getMessage());
        }
    }

    /**
     * Approve counseling request (only for counselors)
     */
    public function approve($id)
    {
        try {
            $this->checkRole(['guru_bk', 'super_admin']);

            $rules = [
                'counseling_date' => 'required',
                'response_message' => 'permit_empty|max_length[500]'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }

            $counselingDate = $this->request->getPost('counseling_date');
            $responseMessage = $this->request->getPost('response_message');
            $counselorId = session()->get('user_id');

            if ($this->requestModel->approveRequest($id, $counselorId, $counselingDate, $responseMessage)) {
                return redirect()->to('/counseling-requests')
                    ->with('success', 'Permintaan konseling berhasil disetujui dan dijadwalkan.');
            } else {
                return redirect()->back()
                    ->with('error', 'Gagal menyetujui permintaan konseling.');
            }

        } catch (\Exception $e) {
            log_message('error', 'CounselingRequest Approve Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi error: ' . $e->getMessage());
        }
    }

    /**
     * Reject counseling request (only for counselors)
     */
    public function reject($id)
    {
        try {
            $this->checkRole(['guru_bk', 'super_admin']);

            $rules = [
                'rejected_reason' => 'required|max_length[500]'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }

            $rejectedReason = $this->request->getPost('rejected_reason');
            $counselorId = session()->get('user_id');

            if ($this->requestModel->rejectRequest($id, $counselorId, $rejectedReason)) {
                return redirect()->to('/counseling-requests')
                    ->with('success', 'Permintaan konseling berhasil ditolak.');
            } else {
                return redirect()->back()
                    ->with('error', 'Gagal menolak permintaan konseling.');
            }

        } catch (\Exception $e) {
            log_message('error', 'CounselingRequest Reject Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi error: ' . $e->getMessage());
        }
    }
}

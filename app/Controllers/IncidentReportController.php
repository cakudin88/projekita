<?php
namespace App\Controllers;
use App\Models\IncidentReportModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class IncidentReportController extends Controller
{
    public function index()
    {
        $session = session();
        $userId = $session->get('user_id');
        $role = $session->get('role_name');
        if (!$userId) return redirect()->to('/login');
        $model = new IncidentReportModel();
        if ($role === 'murid') {
            // Only murid with can_report_incident
            $userModel = new UserModel();
            $murid = $userModel->find($userId);
            if (empty($murid['can_report_incident'])) return redirect()->to('/dashboard');
            $reports = $model->getReportsByStudent($userId);
            return view('incident_reports/index', ['reports' => $reports]);
        } elseif ($role === 'guru_bk') {
            $reports = $model->getAllReports();
            return view('incident_reports/manage', ['reports' => $reports]);
        }
        return redirect()->to('/dashboard');
    }

    public function create()
    {
        $session = session();
        $userId = $session->get('user_id');
        $role = $session->get('role_name');
        if ($role !== 'murid') return redirect()->to('/dashboard');
        $userModel = new UserModel();
        $murid = $userModel->find($userId);
        if (empty($murid['can_report_incident'])) return redirect()->to('/dashboard');
        if ($this->request->getMethod() === 'post') {
            $desc = $this->request->getPost('description');
            if ($desc) {
                $model = new IncidentReportModel();
                $model->insert([
                    'student_id' => $userId,
                    'description' => $desc
                ]);
                return redirect()->to('/incident-reports');
            }
        }
        return view('incident_reports/create');
    }

    public function review($id)
    {
        $session = session();
        $userId = $session->get('user_id');
        $role = $session->get('role_name');
        if ($role !== 'guru_bk') return redirect()->to('/dashboard');
        $model = new IncidentReportModel();
        $report = $model->find($id);
        if (!$report) return redirect()->to('/incident-reports');
        if ($this->request->getMethod() === 'post') {
            $status = $this->request->getPost('status');
            $model->update($id, [
                'status' => $status,
                'reviewed_by' => $userId,
                'reviewed_at' => date('Y-m-d H:i:s')
            ]);
            return redirect()->to('/incident-reports');
        }
        return view('incident_reports/review', ['report' => $report]);
    }
}

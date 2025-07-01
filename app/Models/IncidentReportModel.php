<?php
namespace App\Models;
use CodeIgniter\Model;

class IncidentReportModel extends Model
{
    protected $table = 'incident_reports';
    protected $primaryKey = 'id';
    protected $allowedFields = ['student_id', 'description', 'status', 'created_at', 'reviewed_by', 'reviewed_at'];
    public $timestamps = false;

    public function getReportsByStudent($studentId)
    {
        return $this->where('student_id', $studentId)->orderBy('created_at', 'DESC')->findAll();
    }

    public function getAllReports()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }
}

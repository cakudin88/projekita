<?php
namespace App\Models;

use CodeIgniter\Model;

class CounselingRequestModel extends Model
{
    protected $table = 'counseling_requests';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'student_id', 'type', 'theme', 'description', 'status', 'requested_at', 'scheduled_at', 'approved_by', 'approved_at', 'group_name'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Status: pending, approved, rejected, scheduled, completed
}

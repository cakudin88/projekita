<?php
namespace App\Models;

use CodeIgniter\Model;

class CounselingRequestModel extends Model
{
    protected $table = 'counseling_requests';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'student_id',
        'type',
        'theme',
        'group_name',
        'description',
        'status',
        'counselor_id',
        'counseling_date',
        'response_message',
        'rejected_reason',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'student_id' => 'required|integer',
        'type' => 'required|in_list[individu,kelompok,klasikal]',
        'theme' => 'required|max_length[255]',
        'description' => 'required'
    ];

    protected $validationMessages = [
        'student_id' => [
            'required' => 'ID siswa harus diisi',
            'integer' => 'ID siswa harus berupa angka'
        ],
        'type' => [
            'required' => 'Jenis konseling harus dipilih',
            'in_list' => 'Jenis konseling tidak valid'
        ],
        'theme' => [
            'required' => 'Tema/topik harus diisi',
            'max_length' => 'Tema/topik maksimal 255 karakter'
        ],
        'description' => [
            'required' => 'Deskripsi permintaan harus diisi'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_COMPLETED = 'completed';

    /**
     * Get requests with student and counselor information
     */
    public function getRequestsWithDetails($where = [])
    {
        $builder = $this->select('
            counseling_requests.*,
            students.full_name as student_name,
            students.username as student_username,
            students.email as student_email,
            counselors.full_name as counselor_name,
            counselors.username as counselor_username
        ')
        ->join('users as students', 'students.id = counseling_requests.student_id', 'left')
        ->join('users as counselors', 'counselors.id = counseling_requests.counselor_id', 'left');

        if (!empty($where)) {
            $builder->where($where);
        }

        // Check if created_at column exists, fallback to id
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames('counseling_requests');
        $orderBy = in_array('created_at', $fields) ? 'counseling_requests.created_at' : 'counseling_requests.id';

        return $builder->orderBy($orderBy, 'DESC')->findAll();
    }

    /**
     * Get requests for specific student
     */
    public function getStudentRequests($studentId)
    {
        return $this->getRequestsWithDetails(['counseling_requests.student_id' => $studentId]);
    }

    /**
     * Get pending requests for counselors
     */
    public function getPendingRequests()
    {
        return $this->getRequestsWithDetails(['counseling_requests.status' => self::STATUS_PENDING]);
    }

    /**
     * Get requests assigned to specific counselor
     */
    public function getCounselorRequests($counselorId)
    {
        return $this->getRequestsWithDetails(['counseling_requests.counselor_id' => $counselorId]);
    }

    /**
     * Update request status
     */
    public function updateStatus($id, $status, $data = [])
    {
        $updateData = array_merge(['status' => $status], $data);
        return $this->update($id, $updateData);
    }

    /**
     * Approve request
     */
    public function approveRequest($id, $counselorId, $counselingDate, $responseMessage = '')
    {
        return $this->updateStatus($id, self::STATUS_APPROVED, [
            'counselor_id' => $counselorId,
            'counseling_date' => $counselingDate,
            'response_message' => $responseMessage
        ]);
    }

    /**
     * Reject request
     */
    public function rejectRequest($id, $counselorId, $rejectedReason)
    {
        return $this->updateStatus($id, self::STATUS_REJECTED, [
            'counselor_id' => $counselorId,
            'rejected_reason' => $rejectedReason
        ]);
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class CounselingModel extends Model
{
    protected $table            = 'counseling_sessions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'student_id', 'counselor_id', 'category_id', 'title', 'description', 
        'session_date', 'session_time', 'status', 'notes', 'follow_up', 'is_urgent', 
        'priority', 'created_by'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'student_id' => 'required|integer',
        'counselor_id' => 'required|integer',
        'category_id' => 'required|integer',
        'title' => 'required|min_length[3]|max_length[255]',
        'description' => 'required|min_length[10]',
        'session_date' => 'required|valid_date',
        'status' => 'required|in_list[scheduled,ongoing,completed,cancelled]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getSessionsWithDetails($limit = null)
    {
        $builder = $this->db->table($this->table . ' cs');
        $builder->select('cs.*, s.nis, s.class, u.full_name as student_name, c.full_name as counselor_name, cat.name as category_name, cat.color as category_color');
        $builder->join('students s', 's.id = cs.student_id');
        $builder->join('users u', 'u.id = s.user_id');
        $builder->join('users c', 'c.id = cs.counselor_id');
        $builder->join('categories cat', 'cat.id = cs.category_id');
        $builder->orderBy('cs.session_date', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->get()->getResultArray();
    }

    public function getUpcomingSessions($counselorId = null)
    {
        $builder = $this->db->table($this->table . ' cs');
        $builder->select('cs.*, s.nis, s.class, u.full_name as student_name, c.full_name as counselor_name, cat.name as category_name, cat.color as category_color');
        $builder->join('students s', 's.id = cs.student_id');
        $builder->join('users u', 'u.id = s.user_id');
        $builder->join('users c', 'c.id = cs.counselor_id');
        $builder->join('categories cat', 'cat.id = cs.category_id');
        $builder->where('cs.session_date >=', date('Y-m-d H:i:s'));
        $builder->whereIn('cs.status', ['scheduled', 'ongoing']);
        
        if ($counselorId) {
            $builder->where('cs.counselor_id', $counselorId);
        }
        
        $builder->orderBy('cs.session_date', 'ASC');
        
        return $builder->get()->getResultArray();
    }
}

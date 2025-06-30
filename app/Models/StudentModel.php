<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table            = 'students';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'nis', 'class', 'grade', 'parent_id', 'homeroom_teacher_id'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
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

    public function getStudentsWithUsers()
    {
        return $this->db->table($this->table . ' s')
            ->select('s.*, u.full_name as name, u.email, u.phone')
            ->join('users u', 'u.id = s.user_id')
            ->get()->getResultArray();
    }

    public function getStudentWithUser($id)
    {
        return $this->db->table($this->table . ' s')
            ->select('s.*, u.full_name as name, u.email, u.phone, u.username')
            ->join('users u', 'u.id = s.user_id')
            ->where('s.id', $id)
            ->get()->getRowArray();
    }

    public function findAll(int $limit = 0, int $offset = 0)
    {
        return $this->getStudentsWithUsers();
    }

    public function getStudentsWithClass()
    {
        return $this->db->table($this->table . ' s')
            ->select('s.id, s.nis, s.class, s.grade, u.full_name as name')
            ->join('users u', 'u.id = s.user_id')
            ->orderBy('s.class', 'ASC')
            ->orderBy('u.full_name', 'ASC')
            ->get()->getResultArray();
    }
}

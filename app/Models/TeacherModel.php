<?php
namespace App\Models;

use CodeIgniter\Model;

class TeacherModel extends Model
{
    protected $table = 'teachers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['user_id', 'nip', 'subject'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getTeachersWithUsers()
    {
        return $this->db->table($this->table . ' t')
            ->select('t.*, u.full_name as name, u.email, u.phone')
            ->join('users u', 'u.id = t.user_id')
            ->get()->getResultArray();
    }
}

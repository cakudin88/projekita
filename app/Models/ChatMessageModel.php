<?php
namespace App\Models;
use CodeIgniter\Model;

class ChatMessageModel extends Model
{
    protected $table = 'chat_messages';
    protected $primaryKey = 'id';
    protected $allowedFields = ['sender_id', 'receiver_id', 'message', 'created_at'];
    public $timestamps = false;

    public function getChat($userId, $otherId)
    {
        return $this->where("(sender_id = $userId AND receiver_id = $otherId) OR (sender_id = $otherId AND receiver_id = $userId)")
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }
}

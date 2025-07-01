<?php
namespace App\Controllers;
use App\Models\ChatMessageModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class ChatController extends Controller
{
    public function index($otherId = null)
    {
        $session = session();
        $userId = $session->get('user_id');
        $role = $session->get('role_name');
        if (!$userId) return redirect()->to('/login');
        // Only murid and guru_bk can chat
        if (!in_array($role, ['murid', 'guru_bk'])) return redirect()->to('/dashboard');
        $chatModel = new ChatMessageModel();
        $userModel = new UserModel();
        // Default: murid chat ke guru_bk, guru_bk pilih murid
        if ($role === 'murid') {
            $guru = $userModel->where('role_id', 2)->first();
            $otherId = $guru['id'] ?? null;
        } elseif ($role === 'guru_bk' && !$otherId) {
            // Guru BK harus pilih murid
            $muridList = $userModel->where('role_id', 3)->findAll();
            return view('chat/select_murid', ['muridList' => $muridList]);
        }
        if (!$otherId) return redirect()->to('/dashboard');
        $chat = $chatModel->getChat($userId, $otherId);
        $otherUser = $userModel->find($otherId);
        return view('chat/index', [
            'chat' => $chat,
            'otherUser' => $otherUser,
            'userId' => $userId,
            'otherId' => $otherId
        ]);
    }

    public function send()
    {
        $session = session();
        $userId = $session->get('user_id');
        $role = $session->get('role_name');
        if (!$userId) return redirect()->to('/login');
        $receiverId = $this->request->getPost('receiver_id');
        $message = $this->request->getPost('message');
        if ($receiverId && $message) {
            $chatModel = new ChatMessageModel();
            $chatModel->insert([
                'sender_id' => $userId,
                'receiver_id' => $receiverId,
                'message' => $message
            ]);
        }
        return redirect()->to('/chat/' . $receiverId);
    }
}

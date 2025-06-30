<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\UserModel;

class RoleController extends BaseController
{
    protected $roleModel;
    protected $userModel;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
        $this->userModel = new UserModel();
        helper(['url', 'form']);
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'super_admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $roles = $this->roleModel->findAll();
        
        // Get user count for each role
        foreach ($roles as &$role) {
            $role['user_count'] = $this->userModel->where('role_id', $role['id'])->countAllResults();
        }

        $data = [
            'title' => 'Kelola Role',
            'roles' => $roles
        ];

        return view('admin/roles/index', $data);
    }

    public function create()
    {
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'super_admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $data = [
            'title' => 'Tambah Role'
        ];

        return view('admin/roles/create', $data);
    }

    public function store()
    {
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'super_admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[50]|is_unique[roles.name]',
            'description' => 'required|min_length[5]|max_length[255]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => strtolower(str_replace(' ', '_', $this->request->getPost('name'))),
            'description' => $this->request->getPost('description')
        ];

        if ($this->roleModel->insert($data)) {
            return redirect()->to('/admin/roles')->with('success', 'Role berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan role!');
        }
    }

    public function edit($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'super_admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $role = $this->roleModel->find($id);
        if (!$role) {
            return redirect()->to('/admin/roles')->with('error', 'Role tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Role',
            'role' => $role
        ];

        return view('admin/roles/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'super_admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $role = $this->roleModel->find($id);
        if (!$role) {
            return redirect()->to('/admin/roles')->with('error', 'Role tidak ditemukan!');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => "required|min_length[3]|max_length[50]|is_unique[roles.name,id,{$id}]",
            'description' => 'required|min_length[5]|max_length[255]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => strtolower(str_replace(' ', '_', $this->request->getPost('name'))),
            'description' => $this->request->getPost('description')
        ];

        if ($this->roleModel->update($id, $data)) {
            return redirect()->to('/admin/roles')->with('success', 'Role berhasil diupdate!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate role!');
        }
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role_name') !== 'super_admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $role = $this->roleModel->find($id);
        if (!$role) {
            return redirect()->to('/admin/roles')->with('error', 'Role tidak ditemukan!');
        }

        // Check if role is being used by users
        $userCount = $this->userModel->where('role_id', $id)->countAllResults();
        if ($userCount > 0) {
            return redirect()->to('/admin/roles')->with('error', 'Role tidak dapat dihapus karena masih digunakan oleh pengguna!');
        }

        if ($this->roleModel->delete($id)) {
            return redirect()->to('/admin/roles')->with('success', 'Role berhasil dihapus!');
        } else {
            return redirect()->to('/admin/roles')->with('error', 'Gagal menghapus role!');
        }
    }
}

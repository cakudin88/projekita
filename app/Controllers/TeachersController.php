<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class TeachersController extends BaseController
{
    public function index()
    {
        $teacherModel = new \App\Models\TeacherModel();
        $teachers = $teacherModel->getTeachersWithUsers();
        return view('teachers/index', ['teachers' => $teachers]);
    }
}

<?php
namespace App\Controllers;
use App\Services\SubjectService;
use App\Services\StudentService;
use App\Common\Result;

class BangDiemController extends BaseController
{
    public $subject;
    public $student;
    public function __construct()
    {
         $this->subject = new SubjectService();
         $this->student = new StudentService();
    }

    public function index()
    {
        $data = [];
        $data = $this->loadLayout($data, 'Điểm danh', 'Home/pages/bangdiem');
        return view('Home/index', $data);
    }
    
}

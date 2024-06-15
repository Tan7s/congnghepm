<?php

namespace App\Controllers;

use App\Services\ClassServices;
use App\Services\scheduleService;
use App\Services\SubjectService;
use App\Services\TeacherService;

class Home extends BaseController
{
    public $schedule, $teacher, $subject, $class;
    public function __construct()
    {
        $this->schedule = new scheduleService();
        $this->teacher = new TeacherService();
        $this->subject = new SubjectService();
        $this->class = new ClassServices();

    }
    public function index(): string
    {
        $data = [];
        $datas["class"] = $this->class->getClass();
        $datas["schedule"] = $this->schedule->getSchedule();
        $datas["teacher"] = $this->teacher->getAllTeachers();
        $datas["subject"] = $this->subject->getAllSubject();
        $data = $this->loadLayout($data, 'Trang chủ', 'Home/pages/home', $datas, [], []);
        return view('Home/index', $data);
    }
    public function submitForm()
    {
        if ($this->request->isAJAX()){
        $data = [
            'id_subject' => (int)$this->request->getPost('subject'),
            'id_teacher' => (int)$this->request->getPost('teacher'),
            'id_class' => (int)$this->request->getPost('class'),
            'date' => $this->request->getPost('date'),
            'buoi' => 'sang',
            'timeStar' => $this->request->getPost('start_time'),
            'timeEnd' => $this->request->getPost('end_time'),
        ];

        // Xử lý dữ liệu ở đây (lưu vào cơ sở dữ liệu, gửi email, v.v.)
        // Trả về phản hồi cho client
        return $this->response->setJSON($this->schedule->addSchedule($data));
    }
    }
}
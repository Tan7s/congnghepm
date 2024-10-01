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
    {   //dd(session()->get('user_login'));
        $data = [];
        $datas["class"] = $this->class->getClass();
        $datas["schedule"] = $this->schedule->getSchedule();
        $datas["teacher"] = $this->teacher->getAllTeachers();
        $datas["subject"] = $this->subject->getAllSubject();
        if(session()->get('user_login')['code']){
            if(session()->get('user_login')['loai']==0){
                $datas['code']=$this->class->getLichhocByClass(session()->get('user_login')['code']);
            }
            elseif(session()->get('user_login')['loai']==1){
                $datas['code']=$this->schedule->getLichDayTeacher(session()->get('user_login')['code']);
            }
        }
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
            'buoi' => $this->request->getPost('buoi'),
            'timeStar' => $this->request->getPost('start_time'),
            'timeEnd' => $this->request->getPost('end_time'),
        ];

        // Xử lý dữ liệu ở đây (lưu vào cơ sở dữ liệu, gửi email, v.v.)
        // Trả về phản hồi cho client
        return $this->response->setJSON($this->schedule->addSchedule($data));
        }
    }
    public function deleteSchedule(){
        $scheduleId = $this->request->getPost('id');
        
        if ($this->schedule->deleteLichHoc($scheduleId)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }
}
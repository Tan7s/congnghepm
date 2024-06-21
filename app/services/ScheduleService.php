<?php

namespace App\Services;

use App\Common\Result;
use Exception;
use App\Models\CreateSchedule;
use CodeIgniter\HTTP\ResponseInterface;
use PHPUnit\Framework\Attributes\BeforeClass;
use CodeIgniter\I18n\Time;

class scheduleService extends BaseService
{



    private $schedule;
    public $currentTime;
    //Construct
    function __construct()
    {
        parent::__construct(); // dùng construct của thằng cha
        $this->schedule = new CreateSchedule();
        $this->schedule->protect(false); // không phải đinh nghĩa trong model UerModel
        $this->currentTime = Time::now('Asia/Ho_Chi_Minh', 'en_US');
    }
    public function getSchedule()
    {
        return $this->schedule->table('lichhoc')
            ->select('subject.name as subject_name, teacher.name as teacher_name, class.nameClass,lichhoc.id as id_lichhoc,lichhoc.buoi,lichhoc.date,lichhoc.timeStar,lichhoc.timeEnd')
            ->join('subject', 'lichhoc.id_subject = subject.id')
            ->join('teacher', 'lichhoc.id_teacher = teacher.id')
            ->join('class', 'lichhoc.id_class = class.id')
            ->get()
            ->getResultArray();
    }
    public function getStudentsbyLichHoc($id_lichhoc)
    {   
        return $this->schedule->table('lichhoc')
            ->select('student.name as studentName,lichhoc.buoi,lichhoc.date, student.id as id_student, lichhoc.id as id_lichhoc ')
            ->join('student_class', 'lichhoc.id_class = student_class.class_id')->where('lichhoc.id', $id_lichhoc)
            ->join('student', 'student_class.student_id = student.id')
            ->get()
            ->getResultArray();
    }
    public function addSchedule($data)
    {
        //dd($data);
        if ($this->currentTime->toLocalizedString('yyyy-MM-dd') < $data['date'] || $this->currentTime->toLocalizedString('yyyy-MM-dd') == $data['date']) {
            $test = 0;
            $check = $this->schedule->findAll();
            foreach ($check as $ck) {
                if ($ck['date'] === $data['date']) {// kiểm tra xem ngày có trùng với lịch nào k 
                    if ((int) $ck['id_class'] == $data['id_class']) {// kiêmr tra xem lớp có trùng lớp k 
                        if ($ck['buoi'] === $data['buoi']) {// kiểm tra xem có trùng buổi k
                            $test = true;
                            $response = [
                                        'status' => 'ResponseInterface::HTTP_BAD_REQUEST',
                                        'message' => 'lịch học này đang trùng với lịch khác',
                                    ];
                            break;
                        } 
                    } 
                } 
            }
            if (!$test&&$this->schedule->insert($data)) {
                $response = [
                    'status' => ResponseInterface::HTTP_OK,
                    'message' => 'Thêm lịch học thành công!!!!!',
                ];
            }
        }else{
            $response = [
                        'status' => 'ResponseInterface::HTTP_BAD_REQUEST',
                        'message' => 'ngày học này ko còn so với thời gian hiện tại',
                    ];
        }
        return $response;
    }
    public function deleteLichHoc($id){
        $deleted = $this->schedule->table('lichhoc')->delete(['id' => $id]);   
        return $deleted;
    }
}
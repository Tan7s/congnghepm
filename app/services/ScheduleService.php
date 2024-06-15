<?php

namespace App\Services;

use App\Common\Result;
use Exception;
use App\Models\CreateSchedule;
use CodeIgniter\HTTP\ResponseInterface;

class scheduleService extends BaseService
{

    

    private $schedule;
    //Construct
    function __construct()
    {
        parent::__construct(); // dùng construct của thằng cha
        $this->schedule = new CreateSchedule();
        $this->schedule->protect(false); // không phải đinh nghĩa trong model UerModel
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
    public function getStudentsbyLichHoc($id_lichhoc){
        return $this->schedule->table('lichhoc')
        ->select('student.name as studentName,lichhoc.buoi,lichhoc.date, student.id as id_student, lichhoc.id as id_lichhoc ')
        ->join('student_class', 'lichhoc.id_class = student_class.class_id')->where('lichhoc.id', $id_lichhoc)
        ->join('student', 'student_class.student_id = student.id')
        ->get()
        ->getResultArray();
    }
    public function addSchedule($data){
        try {
            if ($this->schedule->insert($data)) {
                $response = [
                    'status' => ResponseInterface::HTTP_OK,
                    'message' => 'Teacher added successfully',
                    //'id' => $this->teachers->insertID(),
                ];
            } else {
                throw new Exception('Failed to add teacher');
            }
        } catch (Exception $e) {
            $response = [
                'status' => 'ResponseInterface::HTTP_BAD_REQUEST',
                'message' => $e->getMessage(),
            ];
        }
        return $response;
    }
}
<?php

namespace App\Services;

use App\Common\Result;
use Exception;
use App\Models\CreateClassModel;
use App\Models\CreateStudentClass;
use App\Models\CreateStudentModel;

class ClassServices extends BaseService
{

    

    private $class;
    private $studentClass;
    private $endStudent;
    //Construct
    function __construct()
    {
        parent::__construct(); // dùng construct của thằng cha
        $this->class = new CreateClassModel();
        $this->class->protect(false); // không phải đinh nghĩa trong model UerModel
        $this->studentClass = new CreateStudentClass();
        $this->studentClass->protect(false); // không phải đinh nghĩa trong model UerModel
        $this->endStudent = new CreateStudentModel();
        $this->endStudent->protect(false);
    }
    public function getClass()
    {
        return $this->class->findAll();
    }
    public function studentAddClass($idClass){
        $endStudent=$this->endStudent->table('student')->orderby('id','DESC')->limit(1)->get()->getRowArray();
        $data = [
            'student_id' => (int)$endStudent['id'],
            'class_id' => (int) $idClass,
        ];
        $this->studentClass->table('student_class')->insert($data);
        return 0;
    }

}
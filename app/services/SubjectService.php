<?php

namespace App\Services;

use App\Common\Result;
use Exception;
use App\Models\CreateSubjectModel;

class SubjectService extends BaseService
{

    private $subject;
    //Construct
    function __construct()
    {
        parent::__construct(); // dùng construct của thằng cha
        $this->subject = new CreateSubjectModel();
        $this->subject->protect(false); // không phải đinh nghĩa trong model UerModel
    }

    public function getAllSubject()
    {
        return $this->subject->findAll();
    }

}
<?php

namespace App\Services;

use App\Common\Result;
use Exception;
use App\Models\CreateSubjectModel;

class ChuyenNganhServices extends BaseService
{

    private $chuyenNganh;
    //Construct
    function __construct()
    {
        parent::__construct(); // dùng construct của thằng cha
        $this->chuyenNganh = new CreateSubjectModel();
        $this->chuyenNganh->protect(false); // không phải đinh nghĩa trong model UerModel
    }

    public function getAllChuyenNganh()
    {
        return $this->chuyenNganh->findAll();
    }

}
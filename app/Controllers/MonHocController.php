<?php
namespace App\Controllers;
use App\Services\SubjectService;
use App\Common\Result;

class MonHocController extends BaseController
{
    public $subject;

    public function __construct()
    {
         $this->subject = new SubjectService();

    }

    public function index(): string
    {
        $data = [];
        $dataCategory["subjects"] = $this->subject->getAllSubject();
        $data = $this->loadLayout($data, 'Trang chủ', 'Home/pages/list-monhoc', $dataCategory, [], []);
        return view('Home/index', $data);
    }

}
?>
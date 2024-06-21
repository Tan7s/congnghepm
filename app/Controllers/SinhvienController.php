<?php
namespace App\Controllers;


use App\Services\StudentService;
use App\Services\ClassServices;
use App\Common\Result;

class SinhvienController extends BaseController
{
    public $student;
    public $class;

    public function __construct()
    {
        $this->student = new StudentService();
        $this->class = new ClassServices();

    }

    public function index(): string
    {   
        $data = [];
        $dataCategory['dataClass']=$this->class->getClass();
        if($this->request->getVar('query')){
            $dataCategory["students"] = $this->student->getSearchStudent($this->request->getVar('query'));
        }
        else{
            $dataCategory["students"] = $this->student->getAllStudent();
        }
        $data = $this->loadLayout($data, 'Trang chủ', 'Home/pages/list-sinhvien', $dataCategory, [], []);

        return view('Home/index', $data);
    }
    public function updateStudent(){
        $id = $this->request->getPost('id');
        $field = $this->request->getPost('field');
        $value = $this->request->getPost('value');
        if ($this->student->updateStudent($id, $field, $value)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Cập nhật thành công']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Lỗi: không thể cập nhật']);
        }
    }
    public function addStudent(){
        
        $json = $this->request->getJSON();
        $data = [
            'name' => $json->name,
            'masinhvien' => $json->masinhvien,
            'phone' => $json->phone,
            'ngaysinh' => $json->ngaysinh,
            'gioitinh' => $json->sex,
            'dantoc' => $json->dantoc,
            'diachi' => $json->diachi,
            'quequan' => $json->quequan,
        ];
        $reponse = $this->student->addStudent($data);
        $this->class->studentAddClass($json->classId);
        return $this->response->setJSON($reponse);
    }
    public function deleteStudent(){
        $studentId = $this->request->getPost('id');
        
        if ($this->student->deleteStudent($studentId)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Không thể xóa sinh viên']);
        }
    }

}

?>
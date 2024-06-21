<?php
namespace App\Controllers;

use App\Services\TeacherService;
use App\Common\Result;

class GiaovienController extends BaseController
{
    public $teacher;

    public function __construct()
    {
        $this->teacher = new TeacherService();

    }

    public function index(): string
    {
        $data = [];
        if($this->request->getVar('query')){
            $dataCategory["teachers"] = $this->teacher->getSearchTeacher($this->request->getVar('query'));
        }
        else{
            $dataCategory["teachers"] = $this->teacher->getAllTeachers();
        }
        $data = $this->loadLayout($data, 'Trang chủ', 'Home/pages/list-giaovien', $dataCategory, [], []);
        return view('Home/index', $data);
    }
    public function update(){
        $id = $this->request->getPost('id');
        $field = $this->request->getPost('field');
        $value = $this->request->getPost('value');
        if ($this->teacher->updateTeacher($id, $field, $value)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Cập nhật thành công']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Lỗi: không thể cập nhật']);
        }

    }
    public function addTeacher(){
        
            $json = $this->request->getJSON();
            $data = [
                'name' => $json->name,
                'magiaovien' => $json->magiaovien,
                'phone' => $json->phone,
                'trinhdo' => $json->trinhdo,
                'hinhanh' => $json->hinhanh,
            ];
            return $this->response->setJSON($this->teacher->addTeacher($data));
        
        
        
        
    }
    public function deleteTeachers(){
        $teacherId = $this->request->getPost('id');
        
        if ($this->teacher->deleteTeacher($teacherId)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Không thể xóa giáo viên']);
        }
    }

}

?>
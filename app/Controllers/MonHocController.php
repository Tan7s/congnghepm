<?php

namespace App\Controllers;

use App\Services\SubjectService;
use App\Common\Result;

class MonHocController extends BaseController
{
    public $subject;
    public $save_subject;

    public function __construct()
    {
        $this->subject = new SubjectService();
    }

    public function index(): string
    {
        $data = [];
        $jsFiles = [
            'js/editSubject.js'
        ];
        $dataCategory["subjects"] = $this->subject->getAllSubject();
        // dd($dataCategory);
        $data = $this->loadLayout($data, 'Môn học', 'Home/pages/list-monhoc', $dataCategory, [], $jsFiles);
        return view('Home/index', $data);
    }
    public function update_subject()
    {
        try {
            // Lấy dữ liệu từ request
            $subject_id = $this->request->getPost('subjectID');
            $subject_name = $this->request->getPost('name');
            $subject_code = $this->request->getPost('code');
            $subject_credits = $this->request->getPost('credits');
            $major_id = $this->request->getPost('major_id');

            // Chuẩn bị dữ liệu để cập nhật
            $data = [
                'id'   => $subject_id,
                'name' => $subject_name,
                'code' => $subject_code,
                'credits' => $subject_credits,
                'major_id' => $major_id,
            ];

            // return $this->response->setStatusCode(200)->setJSON($data);
            // Gọi service để cập nhật dữ liệu
            $updateResult = $this->subject->updateSubject($data);

            if ($updateResult) {
                return $this->response->setStatusCode(200)->setJSON($data);
            } else {
                return $this->response->setStatusCode(500)->setJSON(['message' => 'Update không thành công']);
            }
        } catch (\Exception $e) {
            error_log('Error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Lỗi vl']);
        }
    }
    public function update_major()
    {
        try {
            // Lấy dữ liệu từ request
            $major_name = $this->request->getPost('major_name');
            $major_description = $this->request->getPost('description');
            $major_id = $this->request->getPost('majorID');

            // Chuẩn bị dữ liệu để cập nhật
            $data = [
                'name' => $major_name,
                'description' => $major_description,
                'id' => $major_id,
            ];
            // return $this->response->setStatusCode(200)->setJSON($data);
            // Gọi service để cập nhật dữ liệu
            $updateResult = $this->subject->updateMajor($data);

            if ($updateResult) {
                return $this->response->setStatusCode(200)->setJSON($data);
            } else {
                return $this->response->setStatusCode(500)->setJSON(['message' => 'Update không thành công', 'data' => $data]);
            }
        } catch (\Exception $e) {
            error_log('Error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Lỗi vl']);
        }
    }
    public function delete_subject($subject_id){
        $subject = $this->subject->getSujectByID($subject_id);
        if (!$subject){
            return redirect('error/404');
        }   
        $result = $this->subject->deleteSubject($subject_id);
        return redirect('admin/list-monhoc')->with($result['messageCode'], $result['messages']);
    }
    public function delete_major($major_id){
        $subject = $this->subject->getMajorByID($major_id);
        if (!$subject){
            return redirect('error/404');
        }   
        $result = $this->subject->deleteMajor($major_id);
        return redirect('admin/list-monhoc')->with($result['messageCode'], $result['messages']);
    }
    public function addSubject() {
        try {
            // Lấy dữ liệu từ request
            $subject_name = $this->request->getPost('subject_name');
            $subject_code = $this->request->getPost('code');
            $subject_credits = $this->request->getPost('credits');
            $major_id = $this->request->getPost('add_MajorSelect');

            // Chuẩn bị dữ liệu để cập nhật
            $data = [
                'name' => $subject_name,
                'code' => $subject_code,
                'credits' => $subject_credits,
                'major_id' => $major_id,
            ];


            // Gọi service để cập nhật dữ liệu
            $updateResult = $this->subject->addSubject($data);

            if ($updateResult) {
                return $this->response->setStatusCode(200)->setJSON($data);
            } else {
                return $this->response->setStatusCode(500)->setJSON(['message' => 'Update không thành công']);
            }
        } catch (\Exception $e) {
            error_log('Error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Lỗi vl']);
        }
    }
    public function addMajor()
    {
        try {
            // Lấy dữ liệu từ request
            $major_name = $this->request->getPost('major_name');
            $major_description = $this->request->getPost('description');

            // Chuẩn bị dữ liệu để cập nhật
            $data = [
                'name' => $major_name,
                'description' => $major_description,
            ];
            // return $this->response->setStatusCode(200)->setJSON($data);
            // Gọi service để cập nhật dữ liệu
            $updateResult = $this->subject->addMajor($data);

            if ($updateResult) {
                return $this->response->setStatusCode(200)->setJSON($data);
            } else {
                return $this->response->setStatusCode(500)->setJSON(['message' => 'Update không thành công', 'data' => $data]);
            }
        } catch (\Exception $e) {
            error_log('Error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Lỗi vl']);
        }
    }
}

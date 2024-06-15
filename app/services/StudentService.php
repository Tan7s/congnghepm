<?php

namespace App\Services;

use App\Common\Result;
use Exception;
use App\Models\CreateStudentModel;
use CodeIgniter\HTTP\ResponseInterface;
class StudentService extends BaseService
{

    private $students;
    //Construct
    function __construct()
    {
        parent::__construct(); // dùng construct của thằng cha
        $this->students = new CreateStudentModel();
        $this->students->protect(false); // không phải đinh nghĩa trong model UerModel
    }

    public function getAllStudent()
    {
        return $this->students->table('student')
        ->select('student.id,student.masinhvien, student.name, class.nameClass, student.phone, student.ngaysinh, student.gioitinh, student.dantoc, student.diachi, student.quequan')
        ->join('student_class', 'student.id = student_class.student_id')
        ->join('class', 'student_class.class_id = class.id')->get()->getResultArray();
        
    }
    public function getSearchStudent($search){
        return $this->students->table('student')
        ->select('student.id,student.masinhvien, student.name, class.nameClass, student.phone, student.ngaysinh, student.gioitinh, student.dantoc, student.diachi, student.quequan')
        ->join('student_class', 'student.id = student_class.student_id')
        ->join('class', 'student_class.class_id = class.id')->like('student.name',$search, 'both')->get()->getResultArray();
    }
    public function updateStudent($id, $field, $value)
    {
        // Sử dụng biến trung gian để tạo mảng kết hợp
        $data = [
            $field => $value
        ];

        // Cập nhật mảng kết hợp
        return $this->students->update($id, $data);
    }
    public function addStudent($data){
        try {
            if ($this->students->insert($data)) {
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
    public function deleteStudent($id){
        $deleted = $this->students->table('student')->delete(['id' => $id]);   
        return $deleted;
    }


}
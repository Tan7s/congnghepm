<?php

namespace App\Services;

use App\Common\Result;
use Exception;
use App\Models\CreateSubjectModel;
use App\Models\CreateMajorModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
class SubjectService extends BaseService
{

    private $subject;
    private $major;
    //Construct
    function __construct()
    {
        parent::__construct(); // dùng construct của thằng cha
        $this->subject = new CreateSubjectModel();
        $this->subject->protect(false); // không phải đinh nghĩa trong model UerModel
        $this->major = new CreateMajorModel();
        $this->major->protect(false); // không phải đinh nghĩa trong model UerModel
    }

    public function getAllSubject()
    {
        return $this->subject->table('subject')
        ->select('subject.*, major.name as major_name, major.id as major_id, major.description')
        ->join('major', 'major.id = subject.major_id', 'right')
        ->get()
        ->getResultArray();
    }
    public function updateSubject($data){
        try {

            // Tìm kiếm bản ghi theo mã id hoặc một điều kiện duy nhất khác để xác định bản ghi cần cập nhật
            $subject = $this->subject->where('id', $data['id'])->first();

            if ($subject) {
                // Cập nhật bản ghi
                return $this->subject->update($subject['id'], $data);
            } else {
                throw new \Exception('Subject not found');
            }
        } catch (\Exception $e) {
            error_log('Error in updateSubject: ' . $e->getMessage());
            return false;
        }
    }
    public function addSubject($data){
        try {
                return $this->subject->insert($data);
        } catch (\Exception $e) {
            error_log('Error in updateSubject: ' . $e->getMessage());
            return false;
        }
    }
    public function updateMajor($data){
        try {
            // Tìm kiếm bản ghi theo mã code hoặc một điều kiện duy nhất khác để xác định bản ghi cần cập nhật
            $major = $this->major->where('id', $data['id'])->first();

            if ($major) {
                // Cập nhật bản ghi
                return $this->major->update($major['id'], $data);
            } else {
                throw new \Exception('Major not found');
            }
        } catch (\Exception $e) {
            error_log('Error in updateMajor: ' . $e->getMessage());
            return false;
        }
    }
    public function addMajor($data){
        try {
            return $this->major->insert($data);
        } catch (\Exception $e) {
            error_log('Error in updateSubject: ' . $e->getMessage());
            return false;
        }
    }
    public function deleteSubject($subject_id){
        try{
            $this->subject->delete($subject_id);
            return [
                'status' => Result::STATUS_CODE_OK,
                'messageCode' => Result::MESSAGE_CODE_OK,
                'messages' => [
                    'success' => 'Xóa môn học thành công!'
                ],
            ];
        }
        catch(\Exception $e){
            return [
                'status' => Result::STATUS_CODE_ERR,
                'messageCode' => Result::MESSAGE_CODE_ERR,
                'messages' => [
                    'error' => $e->getMessage() 
                ],
            ];
        }
        catch (DatabaseException $e) {
            return [
                'status' => Result::STATUS_CODE_ERR,
                'messageCode' => Result::MESSAGE_CODE_ERR,
                'messages' => [
                    'error' => $e->getMessage() 
                ],
            ];
        }
    }
    public function getSujectByID($subject_id) {
        return $this->subject->where('id', $subject_id)->first();
    }
    public function getMajorByID($major_id) {
        return $this->major->where('id', $major_id)->first();
    }
    public function deleteMajor($major_id){
        try{
            $this->major->delete($major_id);
            return [
                'status' => Result::STATUS_CODE_OK,
                'messageCode' => Result::MESSAGE_CODE_OK,
                'messages' => [
                    'success' => 'Xóa học phần thành công!'
                ],
            ];
        }
        catch(\Exception $e){
            return [
                'status' => Result::STATUS_CODE_ERR,
                'messageCode' => Result::MESSAGE_CODE_ERR,
                'messages' => [
                    'error' => $e->getMessage() 
                ],
            ];
        }
        catch (DatabaseException $e) {
            return [
                'status' => Result::STATUS_CODE_ERR,
                'messageCode' => Result::MESSAGE_CODE_ERR,
                'messages' => [
                    'error' => $e->getMessage() 
                ],
            ];
        }
    }
}
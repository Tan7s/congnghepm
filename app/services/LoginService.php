<?php

namespace App\Services;

use App\Common\Result;
use Exception;
use App\Models\CreateUserModel;
use App\Models\CreateStudentModel;
use App\Models\CreateTeacherModel;

class LoginService extends BaseService
{

    private $users;
    private $teacher;
    private $student;
    //Construct
    function __construct()
    {
        parent::__construct(); // dùng construct của thằng cha
        $this->users = new CreateUserModel();
        $this->teacher = new CreateTeacherModel();
        $this->student = new CreateStudentModel();
        $this->users->protect(false); // không phải đinh nghĩa trong model UserModel
    }
    public function hasLoginInfo($requestData)
    {
        // dd($requestData->getPost());
        $validate = $this->validateLogin($requestData);
        if ($validate->getErrors()) {
            return [
                'status' => Result::STATUS_CODE_ERR,
                'messageCode' => Result::MESSAGE_CODE_ERR,
                'messages' => $validate->getErrors()
            ];
        }
        $param = $requestData->getPost();

        $user = $this->users->where('user_id', $param['user_id'])->first();
        if (!$user) {
            return [
                'status' => Result::STATUS_CODE_ERR,
                'messageCode' => Result::MESSAGE_CODE_ERR,
                'messages' => [
                    'thongbaoemail' => 'Tên tài khoản Khong Tồn tại'
                ]
            ];
        }

        // $c = password_hash($param['password'], PASSWORD_BCRYPT);
        if ($param['password']!=$user['password']) {
            // dd($param['password']);
            return [
                'status' => Result::STATUS_CODE_ERR,
                'messageCode' => Result::MESSAGE_CODE_ERR,
                'messages' => [
                    'thongbaomk' => 'Sai mật khẩu. Vui lòng kiểm tra lại'
                ]
            ];
        }
        $session = session();
        unset($user['password']);
        $check = substr($param['user_id'],0,2);
        if (strcasecmp($check, 'sv') === 0) {
            $student= $this->student->select('name')->where('masinhvien',$param['user_id'])->get()->getRowArray();
            $user['name'] = $student['name'];
            $user['loai'] = 0;
        } elseif(strcasecmp($check, 'sv') === 0) {
            $teacher= $this->teacher->select('name')->where('magiaovien',$param['user_id'])->get()->getRowArray();
            $user['name'] = $teacher['name'];
            $user['loai'] = 1;
        }else{
            $admin= $this->users->select('type')->where('user_id',$param['user_id'])->get()->getRowArray();
            $user['name'] = $admin['type'];
            $user['loai'] = 2;
        }
        $session->set('user_login', $user);
        return [
            'status' => Result::STATUS_CODE_OK,
            'messageCode' => Result::MESSAGE_CODE_OK,
            'messages' => null,
        ];

    }
    public function validateLogin($requestData)
    {
        $rule = [
            'user_id' => 'max_length[10]|min_length[5]',
            'password' => 'max_length[20]|min_length[5]',
        ];
        $messages = [
            'user_id' => [
                'max_length' => 'Tài khoản dài tối đa là {param} kí tự',
                'min_length' => 'Tài khoản dài tối thiểu là {param} kí tự',
            ],
            'password' => [
                'max_length' => 'Mật khẩu dài tối đa là {param} kí tự',
                'min_length' => 'Mật khẩu dài tối thiểu là {param} kí tự',
            ],
        ];
        $this->validation->setRules($rule, $messages);
        $this->validation->withRequest($requestData)->run();
        return $this->validation;
    }
    public function  logOutUser() {
        $session = session();
        $session->destroy();
    }
}
<?php
namespace App\Controllers;
use App\Services\SubjectService;
use App\Services\StudentService;
use App\Services\ScheduleService;
use App\Models\CreateDiemDanhModel;
use App\Common\Result;

class DiemDanhController extends BaseController
{
    public $subject;
    public $student;
    public $schedule;
    public $diemdanh;
    public function __construct()
    {
         $this->subject = new SubjectService();
         $this->student = new StudentService();
         $this->schedule = new ScheduleService();
         $this->diemdanh = new CreateDiemDanhModel();
    }

    public function index($id_lichhoc)
    {
        $data = [];
        $datalayout['content'] = $this->schedule->getStudentsbyLichHoc($id_lichhoc); 
        $data = $this->loadLayout($data, 'Điểm danh', 'Home/pages/diemdanh',$datalayout, [], []);
        return view('Home/index', $data);
    }
    public function diemdanh(){
        $request = service('request');
        $attendanceData = $request->getPost('diemdanh');
        // Kiểm tra dữ liệu nhận được từ form
        // exit(); // Dừng thực thi để kiểm tra dữ liệu

        if ($attendanceData) {
            foreach ($attendanceData as $entry) {
                if (isset($entry['id_lichhoc']) && isset($entry['id_student'])) {
                    $data = [
                        'id_hocsinh' => (int)$entry['id_student'],
                        'id_lichhoc' => (int)$entry['id_lichhoc'],
                        'status' => $entry['status'] ?? 'vang'  // Default to 'vang' if not set
                    ];
                    $this->diemdanh->insert($data);
                    
                }
            }
            return redirect()->to('/')->with('message', 'Điểm danh thành công!');
        } else {
            return redirect()->back()->with('message', 'Không có dữ liệu để điểm danh.');
        }
    }
}
?>
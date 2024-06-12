<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TableController extends BaseController
{   
    protected $userModel;

    public function __construct()
    {
        // Khởi tạo model
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return view('livetable');
    }

    public function liveData()
    {
        $data = $this->userModel->findAll();
        return $this->response->setJSON(['data' => $data]);
    }
    
    public function deleteDataByAjax()
    {
        // Lấy instance của request
        $request = \Config\Services::request();
    
        // Lấy dữ liệu từ yêu cầu AJAX
        $data = $request->getPost('data');
    
        if (is_array($data)) {
            // Duyệt qua từng bản ghi trong dữ liệu
            foreach ($data as $id => $fields) {
                // Xóa bản ghi khỏi cơ sở dữ liệu
                $this->userModel->delete($id);
            }
    
            // Trả lời bằng JSON để xác nhận việc xóa
            return $this->response->setJSON(['status' => 'success']);
        } else {
            // Trả lời bằng JSON để thông báo thất bại
            return $this->response->setJSON(['status' => 'failure', 'message' => 'Dữ liệu không hợp lệ']);
        }
    }

    public function updateDataByAjax()
    {
        // Lấy instance của request
        $request = \Config\Services::request();

        // Lấy dữ liệu từ yêu cầu AJAX
        $data = $request->getPost('data');

        if (is_array($data)) {
            // Duyệt qua từng bản ghi trong dữ liệu
            foreach ($data as $id => $fields) {
                // Cập nhật bản ghi trong cơ sở dữ liệu
                $this->userModel->update($id, $fields);
            }

            // Trả lời bằng JSON để xác nhận việc cập nhật
            return $this->response->setJSON(['status' => 'success']);
        } else {
            // Trả lời bằng JSON để thông báo thất bại
            return $this->response->setJSON(['status' => 'failure', 'message' => 'Dữ liệu không hợp lệ']);
        }
    }
}

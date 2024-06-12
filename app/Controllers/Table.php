<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use DataTables\Editor\Field;
use CodeIgniter\RESTful\ResourceController;
class Table extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        // Khởi tạo model
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return view('table');
    }

    public function test1()
    {
        return view('testtable');
    }
    public function test()
    {
        return view('datatable');
    }

    public function listData()
    {
        $request = \Config\Services::request();
        $searchValue = $request->getGet('search')['value']; // Giá trị tìm kiếm
        $orderColumn = $request->getGet('order')[0]['column']; // Chỉ số cột
        $orderDir = $request->getGet('order')[0]['dir']; // asc hoặc desc
        $columns = ['id', 'email', 'username', 'password', 'otp', 'status']; // Tên các cột
    
        $builder = $this->userModel->builder();
        $builder->select('*');
    
        // Chức năng tìm kiếm
        if (!empty($searchValue)) {
            $builder->groupStart();
            foreach ($columns as $column) {
                $builder->orLike($column, $searchValue);
            }
            $builder->groupEnd();
        }
    
        // Chức năng sắp xếp
        if (isset($orderColumn) && isset($orderDir)) {
            $builder->orderBy($columns[$orderColumn], $orderDir);
        }
    
        // Phân trang
        $limit = $request->getGet('length');
        $offset = $request->getGet('start');
        if (isset($limit) && isset($offset)) {
            $builder->limit($limit, $offset);
        }
    
        // Lấy dữ liệu
        $data = $builder->get()->getResultArray();
    
        // Đếm tổng số bản ghi
        $totalData = $this->userModel->countAll();
        $totalFiltered = $builder->countAllResults(false);
    
        $response = [
            'draw' => intval($request->getGet('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ];
    
        return $this->response->setJSON($response);
    }
    
    
    
    

    public function updateDataByAjax($id=null)
    {   



        // $data = $this->request->getRawInput();
        // $id = $data['id'];
        // unset($data['id']);
        // $this->userModel->update($id, $data);
        // return $this->response->setJSON(['status' => 'success']);



        $modelList = model('UserModel');
        $input = $this->request->getRawInput();
        // Lấy trường và giá trị để cập nhật
        $fieldData = $input['data'];
        $fieldData = array_shift($fieldData);
        $modelList->update($id, $fieldData);
        $response = [
            'status' => 201,
            'error' => null,
            'message' => [
                'success' => 'Update staff complete!',

            ],

            'data' => $fieldData

        ];
        
        return $this->response->setJSON($response);
        // return $this->respond($response);

    }
    
    public function deleteDataByAjax($id=null)
    {
        $modelList = model('UserModel');
        $modelList->delete($id);
        $response = [
            'status' => 200,
            'error' => null,
            'message' => [
                'success' => 'Delete staff complete!'
            ],
            'data' => []
        ];
        
        return $this->response->setJSON($response);
    }
    

    public function new(){

        $this->userModel->insert();
        
    } 
}

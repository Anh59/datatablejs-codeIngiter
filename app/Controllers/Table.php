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
        $data = $this->userModel->findAll();
        return $this->response->setJSON(['data' => $data]);
    }
    
    // public function createDataByAjax()
    // {
    //     $data = $this->request->getPost();
    //     $this->userModel->insert($data);
    //     return $this->response->setJSON(['status' => 'success']);
    //     // return $this->respond($response);
    // }
    
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

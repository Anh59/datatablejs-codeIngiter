<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class TableController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return view('livetable');
    }

    public function liveData()
    {
        $request = \Config\Services::request();
        $searchValue = $request->getGet('search')['value'] ?? ''; // Giá trị tìm kiếm
        $orderColumnIndex = $request->getGet('order')[0]['column'] ?? 0; // Chỉ số cột
        $orderDir = $request->getGet('order')[0]['dir'] ?? 'asc'; // asc hoặc desc
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
        if (isset($orderColumnIndex) && isset($orderDir)) {
            $builder->orderBy($columns[$orderColumnIndex], $orderDir);
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

    public function createDataByAjax()
    {   
        // $userModel = model('UserModel');
        $data = $this->request->getPost('data')[0];

        $this->userModel->insert($data);
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $data
        ]);   
    }

    public function updateDataByAjax($id = null)
    {
        $input = $this->request->getRawInput();
        $fieldData = $input['data'];
        $fieldData = array_shift($fieldData);

        $this->userModel->update($id, $fieldData);

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $fieldData
        ]);
    }

    public function deleteDataByAjax($id = null)
    {
        $this->userModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Delete complete'
        ]);
    }
}

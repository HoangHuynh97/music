<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        $data['dsa'] = '';
        return view('login/index', $data);
    }
    public function checkLogin()
    {
        $db = db_connect();

        $data = $this->request->getPost();
        $query = $db->query('select * from tbl_user where user = '.'"'.$data["user"].'"'.' and pw = '.'"'.$data["pw"].'"');
        $row = $query->getRow();

        if(isset($row)) {
            $session = session();
            $array = [
                "id" => $row->id,
                "name" => $row->name
            ];
            $session->set($array);

            $rep = [
                "message" => "success"
            ];
            echo json_encode($rep);
        } else {
            $rep = [
                "message" => "fail"
            ];
            echo json_encode($rep);
        }
    }
}

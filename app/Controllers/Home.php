<?php

namespace App\Controllers;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index()
    {
        echo view('header');
        echo view('users_list');
    }

    public function login()
    {
        echo view('header');
        echo view('login');
    }

    public function register()
    {
        echo view('header');
        echo view('register');
    }

    public function remove_user()
    {
        echo "User delete";
    }

    public function getUsersDatatable()
    {
        $userRows = new UserModel();
        $userRes = $userRows->getUsersRows();
        $data = array();
      
        foreach ($userRes['dataRows'] as $userData) {           
            //Action button
            $delActbtn = '<div class="btn-group">                    
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-banner" data-banner=' . $userData['id'] . '><span class="glyphicon glyphicon-trash"></span></a>
                    </div>';
            //Image tag
            $uImg = 'upload/noimg.png';
            if ($userData['image_gallery'] != NULL && $userData['image_gallery'] != '') {
                if(file_exists("upload/".$userData['image_gallery'])){
                    $uImg = "upload/".$userData['image_gallery'];
                  }
            }
            $user_img = img(['src'=>base_url($uImg), 'style'=>'width:50px;', 'class'=>'img-thumbnail']);
            
         
            $data[] = array(
                "id" => $userData['id'],
                "name" => ucwords($userData['name']),
                "username" => $userData['username'],
                "email" => $userData['email'],
                "image_gallery" => $user_img,              
                "action" => $delActbtn
            );
        }
        $userRes["aaData"] = $data;
        echo json_encode($userRes);

    }
}

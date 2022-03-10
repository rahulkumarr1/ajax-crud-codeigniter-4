<?php

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
    public function index()
    {
        echo view('header');
        echo view('home');
    }

    public function user_list()
    {
        if ($this->session->isUserLoggedIn) {
            echo view('header');
            echo view('users_list');
        }else{
            return redirect()->to(base_url());
        }
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
        $userId = $this->request->getPost('remId'); 
        $userRow = $this->db->table('users')->where(['id' => $userId])->get()->getRowArray();
      
        if ($this->request->isAJAX() && !empty($userRow)) {
            if ($this->db->table('users')->where('id', $userId)->delete()) { 
                // Remove User Images
                $imgFiles = json_decode($userRow['image_gallery']);
                if (!empty($imgFiles)) {
                    foreach ($imgFiles as $uImgs) {
                        if (file_exists("upload/" . $uImgs)) {
                            $uImg = "upload/" . $uImgs;
                            @unlink($uImg);
                        }                        
                    }
                }                          
                echo ("User record deleted successfully.");
                exit;
            } else {
                echo ("User record did not remove");
                exit;
            }
        } else {
            echo ("Something went wrong.");
            exit;
        }

        echo "User delete success";
    }

    public function register_user()
    {
        $this->validation->setRule('fullname', 'Full Name', 'required');
        $this->validation->setRule('username', 'Username', 'required|is_unique[users.username]');
        $this->validation->setRule('email', 'Email', 'required|is_unique[users.email]');
        $this->validation->setRule('password', 'Password', 'required');
        $this->validation->setRule('conf_password', 'Confirm Password', 'required|matches[password]');
        $this->validate($this->validation->getRules());
        $user_errors = $this->validation->getErrors();
        $user_list = $this->db->table('users');
        if (empty($user_errors)) {
            $filename = [];
            $fullname = $this->request->getPost('fullname');
            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            if ($files = $this->request->getFiles()) {
                foreach ($files['images'] as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getName();
                        $file->move('upload', $newName);
                        array_push($filename, $newName);
                    }
                }
            }

            $files_name = !empty($filename) ? json_encode($filename) : '';
            $register_user = ['name' => $fullname, 'username' => $username, 'email' => $email, 'password' => md5($password), 'image_gallery' => $files_name];
            $store = $user_list->insert($register_user);
            echo 'success';
        } else {
            foreach ($user_errors as $error) {
                echo '<div class="alert alert-danger" style="padding:5px;margin-bottom:5px;">' . $error . '</div>';
            }
        }
    }

    public function login_user()
    {

        $user_name = $this->request->getPost('username');
        $user_password = $this->request->getPost('password');

        if (!empty($user_name) && !empty($user_password)) {
            $user_list = $this->db->table('users');
            $checkLogin = $user_list->where(['username' => $user_name, 'password' => md5($user_password)])->get()->getRow();
            if (!empty($checkLogin)) {
                echo 'success';
                $this->session->set('isUserLoggedIn', true);
            } else {
                echo '<div class="alert alert-danger" style="padding:5px;margin-bottom:5px;">Username or password is wrong.!</div>';
            }
        }
    }

    public function getUsersDatatable()
    {
        $userRows = new UserModel();
        $userRes = $userRows->getUsersRows();
        $data = array();

        foreach ($userRes['dataRows'] as $userData) {
            //Action button
            $delActbtn = '<div class="btn-group">                    
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-user" data-user=' . $userData['id'] . '><span class="glyphicon glyphicon-trash"></span></a>
                    </div>';
            //Image tag
            $user_img = '';
            $uImg = 'upload/noimg.png';
            $imgFiles = json_decode($userData['image_gallery']);
            if (!empty($imgFiles)) {
                foreach ($imgFiles as $uImgs) {
                    if (file_exists("upload/" . $uImgs)) {
                        $uImg = "upload/" . $uImgs;
                    }
                    $user_img .= img(['src' => base_url($uImg), 'style' => 'width:50px;', 'class' => 'img-thumbnail']);
                }
            } else {
                $user_img = img(['src' => base_url($uImg), 'style' => 'width:50px;', 'class' => 'img-thumbnail']);
            }

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

    public function logout()
    {

        $rem_sess = ['isUserLoggedIn'];
        $this->session->remove($rem_sess);
        return redirect()->to(base_url());
    }
}

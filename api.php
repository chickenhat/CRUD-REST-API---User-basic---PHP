<?php
require 'restful_api.php';
require './class/database.php';
require './class/user.php';
class api extends restful_api {
	function __construct(){
		parent::__construct();
	}
	function user(){
        $db= new Database('root','','localhost','user');
        $user= new user($db);
        $result = array(
            'status' => '0'
        );
		if ($this->method == 'GET'){
			// Hãy viết code xử lý LẤY dữ liệu ở đây
			// trả về dữ liệu bằng cách gọi: $this->response(200, $data)
            if(empty($this->params)){
                $alluser = $user->GetAllUsers();
                if(count($alluser) > 0){
                $result['status'] = '1';
                $result['data'] = $alluser;
                } 
                else{
                $result['detail'] = 'No user register yet!';
            }
            }
            else {
                $auser = $user->GetUser($this->params['0']);
                if($auser){
                    $result['status'] = '1';
                    $result['data'] = $auser;
                }
                else{
                    $result['detail'] = 'User not found!';
            }
            }
        }
		 elseif ($this->method == 'POST'){
		// 	// Hãy viết code xử lý THÊM dữ liệu ở đây
		// 	// trả về dữ liệu bằng cách gọi: $this->response(200, $data)
            $username=$this->params['username'];
            $password=$this->params['password'];
            $email=$this->params['email'];
            $profileName=$this->params['profileName'];
            if(!$user->Exist($username)){
            $user->AddUser($username,$password,$email,$profileName);
            $result['status'] = '1';
            $result['detail'] = 'User has been added!';
            }
            else{
            $result['detail'] = 'User exist!';
            }   
        }
		 elseif ($this->method == 'PUT'){
		// 	// Hãy viết code xử lý CẬP NHẬT dữ liệu ở đây
		// 	// trả về dữ liệu bằng cách gọi: $this->response(200, $data)
            $input=array();
            $data=explode('&',$this->file);
            foreach($data as $val){
                $tmp=explode('=',$val);
                $input[$tmp[0]]=$tmp[1];
            }
            $username=$input['username'];
            $password=$input['password'];
            $email=$input['email'];
            $profileName=$input['profileName'];
            $auser = $user->ChangeUser($username,$password,$email,$profileName);
                if($auser){
            $result['status'] = '1';
            $result['detail'] = 'User profile has been changed!';
            }
            else{
            $result['detail'] = 'User not found!';
            }
        }
		 elseif ($this->method == 'DELETE'){
             // Hãy viết code xử lý XÓA dữ liệu ở đây
		    // trả về dữ liệu bằng cách gọi: $this->response(200, $data)
             if(!empty($this->params)){
                 $auser = $user->DelUser($this->params['0']);
                 if($auser){
                    $result['status'] = '1';
                    $result['detail'] = 'User has been deleted!';
                 }else{
                    $result['detail'] = 'User not found!';
                 }
             }
		 }
         $this->response(200,$result);
	}
    
}
$user = new api();
?>
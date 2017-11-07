<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Arpit
 * Date: 04-11-2017
 * Time: 00:00
 */

class Users extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user');
    }

    public function account(){
        $data = array();
        if($this->session->userdata('isUserLoggedIn')){
            $data['user'] = $this->user->getRows(array('id'=>$this->session->userdata('userId')));
            //load the view
            $this->load->view('user/account', $data);
        }
        else{
            redirect('users/login');
        }
    }

    /*
    * User login
    */
    public function login(){
        $data = array();
        if($this->session->userdata('success_msg')){
            $data['success_msg'] = $this->session->userdata('success_msg');
            $this->session->unset_userdata('success_msg');
        }
        if($this->session->userdata('error_msg')){
            $data['error_msg'] = $this->session->userdata('error_msg');
            $this->session->unset_userdata('error_msg');
        }
        if($this->input->post('loginSubmit')){
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'required');
            if ($this->form_validation->run() == true) {
                $con['returnType'] = 'single';
                $con['conditions'] = array(
                    'email'=>$this->input->post('email'),
                    'password' => md5($this->input->post('password')),
                    'status' => '1'
                );
                $checkLogin = $this->user->getRows($con);
                if($checkLogin){
                    $this->session->set_userdata('isUserLoggedIn',TRUE);
                    $this->session->set_userdata('userId',$checkLogin['id']);
                    redirect('users/account/');
                }else{
                    $data['error_msg'] = 'Wrong email or password, please try again.';
                }
            }
        }
        //load the view
        $this->load->view('user/login', $data);
    }

    /*
     * User registration
     */
    public function registration(){
        $data = array();
        $userData = array();
        if($this->input->post('regisSubmit')){
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[password]');

            $userData = array(
                'name' => strip_tags($this->input->post('name')),
                'email' => strip_tags($this->input->post('email')),
                'password' => md5($this->input->post('password')),
                'gender' => $this->input->post('gender'),
                'phone' => strip_tags($this->input->post('phone'))
                );
    //            $_SESSION['username'] = $userData['name'];
    //            $this->session->username($userData['name']);

            if($this->form_validation->run() == true){
                $insert = $this->user->insert($userData);
                if($insert){
                    $this->session->set_userdata('success_msg', 'Your registration was successful. Please login to your account.');
                    redirect('users/login');
                }else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
            }
        }
        $data['user'] = $userData;
        //load the view
        $this->load->view('user/registration', $data);
    }

    /*
     * User logout
     */
    public function logout(){
        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('userId');
        $this->session->sess_destroy();
        redirect('users/login/');
    }

    /*
     * Existing email check during validation
     */
    public function email_check($str){
        $con['returnType'] = 'count';
        $con['conditions'] = array('email'=>$str);
        $checkEmail = $this->user->getRows($con);
        if($checkEmail > 0){
            $this->form_validation->set_message('email_check', 'The given email already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /*
     * adding friend information into current User
     */

    public function addFriend(){
        $friends = array();
        $name_of_friend = $this->input->post('addfriend');
//        echo $name_of_friend;
        $friends['friendName'] = $name_of_friend;
        $friends['UserID'] = $this->session->userdata('userId');
        $insert = $this->user->insertFriendName($friends);
//        echo $insert;
        if($insert){
            $this->session->set_userdata('success_msg', 'This person is added to your friend list.');
            redirect('users/account/');
        }else{
            echo 'Some problems occurred, please try again.';
        }

    }

    /*
     * extract friends using current User'S id
     */

    public function getFriendsList(){
        $data = array();
        $userId = $this->session->userdata('userId');
//        echo $userId;
        $data['friends'] = $this->user->getFriends($userId);
//        print_r($data);
        if ($data){
            $this->load->view('user/friendList',$data);
        }else{
            echo 'Some problems occurred, please try again.';
        }
    }

    /*
     * DELETE friend using ID of to be deleted friend
     */

    public function deleteFriend(){
        $result = array();
        $deleteFriendById = $this->input->post('id');
//        $deleteFriendId = htmlentities($_POST['friendID']);
//        echo $deleteFriendById;
        $result['friends'] = $this->user->deleteFriendById($deleteFriendById);
        if ($result){
            $this->load->view('user/friendList',$result);
        }
        else{
            echo 'Some problems occurred, please try again.';
        }
    }

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class user extends REST_Controller {
  function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->database();
    $this->load->model(array("api/user_model"));
    $this->load->library(array("form_validation"));
    $this->load->helper("security");
  }

  function index_get(){
    $id = $this->get('id');
    $google_id = $this->get('google_id');
    if($id){
      $user = $this->user_model->get_user_id($id);
      if(count($user)>0){
        $this->response(array(
          "status" => 1,
          "message" => "User found",
          "data" => $user
        ), REST_Controller::HTTP_OK);
      }else{
        $this->response(array(
          "status" => 0,
          "message" => "User not found"
        ), REST_Controller::HTTP_OK);
      }
    }else if($google_id){
      $user = $this->user_model->check_user($google_id);
      if(count($user)>0){
        $this->response(array(
          "status" => 1,
          "message" => "User found",
          "data" => $user
        ), REST_Controller::HTTP_OK);
      }else{
        $this->response(array(
          "status" => 0,
          "message" => "User not found"
        ), REST_Controller::HTTP_OK);
      }
    }
  }

  function index_post(){
    $data = array(
      'id'=>$this->post('id'),
      'google_id'=>$this->post('google_id'),
      'name'=>$this->post('name'),
      'email'=>$this->post('email'),
      'gender'=>$this->post('gender'),
      'dob'=>$this->post('dob'));
    $id = $this->post('google_id');
    $user = $this->user_model->check_user($id);
    if(count($user)>0){
      //user already exist 
      $this->response(array(
        "status" => 0,
        "message" => "User already exist"
      ), REST_Controller::HTTP_NOT_FOUND);
    }else{
      //user not exist yet
      $insert = $this->user_model->insert_user($data);
      $this->response(array(
        "status" => 1,
        "message" => "User has been created"
      ), REST_Controller::HTTP_OK);
    }
  }
}
?>

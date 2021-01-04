<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class comment extends REST_Controller {
  function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->database();
    $this->load->model(array("api/comment_model"));
    $this->load->library(array("form_validation"));
    $this->load->helper("security");
  }

  function index_get(){
    $id = $this->get('id');
    $comments = $this->comment_model->get_comment($id);
    if(count($comments)>0){
      $this->response(array(
        "status" => 1,
        "message" => "Comment found",
        "data" => $comments
      ), REST_Controller::HTTP_OK);
    }else{
      $this->response(array(
        "status" => 0,
        "message" => "Comment not found",
        "data" => $comments
      ), REST_Controller::HTTP_NOT_FOUND);
    }
  }

  function index_post(){
    $data = array(
      'place_id'=>$this->post('place_id'),
      'user_id'=>$this->post('user_id'),
      'comment'=>$this->post('comment'));
    $insert = $this->comment_model->insert_comment($data);
    if ($insert) {
      $this->response(array(
        "status" => 1,
        "message" => "Comment inserted",
        "data" => $data
      ), REST_Controller::HTTP_OK);
    } else {
      $this->response(array(
        "status" => 0,
        "message" => "Failed to insert comment"
      ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  function index_put(){
    $id = $this->put('id');
    $data = array(
      'comment' => $this->put('comment'),
      'place_id' => $this->put('place_id'),
      'user_id' => $this->put('user_id'));
    $update = $this->comment_model->update_comment($id,$data);
    if ($update) {
      $this->response(array(
        "status" => 1,
        "message" => "Comment has been updated"
      ), REST_Controller::HTTP_OK);
    } else {
      $this->response(array(
        "status" => 0,
        "message" => "Failed to update comment"
      ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  function index_delete() {
    $id = $this->delete('id');
    $delete = $this->comment_model->delete_comment($id);
    if ($delete) {
      $this->response(array(
        "status" => 1,
        "message" => "Comment data deleted successfully"
      ),REST_Controller::HTTP_OK);
    } else {
      $this->response(array(
        "status" => 0,
        "message" => "Failed to deleted"
      ), REST_Controller::HTTP_NOT_FOUND);
    }
  }
}

?>
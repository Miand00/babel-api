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
}

?>
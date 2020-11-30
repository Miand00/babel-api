<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class moment extends REST_Controller {

  function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->database();
    $this->load->model(array("api/moment_model"));
    $this->load->library(array("form_validation"));
    $this->load->helper("security");
  }

  function index_get(){
    $id = $this->get('id');
    $moments = $this->moment_model->get_moment();

    if(count($moments)>0){
      if ($id == '') {
        $moments = $this->moment_model->get_moment();
      } else {
        $moments = $this->moment_model->get_moment_id($id);
      }
      $this->response(array(
        "status" => 1,
        "message" => "Moment found",
        "data" => $moments
      ), REST_Controller::HTTP_OK);
    }else{
      $this->response(array(
        "status" => 0,
        "message" => "No moment found",
        "data" => $moments
      ), REST_Controller::HTTP_NOT_FOUND);
    }
  }
}
?>

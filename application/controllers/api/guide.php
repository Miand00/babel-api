<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class guide extends REST_Controller {

  function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->database();
    $this->load->model(array("api/guide_model"));
    $this->load->library(array("form_validation"));
    $this->load->helper("security");
  }

  function index_get(){
    $id = $this->get('id');
    $search = $this->get('search');
    $guides = $this->guide_model->get_guide();
    if(count($guides)>0){
      if ($id == ''&& $search == '') {
        $guides = $this->guide_model->get_guide();
      } else if($search){
        $guides = $this->guide_model->get_guide_search($search);
      } else if($id) {
        $guides = $this->guide_model->get_guide_id($id);
      }
      $this->response(array(
        "status" => 1,
        "message" => "Guide found",
        "data" => $guides
      ), REST_Controller::HTTP_OK);
    }else{
      $this->response(array(
        "status" => 0,
        "message" => "No guide found",
        "data" => $guides
      ), REST_Controller::HTTP_NOT_FOUND);
    }
  }

}

?>
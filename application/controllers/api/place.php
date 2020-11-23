<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class place extends REST_Controller {

  function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->database();
    $this->load->model(array("api/place_model"));
    $this->load->library(array("form_validation"));
    $this->load->helper("security");
  }

  function index_get(){
    $id = $this->get('id');
    $places = $this->place_model->get_place();

    if(count($places)>0){
      if ($id == '') {
        $places = $this->place_model->get_place();
      } else {
        $places = $this->place_model->get_place_id($id);
      }
      $this->response(array(
        "status" => 1,
        "message" => "Wisata found",
        "data" => $places
      ), REST_Controller::HTTP_OK);
    }else{
      $this->response(array(
        "status" => 0,
        "message" => "No Wisata found",
        "data" => $places
      ), REST_Controller::HTTP_NOT_FOUND);
    }
  }
}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class place_image extends REST_Controller{
  function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->database();
    $this->load->model(array("api/place_image_model"));
    $this->load->library(array("form_validation"));
    $this->load->helper("security");
  }

  function index_get(){
    $id = $this->get('id');
    $places_image = $this->place_image_model->get_place_images($id);

    if(count($places_image)>0){
      $this->response(array(
        "status" => 1,
        "message" => "Image found",
        "data" => $places_image
      ), REST_Controller::HTTP_OK);
    }else{
      $this->response(array(
        "status" => 0,
        "message" => "No image found",
        "data" => $places_image
      ), REST_Controller::HTTP_OK);
    }
  }
}
?>
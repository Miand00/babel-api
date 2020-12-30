<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class rating extends REST_Controller {

  function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->database();
    $this->load->model(array("api/rating_model"));
    $this->load->library(array("form_validation"));
    $this->load->helper("security");
  }

  function index_get(){
    $place_id = $this->get('place_id');
    $user_id = $this->get('user_id');
    $ratings = $this->rating_model->get_rating($place_id, $user_id);
    if(count($ratings)>0){
      $this->response(array(
        "status" => 1,
        "message" => "Rating found",
        "data" => $ratings
      ), REST_Controller::HTTP_OK);
    }else{
      $this->response(array(
        "status" => 0,
        "message" => "No rating found",
        "data" => $ratings
      ), REST_Controller::HTTP_NOT_FOUND);
    }
  }

  function index_post() {
    $data = array(
      'rating' => $this->post('rating'),
      'place_id' => $this->post('place_id'),
      'user_id' => $this->post('user_id'));
    $insert = $this->rating_model->insert_rating($data);
    if ($insert) {
      $this->response(array(
        "status" => 1,
        "message" => "Rating has been created"
      ), REST_Controller::HTTP_OK);
    } else {
      $this->response(array(
        "status" => 0,
        "message" => "Failed to insert rating"
      ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  function index_put(){
    $id = $this->put('id');
    $data = array(
      'rating' => $this->put('rating'),
      'place_id' => $this->put('place_id'),
      'user_id' => $this->put('user_id'));
    $update = $this->rating_model->update_rating($id,$data);
    if ($update) {
      $this->response(array(
        "status" => 1,
        "message" => "Rating has been updated"
      ), REST_Controller::HTTP_OK);
    } else {
      $this->response(array(
        "status" => 0,
        "message" => "Failed to update rating"
      ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
?>

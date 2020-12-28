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

  function index_post(){
    $flag=$this->post('flag');

		if($flag=="INSERT")
		{	
			$config['upload_path'] = './image/place';
			$config['allowed_types'] = 'png|jpg|jpeg';
			$config['max_size'] = '20480';
			$image = $_FILES['image']['name'];
			$path="./image/place";
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('image')) 
			{
				$this->response(array(
          "status" => 0,
          "message" => "Failed to insert place"
        ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			} 
			else 
			{
        $data = array(
          'place_id' => $this->post('place_id'),
          'image'=> $image);
        $insert = $this->place_image_model->insert_image($data);
        $this->response(array(
          "status" => 1,
          "message" => "Place Image has been created"
        ), REST_Controller::HTTP_OK);
			}
		}
  }

  function index_delete() {
    $id = $this->delete('id');
    $queryimg = $this->place_image_model->get_image($id);
    foreach ($queryimg->result() as $row)
    {
      $picturepath="./image/place/".$row->image;	
      unlink($picturepath);
    }
    $delete = $this->place_image_model->delete_image($id);
    if ($delete) {
      $this->response(array(
        "status" => 1,
        "message" => "Place image data deleted successfully"
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
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
    $category = $this->get('category');
    $places = $this->place_model->get_place();
    if(count($places)>0){
      if ($id == '' && $category == '') {
        $places = $this->place_model->get_place();
      } else if($id) {
        $places = $this->place_model->get_place_id($id);
      } else if($category){
        $places = $this->place_model->get_place_category($category);
      }
      $this->response(array(
        "status" => 1,
        "message" => "Place found",
        "data" => $places
      ), REST_Controller::HTTP_OK);
    }else{
      $this->response(array(
        "status" => 0,
        "message" => "No place found",
        "data" => $places
      ), REST_Controller::HTTP_NOT_FOUND);
    }
  }

  function index_post(){
    $flag=$this->post('flag');

		if($flag=="INSERT")
		{	
			$config['upload_path'] = './image/';
			$config['allowed_types'] = 'png|jpg';
			$config['max_size'] = '20480';
			$image = $_FILES['image']['name'];
			$path="./image/";
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
							'id'=> $this->post('id'),
							'name' => $this->post('name'),
							'description'=> $this->post('description'),
              'image'=> $image);
        $insert = $this->place_model->insert_place($data);
        $this->response(array(
          "status" => 1,
          "message" => "Place has been created"
        ), REST_Controller::HTTP_OK);
			}
		}
		else if($flag=="UPDATE")
		{
			$config['upload_path'] = './image/';
			$config['allowed_types'] = 'png|jpg';
			$config['max_size'] = '20480';
			$path="./image/";
			$image = $_FILES['image']['name'];
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('image')) 
			{
				$this->response(array(
          "status" => 0,
          "message" => "Failed to update place data"
        ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			} 
			else 
			{
				$id = $this->post('id');
				
				$queryimg = $this->place_model->get_image($id);
				$row = $queryimg->row();
				$picturepath="./image/".$row->image;	
				unlink($picturepath);
				
				$data = array(
					'id'=> $this->post('id'),
					'name' => $this->post('name'),
					'description'=> $this->post('description'),
          'image'=> $image);
        $update = $this->place_model->update_place($id,$data);
        $this->response(array(
          "status" => 1,
          "message" => "Place data updated successfully"
        ),REST_Controller::HTTP_OK);
			}
		}	
  }

  function index_delete() {
    $id = $this->delete('id');

    $queryimg = $this->place_model->get_image($id);
    $row = $queryimg->row();
    $picturepath="./image/".$row->image;	
    unlink($picturepath);

    $delete = $this->place_model->delete_place($id);
    if ($delete) {
      $this->response(array(
        "status" => 1,
        "message" => "Place data deleted successfully"
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

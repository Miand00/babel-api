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
    $user_id = $this->get('user_id');
    $places = $this->place_model->get_place();
    if(count($places)>0){
      if ($id == '' && $category == '' && $user_id == '') {
        $places = $this->place_model->get_place();
      } else if($id) {
        $places = $this->place_model->get_place_id($id);
      } else if($category){
        $places = $this->place_model->get_place_category($category);
      } else if($user_id){
        $places = $this->place_model->get_place_owned($user_id);
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
        $id = $this->place_model->get_maxid()+1;
				$data = array(
          'id' => $id,
          'name' => $this->post('name'),
          'description'=> $this->post('description'),
          'latitude'=> $this->post('latitude'),
          'longitude'=> $this->post('longitude'),
          'user_id'=> $this->post('user_id'));
        $insert = $this->place_model->insert_place($data);
        $data2 = array(
          'place_id' => $id,
          'image'=> $image);
        $insert = $this->place_model->insert_image($data2);
        $data3 = array(
          'place_id' => $id);
        $insert = $this->place_model->insert_rating($data3);
        $data4 = array(
          'place_id' => $id,
          'category' => $this->post('category'));
        $insert = $this->place_model->insert_category($data4);
        $this->response(array(
          "status" => 1,
          "message" => "Place has been created"
        ), REST_Controller::HTTP_OK);
			}
		}
		else if($flag=="UPDATE")
		{
			$config['upload_path'] = './image/place';
			$config['allowed_types'] = 'png|jpg|jpeg';
			$config['max_size'] = '20480';
			$path="./image/place";
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

  function index_put() {
    $id = $this->put('id');
    $data = array(
                'id' => $this->put('id'),
                'name' => $this->put('name'),
                'description' => $this->put('description'),
                'latitude' => $this->put('latitude'),
                'longitude' => $this->put('longitude'));
    $update = $this->place_model->update_place($id,$data);
    if ($update) {
        $this->response($data, 200);
    } else {
        $this->response(array('status' => 'fail', 502));
    }
  }

  function index_delete() {
    $id = $this->delete('id');
    $queryimg = $this->place_model->get_image($id);
    foreach ($queryimg->result() as $row)
    {
      $picturepath="./image/place/".$row->image;	
      unlink($picturepath);
    }
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

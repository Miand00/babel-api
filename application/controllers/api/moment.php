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

  function index_post(){
    $flag=$this->post('flag');

		if($flag=="INSERT"){	
			$config['upload_path'] = './image/moment';
			$config['allowed_types'] = 'png|jpg|jpeg';
			$config['max_size'] = '20480';
			$image = $_FILES['image']['name'];
			$path="./image/moment";
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('image')) 
			{
				$this->response(array(
          "status" => 0,
          "message" => "Failed to insert moment"
        ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			} 
			else 
			{
				$data = array(
							'user_id'=> $this->post('user_id'),
							'title' => $this->post('title'),
							'story'=> $this->post('story'),
              'image'=> $image);
        $insert = $this->moment_model->insert_moment($data);
        $this->response(array(
          "status" => 1,
          "message" => "Moment has been created"
        ), REST_Controller::HTTP_OK);
			}
		}
  }
}
?>

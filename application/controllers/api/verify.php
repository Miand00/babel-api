<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class verify extends REST_Controller {
  function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->database();
    $this->load->model(array("api/verify_model"));
    $this->load->library(array("form_validation"));
    $this->load->helper("security");
  }

  function index_post(){
    $flag=$this->post('flag');

		if($flag=="INSERT"){	
			$config['upload_path'] = './image/verify';
			$config['allowed_types'] = 'png|jpg|jpeg';
			$config['max_size'] = '20480';
			$image = $_FILES['image']['name'];
			$path="./image/verify";
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('image')) 
			{
				$this->response(array(
          "status" => 0,
          "message" => "Failed to insert verify image"
        ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			} 
			else 
			{
				$data = array(
							'user_id'=> $this->post('user_id'),
              'image'=> $image);
        $insert = $this->verify_model->insert_verifies($data);
        $this->response(array(
          "status" => 1,
          "message" => "Verifies has been created"
        ), REST_Controller::HTTP_OK);
			}
		}
  }
} 

?>

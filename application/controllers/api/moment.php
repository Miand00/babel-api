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
    $user_id = $this->get('user_id');
    $moments = $this->moment_model->get_moment();

    if(count($moments)>0){
      if ($id == '' && $user_id == '') {
        $moments = $this->moment_model->get_moment();
      } else if($id){
        $moments = $this->moment_model->get_moment_id($id);
      } else if($user_id){
        $moments = $this->moment_model->get_moment_owned($user_id);
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
		}else if($flag=="UPDATE")
		{
			$config['upload_path'] = './image/moment';
			$config['allowed_types'] = 'png|jpg|jpeg';
			$config['max_size'] = '20480';
			$path="./image/moment";
			$image = $_FILES['image']['name'];
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('image')) 
			{
				$this->response(array(
          "status" => 0,
          "message" => "Failed to update moment data"
        ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			} 
			else 
			{
				$id = $this->post('id');
				
				$queryimg = $this->moment_model->get_image($id);
				$row = $queryimg->row();
				$picturepath="./image/moment/".$row->image;	
				unlink($picturepath);
				
				$data = array(
					'id'=> $this->post('id'),
          'image'=> $image);
        $update = $this->moment_model->update_moment($id,$data);
        $this->response(array(
          "status" => 1,
          "message" => "Moment data updated successfully"
        ),REST_Controller::HTTP_OK);
			}
		}	
  }

  function index_put() {
    $id = $this->put('id');
    $data = array(
                'id' => $this->put('id'),
                'user_id' => $this->put('user_id'),
                'title' => $this->put('title'),
                'story' => $this->put('story'));
    $update = $this->moment_model->update_moment($id,$data);
    if ($update) {
        $this->response($data, 200);
    } else {
        $this->response(array('status' => 'fail', 502));
    }
  }

  function index_delete() {
    $id = $this->delete('id');
    $queryimg = $this->moment_model->get_image($id);
    foreach ($queryimg->result() as $row)
    {
      $picturepath="./image/moment/".$row->image;	
      unlink($picturepath);
    }
    $delete = $this->moment_model->delete_moment($id);
    if ($delete) {
      $this->response(array(
        "status" => 1,
        "message" => "Moment data deleted successfully"
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

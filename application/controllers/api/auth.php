<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'vendor/autoload.php';
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class auth extends REST_Controller {
  function __construct($config = 'rest') {
    parent::__construct($config);
  }

  function index_post(){
    $CLIENT_ID = '979442053197-d0jqfqueitu1401aqsi43k4839imosen.apps.googleusercontent.com';
    $id_token = $this->post('idToken');
    $client = new Google_Client(['client_id' => $CLIENT_ID]);
    $payload = $client->verifyIdToken($id_token);
    if ($payload) {
      $userid = $payload['sub'];
      $this->response(array(
        "status" => 1,
        "message" => "Auth success",
        "data" => $userid
      ), REST_Controller::HTTP_OK);
    } else {
      $this->response(array(
        "status" => 0,
        "message" => "Auth failed",
        "data" => $userid
      ), REST_Controller::HTTP_OK);
    }
  }
}
?>
<?php

class place_image_model extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function get_place_images($id){
    $this->db->where('place_id', $id);
    $query = $this->db->get('places_images')->result();
    return $query;
  }
}

?>
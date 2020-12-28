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

  public function get_image($id){
    $query = $this->db->query("SELECT image FROM `places_images` WHERE id ='".$id."'");
    return $query;
  }

  public function insert_image($data){
    $query = $this->db->insert('places_images', $data);
    return $query;
  }

  public function delete_image($id){
    $this->db->where('id', $id);
    $query = $this->db->delete('places_images');
    return $query;
  }
}

?>
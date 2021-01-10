<?php

class place_model extends CI_Model{

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function get_maxid(){
    $query = $this->db->query("SELECT MAX(id) maxid FROM places");
    return $query->row()->maxid;
  }

  public function get_place(){
    $query = $this->db->query("SELECT a.*, d.image, CAST(COALESCE((b.totalRating/c.totalUser),0) AS DECIMAL(4, 1)) AS rating FROM places a, ( SELECT place_id, SUM(rating) AS totalRating FROM ratings GROUP BY place_id ) b, ( SELECT place_id, COUNT(user_id) AS totalUser FROM ratings GROUP BY place_id ) c, places_images d WHERE c.place_id = a.id AND b.place_id = a.id AND d.place_id = a.id AND (b.totalRating/c.totalUser) >= 4.5 GROUP BY a.id ORDER BY RAND() LIMIT 20");
    return $query->result();
  }

  public function get_place_id($id){
    $this->db->where('id', $id);
    $query = $this->db->get('places')->result();
    return $query;
  }

  public function get_place_owned($user_id){
    $query = $this->db->query("SELECT a.*, d.image, CAST(COALESCE((b.totalRating/c.totalUser),0) AS DECIMAL(4, 1)) AS rating FROM places a, ( SELECT place_id, SUM(rating) AS totalRating FROM ratings GROUP BY place_id ) b, ( SELECT place_id, COUNT(user_id) AS totalUser FROM ratings GROUP BY place_id ) c, places_images d WHERE c.place_id = a.id AND b.place_id = a.id AND d.place_id = a.id AND a.user_id = '".$user_id."' GROUP BY a.id ORDER BY a.id DESC");
    return $query->result();
  }

  public function get_place_category($category){
    $query = $this->db->query("SELECT a.*, d.image, CAST(COALESCE((b.totalRating/c.totalUser),0) AS DECIMAL(4, 1)) AS rating FROM places a, ( SELECT place_id, SUM(rating) AS totalRating FROM ratings GROUP BY place_id ) b, ( SELECT place_id, COUNT(user_id) AS totalUser FROM ratings GROUP BY place_id ) c, places_images d, categories e WHERE c.place_id = a.id AND b.place_id = a.id AND d.place_id = a.id AND e.place_id = a.id AND e.category = '".$category."' GROUP BY a.id");
    return $query->result();
  }

  public function get_place_search($category,$search){
    $query = $this->db->query("SELECT a.*, d.image, CAST(COALESCE((b.totalRating/c.totalUser),0) AS DECIMAL(4, 1)) AS rating FROM places a, ( SELECT place_id, SUM(rating) AS totalRating FROM ratings GROUP BY place_id ) b, ( SELECT place_id, COUNT(user_id) AS totalUser FROM ratings GROUP BY place_id ) c, places_images d, categories e WHERE c.place_id = a.id AND b.place_id = a.id AND d.place_id = a.id AND e.place_id = a.id AND e.category = '".$category."' AND a.name LIKE '%".$search."%' GROUP BY a.id");
    return $query->result();
  }

  public function get_image($id){
    $query = $this->db->query("SELECT image FROM `places_images` WHERE place_id ='".$id."'");
    return $query;
  }

  public function insert_place($data){
    $query = $this->db->insert('places', $data);
    return $query;
  }

  public function insert_image($data){
    $query = $this->db->insert('places_images', $data);
    return $query;
  }

  public function insert_category($data){
    $query = $this->db->insert('categories', $data);
    return $query;
  }

  public function insert_rating($data){
    $query = $this->db->insert('ratings', $data);
    return $query;
  }

  public function update_place($id, $data){
    $this->db->where('id', $id);
    $query = $this->db->update('places', $data);
    return $query;
  }

  public function delete_place($id){
    $this->db->where('id', $id);
    $query = $this->db->delete('places');
    return $query;
  }
}

?>
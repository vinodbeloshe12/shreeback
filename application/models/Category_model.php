<?php
  class Category_model extends CI_Model {

    public function __construct(){
       $this->load->database();
      }



      public function getAllCategory(){
        $query = $this->db->query("select * from category");
        $obj = new stdClass();
        if (!$query){
          $obj->value = false;
         $obj->message ="Data not found" ;
          return $obj ;
           }else{
          $obj->value = true;
          $obj->data = $query->result_array();
          return $obj ;
        }
      }



      public function createCategory($data){
        $this->db->insert('category',$data);
        $obj = new stdClass();
        if ($this->db->affected_rows() != 1){
          $obj->value = false;
         $obj->message ="Insertion failed" ;
          return $obj ;
      
        }else{
          $obj->value = true;
          $obj->message ="Record inserted" ;
          return $obj ;
        }
      }
      
      public function updateCategory($data,$id){
        $this->db->where('id', $id);  
          $this->db->update('category', $data);  
          $obj = new stdClass();
        if ($this->db->affected_rows() != 1){
          $obj->value = false;
         $obj->message ="Updation failed" ;
          return $obj ;
      
        }else{
          $obj->value = true;
          $obj->message ="Record updated" ;
          return $obj ;
        }
      }
      public function deleteCategory($id){
        $query= $this->db->query("delete from category where id=$id");
        $obj = new stdClass();
         if ($this->db->affected_rows() != 1){
           $obj->value = false;
          $obj->message ="Deletion failed" ;
           return $obj ;
       
         }else{
           $obj->value = true;
           $obj->message =" Records deleted,1 row affected" ;
           return $obj ;
         }
       }

}


?>
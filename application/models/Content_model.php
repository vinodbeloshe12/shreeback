<?php
  class Content_model extends CI_Model {

    public function __construct(){
       $this->load->database();
      }



      public function getAllContentPage(){
        $query = $this->db->query("select * from content");
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





   public function createContentPage($data){
    $this->db->insert('content',$data);
 $obj = new stdClass();
 if ($this->db->affected_rows() != 1){
   $obj->value = false;
  $obj->message ="Insertion failed" ;
   return $obj ;

 }else{
   $obj->value = true;
   $obj->message ="Content page created successfully!" ;
   return $obj ;
 }
}
public function updateContentPage($data, $id){
 $this->db->where('id', $id);  
 $this->db->update('content', $data);  
 $obj = new stdClass();
if ($this->db->affected_rows() != 1){
 $obj->value = false;
$obj->message ="Updation failed" ;
 return $obj ;

}else{
 $obj->value = true;
 $obj->message ="Content page updated successfully!" ;
 return $obj ;
}
}


public function deleteContent($id){
  $query= $this->db->query("delete from content where id=$id");
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

 public function search($term){
   $query=$this->db->query("select * from product where name_english like '%$term%'");
   $obj = new stdClass();
   if (!$query){
     $obj->value = false;
    $obj->message ="Records not found" ;
     return $obj ;
 
   }else{
     $obj->value = true;
     $obj->data = $query->result_array();
     return $obj ;
   }
 }

}


?>
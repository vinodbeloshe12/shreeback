<?php
class Home_model extends CI_model{
    public function __construct(){
        $this->load->database();
       }

       public function getNavigation(){
        $query= $this->db->query("select * from `navigation`");
        $obj = new stdClass();
        if(!$query){
          $obj->value = false;
          $obj->message ="Records not found" ;
          return $obj ;
        }else{
          $obj->value = true;
          $obj->data = $query->result_array();
         return $obj ;
        }
       }



       public function getContent($name){
        $query= $this->db->query("select * from `content` where name='$name'");
        $obj = new stdClass();
        if(!$query){
          $obj->value = false;
          $obj->message ="Records not found" ;
          return $obj ;
        }else{
          $obj->value = true;
          $obj->data = $query->row();
         return $obj ;
        }
       }


       public function getContact(){
        $query= $this->db->query("select * from `contact` order by id desc");
        $obj = new stdClass();
        if(!$query){
          $obj->value = false;
          $obj->message ="Records not found" ;
          return $obj ;
        }else{
          $obj->value = true;
          $obj->data = $query->result_array();
         return $obj ;
        }
       }

       public function deleteContact($id){
        $query= $this->db->query("delete from contact where id=$id");
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
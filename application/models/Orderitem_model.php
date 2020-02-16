<?php
  class OrderItem_model extends CI_Model {

    public function __construct(){
       $this->load->database();
      }
//create order
public function createOrderItem($data){
    $this->db->insert('order_item',$data);
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
//update order item
  public function updateOrderItem($data,$id){
    $this->db->where('id', $id);  
      $this->db->update('order_item', $data);  
    
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
//delete order item by id
  public function deleteOrderItem($id){
    $query= $this->db->query("delete from order_item where id=$id");
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
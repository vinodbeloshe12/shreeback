<?php
class Productwatch_model extends CI_model{
    public function __construct(){
        $this->load->database();
       }

       public function addToWatchlist($data){
        $this->db->insert('wishlist',$data);
        $obj = new stdClass();
        if ($this->db->affected_rows() != 1){
          $obj->value = false;
         $obj->message ="Insertion failed" ;
          return $obj ;
       
        }else{
          $obj->value = true;
          $obj->message ="Wishlist page created successfully!" ;
          return $obj ;
        }
       }

       public function getWatchlist(){
        $user = $this->session->userData->data['id'];
        $query = $this->db->query("select w.`id`,w.product,p.id as product_id,p.name ,pi.image, p.final_price , p.discount, p.price, w.`user` FROM `wishlist` w LEFT JOIN product p ON p.id=w.product Left JOIN product_image pi ON pi.product_id=p.id WHERE w.user=$user GROUP BY p.id");
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

       //delete 
  public function deleteWatchlist($id){
    $query= $this->db->query("delete from wishlist where id=$id");
    $obj = new stdClass();
     if ($this->db->affected_rows() != 1){
       $obj->value = false;
         $obj->message ="Deletion failed" ;
       return $obj ;
      }else{
      $obj->value = true;
       $obj->message ="Product removed from Wishlist" ;
       return $obj ;
     }
   }


      
}
?>
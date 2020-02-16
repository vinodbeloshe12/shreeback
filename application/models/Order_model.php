<?php
  class Order_model extends CI_Model {

    public function __construct(){
       $this->load->database();
       $this->load->library('session');
      }

      //submit order
public function submitOrder($data){
 $obj = new stdClass();
  $checkCartItems = $this->order_model->checkCartItems($data['user_id']);
  if($checkCartItems->value){
  $query= $this->db->insert('order',$data);
  $orderId=$this->db->insert_id();
  if(!$query){
    $obj->value = false;
    $obj->message ="Insertion failed" ;
     return $obj ;
  }
    else{
      //insert order items
     $orderItems= $this->order_model->insertOrderItems($orderId);
     if($orderItems){
       //update order total & items
       $this->order_model->updateOrderTotal($orderId);
       //send email
       $orderdata['data']=$this->order_model->getOrderbyId($orderId)->data;
       $orderdata['items']=$this->order_model->getOrderItemsbyOrderId($orderId)->data;
       $viewcontent = $this->load->view('emailers/orderemail', $orderdata, true);
       $this->email_model->emailer($viewcontent,'Order Placed - ShreeYantra','shreeyantra2019@gmail.com',"Vinod");
       //remove cart items
       $this->order_model->removeCartItems();
      $obj->value = true;
      $obj->message ="Record inserted" ;
      return $obj ;
     }else{
      $obj->value = false;
      $obj->message ="Insertion failed" ;
       return $obj ;
     }
    }
  }else{
    $obj->value = false;
    $obj->message ="Cart is Empty" ;
     return $obj ;
  }
  }
  


//insert order items from cart
public function insertOrderItems($orderId){
  $currency = $this->session->currency;
  $currencyData = $this->db->query("select * from currency where currency_name='$currency'")->row();
   if(!$currency){
    $currencyId = "1";
  }else{
    $currencyId= $currencyData->id;
  }
  $user = $this->session->userData->data['id'];
  if($user){
    $cartItems = $this->db->query("select c.`product_id`, c.`quantity`,  pp.price as `final_price` FROM `cart` c LEFT JOIN product_price pp ON c.product_id=pp.product_id WHERE c.`user_id`=$user and pp.currency_id=$currencyId")->result_array();
  }else{
    $cartItems = $this->session->cartData?$this->session->cartData:array();
  }
foreach($cartItems as $value){
  $product_id =$value['product_id'];
  $quantity =$value['quantity'];
  $price =$user?$value['final_price']:$value['price'];
  $query= $this->db->query("insert into `order_item`(`order_id`, `product_id`, `quantity`, `price`) VALUES ($orderId,$product_id,$quantity,$price)");
}
if($query){
  return true ;
}else{
  return false;
}
}

//update order total & items
public function updateOrderTotal($orderId){
  $query = $this->db->query("SELECT SUM(price) as total, COUNT(order_id) as 'items' FROM `order_item` WHERE order_id=$orderId")->row();
  $updateQuery = $this->db->query("update orders set items=$query->items, total=$query->total where id=$orderId");
}

//remove cart items
public function removeCartItems(){
  $user = $this->session->userData->data['id'];
  if($user){
$query = $this->db->query("delete from cart where user_id=$user");
$obj = new stdClass();
if($query){
  $obj->value = true;
  $obj->message ="Cart Items Removed" ;
  return $obj ;
}else{
  $obj->value = false;
  $obj->message ="Something went wrong" ;
  return $obj ;
}
}
else{
  $this->session->unset_userdata('cartData');
  $obj->value = true;
  $obj->message ="Cart Items Removed" ;
  return $obj ;
}
}

//check cart items
public function checkCartItems($user){
  if(!$user){
    $user = $this->session->userData->data['id'];
  }
  $obj = new stdClass();
  if($user){
    $query = $this->db->query("select * from cart where user_id=$user");
    if($query->num_rows()>0){
      $obj->value = true;
      $obj->data =$query->result_array();
      return $obj ;
    }else{
      $obj->value = false;
      $obj->message ="Cart is empty";
      return $obj ;
    }
  }else{
    if($this->session->cartData){
      $obj->value = true;
      $obj->data =$this->session->cartData;
      return $obj ;
    }else{
      $obj->value = false;
      $obj->message ="Cart is empty";
      return $obj ;
    }
   }
 
}

//create order
public function createOrder($data){
    $this->db->insert('orders',$data);
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

  public function updateOrder($data,$id){
    $this->db->where('id', $id);  
      $this->db->update('orders', $data);  
    
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

  public function getAllOrders(){
          $query=$this->db->query("select * from  `order` order by id desc");
            $obj = new stdClass();
       if($query->num_rows() > 0){
         $obj->value = true;
         $obj->data = $query->result_array();
         return $obj ;
       }else{
         $obj->value = false;
         $obj->data = [];
         $obj->message ="Records not found on your specific input" ;
         return $obj ;
       }
     }
 
     public function getOrderbyUserId($user_id){
          $query=$this->db->query("select * from  `order` where user=$user_id order by id desc");
            $obj = new stdClass();
       if($query->num_rows() > 0){
         $obj->value = true;
         $obj->data = $query->result_array();
         return $obj ;
       }else{
         $obj->value = false;
         $obj->data = [];
         $obj->message ="Records not found on your specific input" ;
         return $obj ;
       }
     }
 
     public function getOrderbyId($id){
      $query=$this->db->query("select * from  `order` where id=$id");
      $obj = new stdClass();
     if($query->num_rows() > 0){
       $obj->value = true;
       $obj->data = $query->row();
      $obj->order_items = $this->order_model->getOrderItemsbyOrderId($id)->data;
       return $obj ;
     }else{
       $obj->value = false;
       $obj->data = [];
       $obj->message ="Records not found on your specific input" ;
       return $obj ;
     }
   }

   public function getOrderItemsbyOrderId($id){
    $query=$this->db->query("select oi.`id`, oi.`order_id`, oi.`product_id`, p.name, pi.image, oi.`quantity`, oi.`price` from `order_item` oi LEFT JOIN product p ON oi.product_id=p.id LEFT JOIN product_image pi ON pi.product_id=p.id WHERE oi.order_id=$id GROUP BY p.id");
    $obj = new stdClass();
   if($query->num_rows() > 0){
     $obj->value = true;
     $obj->data = $query->result_array();
     return $obj ;
   }else{
     $obj->value = false;
     $obj->data = [];
     $obj->message ="Records not found on your specific input" ;
     return $obj ;
   }
 }

   public function deleteOrder($id){
    $query= $this->db->query("delete from order where id=$id");
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
     

   public function updateOrderStatus($orderstatus,$id){
    $query = $this->db->query("update `order` set orderstatus=$orderstatus where id=$id");
   $obj = new stdClass();
   if (!$query){
     $obj->value = false;
    $obj->message ="Updation failed" ;
     return $obj ;
 
   }else{
     if($orderstatus==3){
       $orderdata['data']=$this->order_model->getOrderbyId($id)->data;
       $viewcontent = $this->load->view('emailers/ordershipped', $orderdata, true);
       $this->email_model->emailer($viewcontent,'Order Dispatched - Mukesh Jewellers','makedigitaldesigners@gmail.com',"Vinod");
     }
     if($orderstatus==5){
       $orderdata['data']=$this->order_model->getOrderbyId($id)->data;
       $viewcontent = $this->load->view('emailers/oredercancel', $orderdata, true);
       $this->email_model->emailer($viewcontent,'Order Cancelled - Mukesh Jewellers','makedigitaldesigners@gmail.com',"Vinod");
     }
     $obj->value = true;
     $obj->message ="Record updated" ;
     return $obj ;
   }
 }

    }
    ?>
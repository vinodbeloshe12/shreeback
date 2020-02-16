<?php
  class cart_model extends CI_Model {

    public function __construct(){
             $this->load->database();
            }
//create cart
public function addToCart($data){
  $obj = new stdClass();
  if($this->session->userData){
    $user = $this->session->userData->data['id'];
    $data['user_id']= $user;
    $this->db->insert('cart',$data);
    $query=$this->db->query("select SUM(quantity) AS TotalItemsInCart FROM cart WHERE user_id=$user")->row();
    if ($this->db->affected_rows() != 1){
      $obj->value = false;
      $obj->TotalItemsInCart =$query->TotalItemsInCart;
      $obj->message ="Insertion failed" ;
      return $obj ;
  
    }else{
      $obj->value = true;
      $obj->TotalItemsInCart =$query->TotalItemsInCart;
      $obj->message ="Record inserted" ;
      return $obj ;
    }
  }else{
    //guest user cart
    $newdata = $this->session->cartData?$this->session->cartData:array();
    $index = array_search($data['product_id'], array_column($newdata, 'product_id'));
    //update cart quantity
    if(in_array($data['product_id'], array_column($newdata, 'product_id'))) { // search value in the array
      // echo "FOUND".$index;
      $newdata[$index]['quantity']= $newdata[$index]['quantity'] +$data['quantity'];
    }else{
      $pid=$data['product_id'];
      $this->load->helper('string');
      $productData = $this->db->query("select p.name,pi.image,  p.price , p.discount, p.final_price,p.quantity FROM product p Left JOIN product_image pi ON pi.product_id=p.id WHERE p.id=$pid group by p.id")->row();
      $data['price']=$productData->price;
      $data['discount']=$productData->discount;
      $data['quantity']=1;
      $data['final_price']=$productData->final_price;
      $data['image']=$productData->image;
      $data['name']=$productData->name;
      $randId =random_string('alnum',10);
      $data['id']=$randId;
      array_push($newdata,$data);
    }
    $this->session->set_userdata('cartData',$newdata );
    $obj->value = true;
    $obj->TotalItemsInCart = array_sum(array_column($newdata,'quantity'));
    $obj->message ="Record inserted" ;
    return $obj ;
  }
  }
  //update cart
  public function updateCart($data,$id){
    $this->db->where('id', $id);  
      $this->db->update('cart', $data);  
      $user = $this->session->userData->data['id'];
      $query=$this->db->query("select SUM(quantity) AS TotalItemsInCart FROM cart WHERE user_id=$user")->row();
    $obj = new stdClass();
    if ($this->db->affected_rows() != 1){
      $obj->value = false;
     $obj->message ="Updation failed" ;
     $obj->TotalItemsInCart =$query->TotalItemsInCart;
      return $obj ;
  }else{
      $obj->value = true;
      $obj->message ="Record updated" ;
      $obj->TotalItemsInCart =$query->TotalItemsInCart;
      return $obj ;
    }
  }


  //  update cart for guest user
  public function updateGuestUserCart($data,$id){
    if($this->session->cartData){
      $cartData = $this->session->cartData;
      $index = array_search($id, array_column($cartData, 'id'));
      $cartData[$index]['quantity']=$data['quantity'];
      $this->session->set_userdata('cartData',$cartData );
      $obj->value = true;
      $obj->TotalItemsInCart = array_sum(array_column($this->session->cartData,'quantity'));
      $obj->message ="Record updated" ;
      return $obj ;
    }else{
      $obj->value = false;
      $obj->TotalItemsInCart =array_sum(array_column($this->session->cartData,'quantity'));
      $obj->message ="Updation failed" ;
      return $obj ;
    }
  }

  //delete cart
  public function deleteCart($id,$user){
    $query= $this->db->query("delete from cart where id=$id");
    $obj = new stdClass();
    $query=$this->db->query("select SUM(quantity) AS TotalItemsInCart FROM cart WHERE user_id=$user")->row();
     if ($this->db->affected_rows() != 1){
       $obj->value = false;
       $obj->TotalItemsInCart =$query->TotalItemsInCart;
      $obj->message ="Deletion failed" ;
       return $obj ;
      }else{
      $obj->value = true;
      $obj->TotalItemsInCart =$query->TotalItemsInCart;
       $obj->message =" Records deleted,1 row affected" ;
       return $obj ;
     }
   }

  //  delete cart for guest user
  public function deleteGuestUserCart($id){
    if($this->session->cartData){
      $cartData = $this->session->cartData;
      $index = array_search($id, array_column($cartData, 'id'));
      array_splice($cartData, $index, 1);
      $this->session->set_userdata('cartData',$cartData );
      $obj->value = true;
      $obj->TotalItemsInCart = array_sum(array_column($this->session->cartData,'quantity'));
      $obj->message ="Records deleted,1 row affected" ;
      return $obj ;
    }else{
      $obj->value = false;
      $obj->TotalItemsInCart =array_sum(array_column($this->session->cartData,'quantity'));
      $obj->message ="Deletion failed" ;
      return $obj ;
    }
  }


  //get cart 
  public function getCart($user){
 $query = $this->db->query("select c.`id`,p.quantity,c.product_id,p.name ,pi.image, p.final_price , p.discount, p.price, (SELECT SUM(c.quantity) AS quantity FROM cart c where c.product_id=p.id and c.user_id=$user) as quantity, c.`user_id`, c.`timestamp` as date FROM `cart` c LEFT JOIN product p ON p.id=c.product_id Left JOIN product_image pi ON pi.product_id=p.id WHERE c.user_id=$user GROUP BY p.id");
//  $cart_list = '<ul>';

// foreach($query->result_array() as $key => $row){
//   $cart_list .=<<<CARTSTART
//   <li>
//   <p>
//   <img src="{$row["image"]}" width="90" alt="">
//   {$row["name"]} <button>Edit</button>  <button>Delete</button></p>
//   <p><span>{$row["quantity"]}</span> X {$row["price"]}</p>
//   </li>
// CARTSTART;
 
// }
//   $cart_list .= '</ul>';
       $obj = new stdClass();
       $cartquery=$this->db->query("select SUM(quantity) AS TotalItemsInCart FROM cart WHERE user_id=$user")->row();
       $carttotalquery=$this->db->query("SELECT SUM(c.quantity * p.final_price) AS total FROM cart c LEFT JOIN product p ON c.product_id=p.id where c.product_id=p.id and c.user_id=$user")->row();

       if($query->num_rows() > 0){
         $obj->value = true;
        $obj->TotalItemsInCart =$cartquery->TotalItemsInCart;
        $obj->CartTotal =$carttotalquery->total;
        // $obj->html = $query->num_rows() > 0?$cart_list:'<h4>Data Not Found</h4>';
         $obj->data = $query->result_array();
         return $obj ;
       }else{
         $obj->value = false;
         $obj->data = [];
         $obj->CartTotal =$carttotalquery->total;
         $obj->TotalItemsInCart =$cartquery->TotalItemsInCart;
         $obj->message ="Records not found on your specific input" ;
         return $obj ;
       }
     }


     //get cart for guest user
    public function getGuestUserCart($lang){
    $obj = new stdClass();
    if($this->session->cartData){
      $total =0;
      foreach($this->session->cartData as $key => $value){
       $total =  $total+( $value['quantity'] * $value['final_price']);
      }
    $obj->value = true;
    $obj->TotalItemsInCart = array_sum(array_column($this->session->cartData,'quantity'));
    $obj->CartTotal =$total;
    $obj->data = $this->session->cartData;
    return $obj;
     }else{
       $obj->value = false;
       $obj->data = [];
       $obj->TotalItemsInCart =0;
       $obj->message ="Records not found on your specific input" ;
       return $obj ;
     }
   }


     //check cart 
public function checkCart($product_id,$user){
    $query=$this->db->query("select id, product_id, quantity FROM `cart` WHERE user_id=$user and product_id=$product_id")->row();
     $obj = new stdClass();
       if($query){
       $obj->value = true;
       $obj->data = $query;
       return $obj ;
     }else{
       $obj->value = false;
       $obj->data = [];
       $obj->message ="Records not found on your specific input" ;
       return $obj ;
     }
   }

    }
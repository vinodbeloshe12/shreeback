<?php
class Product_model extends CI_model{
    public function __construct(){
        $this->load->database();
        $this->load->helper('url');
       }

       public function getAllProduct($data){
           $categoryId =$data['categoryId'];
       $priceMin = $data['filterObj']['price'][0];
       if(!$priceMin){
        $priceMin=0;
       }
       $priceMax = $data['filterObj']['price'][1];
           if(!$priceMax){
            $priceMax=950000;
           }
        $inMetalArr ="";
        foreach($data['filterObj']['metal'] as $val){
                       $inMetalArr .= "'".$val. "',";
        }
        foreach($data['filterObj']['purity'] as $val){
            $inMetalArr .= "'".$val. "',";
        }
            $inMetalArr = substr_replace($inMetalArr, "", -1);
            $currency ='₹';
        if($data['sortBy']=='low'){
            $orderBy = 'asc';
         }else if($data['sortBy']=='high'){
             $orderBy = 'desc';
        }
        if($inMetalArr){
            $q="SELECT p.`id`, p.`name`,pi.image , p.`description`, p.`price`, p.`discount`,  p.`final_price`,  p.`metatitle`, p.`metadesc`, p.`metakeyword`, p.`quantity`, p.`subcategory`, p.`category`, p.`sizechart` FROM `product` p LEFT JOIN product_image pi ON p.id=pi.product_id LEFT JOIN product_specification ps ON ps.product_id=p.id WHERE p.category=$categoryId AND ps.value IN ($inMetalArr) AND p.`final_price` BETWEEN $priceMin AND $priceMax  GROUP BY p.id ORDER BY final_price $orderBy";
        }else{
            $q="SELECT p.`id`, p.`name`,pi.image , p.`description`, p.`price`, p.`discount`,  p.`final_price`,  p.`metatitle`, p.`metadesc`, p.`metakeyword`, p.`quantity`, p.`subcategory`, p.`category`, p.`sizechart` FROM `product` p LEFT JOIN product_image pi ON p.id=pi.product_id  WHERE p.category=$categoryId AND p.`final_price` BETWEEN $priceMin AND $priceMax  GROUP BY p.id ORDER BY final_price $orderBy";
        }
      
        //  echo $q;
             $query= $this->db->query($q);

        $products_list =  '<ul class="row">';
    foreach ($query->result_array() as $key => $row) {
        $discountPrice = $row['price']!=$row['final_price']  && $row['price']!=0?$currency.$row["price"]:'';
$products_list .= <<<EOT
<li class="col-lg-4 product_form">

<a href="details.php?name={$row['name']}"> <div class="listing-image-box"><img class="img-fluid" src="{$row["image"]}"></a>
   <div class="product-listing-buttons">
           <input id="{$row["id"]}" name="product_id" type="hidden" value="{$row["id"]}">
           <button><i id="{$row["id"]}" onclick="addToCart(event)" class="fa fa-shopping-bag"></i></button>
           <button type="submit"><i  class="fa fa-exchange"></i></button>
           <button type="submit"><i id="{$row["id"]}" onclick="addToWatchlist(event)" class="fa fa-heart"></i></button>
           <button type="submit"><i class="fa fa-eye"></i></button>
       </div>
       </div>
   
   <span class="stock-available">Stock:{$row["quantity"]}</span>
   <h4><a href="details.php?name={$row['name']}">{$row["name"]}</a></h4>
   <span class="price-listing">
   <span class="offer-price"> {$discountPrice}</span>
   {$currency} {$row["final_price"]}</span> 
   <div class="listing-price-box">
  </div>
  
</li>

EOT;
    }
// }
$products_list .= '</ul></div>';

        $obj = new stdClass();
        if(!$query){
          $obj->value = false;
          $obj->html = '<h4>Data Not Found</h4>';
          $obj->message ="Records not found" ;
          return $obj ;
        }else{
          $obj->value = true;
          $obj->html = $query->num_rows() > 0?$products_list:'<h4>Data Not Found</h4>';
          $obj->data = $query->result_array();
         return $obj ;
        }
       }


###############$$$$$$$$>>>>>>>>?????????????
       public function getAllProductAdmin(){
        $query = $this->db->query("select * from product");
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


       //create product
public function createProduct($data){
    // $string_version = implode(',', $data)
   $insertData=array("name" => $data['name'],"category" =>  $data['category'],"description" =>  $data['description'],"price" =>  $data['price'],"discount" =>  $data['discount'],"final_price" =>  $data['final_price'],"quantity" =>  $data['quantity'],"user" =>  $data['user'],"order" =>  $data['order'],"metatitle" =>  $data['metatitle'],"metadesc" =>  $data['metadesc'],"metakeyword" =>  $data['metakeyword'],"status" =>  $data['status']);
   $this->db->insert('product',$insertData);
   $obj = new stdClass();
   if ($this->db->affected_rows() != 1){
     $obj->value = false;
    $obj->message ="Insertion failed" ;
     return $obj ;
 
   }else{
     $productId =$this->db->insert_id();
      $this->product_model->insertProductImages($data['images'],$productId);
     $this->product_model->insertRelatedProduct($data['realated'],$productId);
     $obj->value = true;
     $obj->message ="Record inserted" ;
     return $obj ;
   }
 }

//  update product
public function updateProduct($data,$id){
    $q="update product set name='".$data['name']."',  category='".$data['category']."',description='".$data['description']."',price='".$data['price']."',discount='".$data['discount']."',final_price='".$data['final_price']."',quantity='".$data['quantity']."',`order`='".$data['order']."',user='".$data['user']."',metatitle='".$data['metatitle']."',metadesc='".$data['metadesc']."',metakeyword='".$data['metakeyword']."',status='".$data['status']."' where id=$id";
    $query=$this->db->query($q);
   $obj = new stdClass();
   if (!$query){
     $obj->value = false;
    $obj->message ="Updation failed" ;
     return $obj ;
     }else{
       if($data['images']){
         $this->product_model->insertProductImages($data['images'],$id);
       }
       if($data['realated']){
         $this->db->query("delete from related_product where product=$id");
         $this->product_model->insertRelatedProduct($data['realated'],$id);
       }
       $obj->value = true;
     $obj->message ="Record updated" ;
     return $obj ;
   }
 }


 public function insertProductImages($data,$productId){
    $obj = new stdClass();
   $DataArr = array();
   foreach ($data as $key => $value){
       array_push($DataArr,array("image" => $value['image_name'],"product_id" => $productId));
   }
   $this->db->insert_batch('product_image',$DataArr);
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

 public function insertRelatedProduct($data,$productId){
    $obj = new stdClass();
    $adata = json_decode($data, true);
    $DataArr = array();
    foreach ($adata as $key => $value){
    array_push($DataArr,array("product" => $productId,"relatedproduct" => $value));
  }
  $this->db->insert_batch('related_product',$DataArr);
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

  public function getProductById($id){
    $obj = new stdClass();
    $query=$this->db->query("select *from product where id=$id");
    // $reviews = $this->db->query("select `id`, `product_id`, `date`, `name`, `comments`, `rating`, `email` FROM `reviews` WHERE product_id=$id");
    $images = $this->db->query("select * from `product_image` where product_id=$id");
    $realated_product = $this->db->query("select rp.`id`, rp.`product`, rp.`relatedproduct`, p.name,pi.image FROM `related_product` rp LEFT JOIN product p ON rp.relatedproduct=p.id LEFT JOIN product_image pi ON p.id=pi.product_id WHERE rp.product=$id GROUP BY p.id");
    if($query->num_rows() > 0){
      $obj->value = true;
      $obj->data = $query->row();
      $obj->images = $images->result_array();
     $obj->realated_product = $realated_product->result_array();
    //   $obj->reviews = $reviews->result_array();
      return $obj ;
    }else{
      $obj->value = false;
      $obj->data = [];
      $obj->message ="Records not found on your specific input" ;
      return $obj ;
    }
  }

  public function deleteProduct($id){
     $query= $this->db->query("delete from product where id=$id");
      $obj = new stdClass();
       if (!$query){
         $obj->value = false;
        $obj->message ="Deletion failed" ;
         return $obj ;
        }else{
          $obj->value = true;
         $obj->message =" Records deleted,1 row affected" ;
         return $obj ;
       }
     }

  public function deleteProductImage($id){
    $imageQuery = $this->db->query("select * from product_image where id=$id")->row();
     $query= $this->db->query("delete from product_image where id=$id");
      $obj = new stdClass();
       if (!$query){
         $obj->value = false;
        $obj->message ="Deletion failed" ;
         return $obj ;
        }else{
            unlink('../../uploads/'.$imageQuery->image_name);
         $obj->value = true;
         $obj->message =" Records deleted,1 row affected" ;
         return $obj ;
       }
     }


    
  

}
?>
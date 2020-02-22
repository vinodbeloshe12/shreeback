<?php
class User_model extends CI_model{
    public function __construct(){
        $this->load->database();
       }

public function getAllUsers(){
    $query = $this->db->query('SELECT `id`, `name`, `first_name`, `last_name`, `mobile`, `role`, `email`, `date`, `dob`, `status`, `username`, `password` FROM `user` WHERE `role`=3');
    $obj = new stdClass();
   if($query->num_rows() > 0){
     $obj->value = true;
     $obj->data = $query->result_array();
     return $obj ;
   }else{
     $obj->value = false;
     $obj->data = [];
     $obj->message ="Records not found" ;
     return $obj ;
   }
}
public function getSubscribe(){
    $query = $this->db->query('select * FROM `newsletter` order by id desc');
    $obj = new stdClass();
   if($query->num_rows() > 0){
     $obj->value = true;
     $obj->data = $query->result_array();
     return $obj ;
   }else{
     $obj->value = false;
     $obj->data = [];
     $obj->message ="Records not found" ;
     return $obj ;
   }
}

public function login($username, $password){
       $query = $this->db->query("SELECT `id`, `name`, `first_name`, `last_name`, `mobile`, `role`, `email`, `date`, `dob`, `status`, `username`, `password` FROM `user` WHERE  username='$username' and password='$password'");
       $obj = new stdClass();
       if($query->num_rows() > 0){
        $obj->value = true;
        $obj->data = $query->result_array()[0];
        return $obj ;
       }else{
        $obj->value = false;
        $obj->data = [];
        $obj->message ="Invalid Username/Password" ;
        return $obj ;
       }
   
}

public function register($fname,$lname,$mobile,$alternate_mobile,$dob,$email,$username,$role){
  $obj = new stdClass();
  if(trim($email, " ") && trim($username, " ")){
  // if($this->user_model->checkUserEmail($email)->value){
    if($this->user_model->checkUser($username)->value){
 $query = $this->db->query("insert into user (`name`, `first_name`, `last_name`, `mobile`, `alternate_mobile`, `role`, `email`, `dob`, `username`)values('$fname.' '.$lname','$fname','$lname','$mobile','$alternate_mobile',$role,'$email','$dob','$username')");
 if($query){
  $id=$this->db->insert_id();
  $this->user_model->createPassword($id);
  $obj->value = true;
  $obj->message = "User registered successfully!";
  return $obj ;
}else{
  $obj->value = false;
  $obj->message ="Something went wrong, please try again later." ;
  return $obj ;
}
}else{
  return $this->user_model->checkUser($username);
}
// }else{
// return $this->user_model->checkUserEmail($email);
// }
}else{
  $obj->value = false;
  $obj->message ="Required" ;
  return $obj ;
}
}

public function createPassword($id){
  $obj = new stdClass();
  $this->load->helper('string');
  $passwrod=random_string('alnum',10);
  $query = $this->db->query("update user set password='$passwrod' where id=$id");
  if($query){
    // $data = $this->db->query("select * from user where id=$id")->row();
    // $sendData['data'] = $data;
    // $viewcontent = $this->load->view('emailers/registeruser', $sendData, true);
    // $this->email_model->emailer($viewcontent,'Welcome to Mukesh Jewellers',$data->email,"");
    $obj->value = true;
    $obj->message = "User registered successfully!";
    return $obj ;
  }else{
    $obj->value = false;
    $obj->message = "Error while generating password, please try again later.";
    return $obj ;
  }
}

public function checkUser($username){
  $query = $this->db->query("select * from user where username='$username'");
  $obj = new stdClass();
  if($query->num_rows() > 0){
    $obj->value = false;
    $obj->field = "username";
    $obj->message ="Username already exists. Please use a different username." ;
    return $obj ;
  }else{
    $obj->value = true;
    return $obj ;
 }
}
public function checkUserEmail($email){
  $this->load->helper('email');
 if (valid_email($email))
 {
  $query = $this->db->query("select * from user where email='$email'");
  $obj = new stdClass();
  if($query->num_rows() > 0){
    $obj->value = false;
    $obj->field = "email";
    $obj->message ="Email Address already registerd. Please use a different Email." ;
    return $obj ;
  }else{
    $obj->value = true;
    return $obj ;
 }
 }
 else
 {
$obj->value = false;
 $obj->field = "email";
 $obj->message ="Please enter valid Email Address." ;
 return $obj ;
 }
  
}

public function submitSubscribe($email){
  // if (valid_email($email)){
$checkSub = $this->db->query("select * from newsletter where email='$email'");
echo $query->num_rows();
$query = $this->db->query("insert into newsletter(email) values($email)");
  $obj = new stdClass();
  if($query){
    $obj->value = true;
    $obj->message = "Thank You. Please check your inbox to confirm your email address";
    return $obj ;
  }else{
    $obj->value = false;
    $obj->message ="Something went wrong, please try again later." ;
    return $obj ;
  } 
  // }
  // else{
  //   $obj->value = false;
  //   $obj->field = "email";
  //   $obj->message ="Please enter valid Email Address." ;
  //   return $obj ;
  // }
}


public function submitContact($name,$email,$phone,$subject,$message){
  $obj = new stdClass();
  if(trim($name, " ") && trim($phone, " ") && trim($email, " ") && trim($subject, " ") && trim($message, " ")){
    $this->load->helper('email');
    if (valid_email($email)){
// $query=$this->db->query("insert into contact (`name`, `phone`, `email`, `subject`, `message`) VALUES('$name','$phone','$email','$subject','$message') ");
$data=array("name" => $name,"email" => $email,"phone" => $phone,"subject" => $subject,"message" => $message);
$query=$this->db->insert( "contact", $data );
if($query){
  $id=$this->db->insert_id();
  $data = $this->db->query("select * from contact where id=$id")->row();
  $sendData['data'] = $data;
  $viewcontent = $this->load->view('emailers/enquiry', $sendData, true);
  $this->email_model->emailer($viewcontent,'New Enquiry - Mukesh Jewellers',"makedigitaldesigners@gmail.com","");
  $obj->value = true;
  $obj->message = "Thank you for getting in touch! We will get back to you shortly.";
  return $obj ;
}else{
  $obj->value = false;
  $obj->message ="Something went wrong, please try again later." ;
  return $obj ;
} 
}else{
      $obj->value = false;
      $obj->field = "email";
      $obj->message ="Please enter valid Email Address." ;
      return $obj ;
    }
  }
  else{
    $obj->value = false;
    $obj->message ="All fields are mandatory." ;
    return $obj ;
  }
}


public function submitPersonalDetails($id,$fname,$lname,$phone,$email,$billing_address,$billing_country,$billing_city,$billing_state,$billing_pincode,$shipping_address,$shipping_country,$shipping_city,$shipping_state,$shipping_pincode){
$data=array("firstname" => $fname,"lastname" => $lname,"phone" => $phone,"email" => $email,"billing_address" => $billing_address,"billing_country" => $billing_country,"billing_city" => $billing_city,"billing_state" => $billing_state,"billing_pincode" => $billing_pincode,"shipping_address" => $shipping_address,"shipping_country" => $shipping_country,"shipping_city" => $shipping_city,"shipping_state" => $shipping_state,"shipping_pincode" => $shipping_pincode);
$this->db->where( "id", $id );
$query=$this->db->update( "user", $data );
$obj = new stdClass();
if($query){
  $obj->value = true;
  $obj->message = "record updated";
  return $obj ;
}else{
  $obj->value = false;
  $obj->message ="Something went wrong, please try again later." ;
  return $obj ;
} 
}


public function savePd($id,$name,$email,$phone,$gender){
  $data=array("name" => $name,"email" => $email,"phone" => $phone,"gender" => $gender);
  $this->db->where( "id", $id );
  $query=$this->db->update( "user", $data );
  $obj = new stdClass();
  if($query){
    $obj->value = true;
    $obj->message = "record updated";
    return $obj ;
  }else{
    $obj->value = false;
    $obj->message ="Something went wrong, please try again later." ;
    return $obj ;
  } 
}

public function updateBilling($id,$billingaddress,$billingpincode,$billingcity,$billingstate){
  $data=array("billingaddress" => $billingaddress,"billingcountry" => $billingcountry,"billingcity" => $billingcity,"billingstate" => $billingstate,"billingpincode" => $billingpincode);
  $this->db->where( "id", $id );
  $query=$this->db->update( "user", $data );
  $obj = new stdClass();
  if($query){
    $obj->value = true;
    $obj->message = "record updated";
    return $obj ;
  }else{
    $obj->value = false;
    $obj->message ="Something went wrong, please try again later." ;
    return $obj ;
  } 
}

public function updateShipping($id,$shippingaddress,$shippingpincode,$shippingcity,$shippingstate){
  $data=array("shippingaddress" => $shippingaddress,"shippingcountry" => $shippingcountry,"shippingcity" => $shippingcity,"shippingstate" => $shippingstate,"shippingpincode" => $shippingpincode);
  $this->db->where( "id", $id );
  $query=$this->db->update( "user", $data );
  $obj = new stdClass();
  if($query){
    $obj->value = true;
    $obj->message = "record updated";
    return $obj ;
  }else{
    $obj->value = false;
    $obj->message ="Something went wrong, please try again later." ;
    return $obj ;
  } 
}

public function changePassword($oldpass, $newpass){
  $id=$this->session->userData->data['id'];
  if($this->session->userData->data['accesslevel']==1){
    $oldpass = $this->db->query("select * from user where password='$oldpass'")->row();
  }else{
    $oldpass = $this->db->query("select * from user where password='$oldpass' and id=$id")->row();
  }
$obj = new stdClass();
if($oldpass){
 $query = $this->db->query("update user set password='$newpass' where id=$id");
if($query){
  $obj->value = true;
  $obj->message ="Password changed successfully!" ;
  return $obj ;
}else{
  $obj->value = false;
  $obj->message ="Something went wrong, please try again later." ;
  return $obj ;
}
}else{
  $obj->value = false;
  $obj->message ="Incorrect old password" ;
  return $obj ;
}
}

public function getUserDetails($id){
  $query = $this->db->query("select * from user where id=$id")->row();
  if($query){
    $obj->value = true;
    $obj->data =$query ;
    return $obj ;
  }else{
    $obj->value = false;
    $obj->message ="Something went wrong, please try again later." ;
    return $obj ;
  }
}


public function getUserDetailsById($id){
  $query = $this->db->query("SELECT * FROM user WHERE id=$id")->row();
  $idproof = $this->db->query("SELECT * FROM `idproof` WHERE cust_id=$id")->result_array();
  $contacts = $this->db->query("SELECT * FROM `contacts` WHERE cust_id=$id")->result_array();
  if($query){
    $obj->value = true;
    $obj->details =$query ;
    $obj->idproof =$idproof ;
    $obj->contacts =$contacts ;
    return $obj ;
  }else{
    $obj->value = false;
    $obj->message ="User not found." ;
    return $obj ;
  }
}


public function getIdProofDetails($id){
  $query = $this->db->query("SELECT * FROM `idproof` WHERE cust_id=$id")->result_array();
  if($query){
    $obj->value = true;
    $obj->data =$query ;
    return $obj ;
  }else{
    $obj->value = false;
    $obj->data = [];
    $obj->message ="Data not found" ;
    return $obj ;
  }
}

}
?>
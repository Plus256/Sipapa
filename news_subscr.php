<?php
require_once("cnf.php");

if(isset($_GET['news_subscr'])){
	newsSubscr();
}

function newsSubscr(){
	if(!empty($_POST['email'])){
		$mail_check=spamCheck($_POST['email']);
		if($mail_check==false){
			echo "Make sure the Address is Valid.";
		}
		else{
		    $email=cleanInput($_POST['email']);
		    $q=mysqli_query($con, "select email from news_l where email='$email'");
		    if(mysqli_num_rows($q)>0){
		    	echo "0";
		    }
		    else{
		    	$q=mysqli_query($con, "insert into news_l (email) values ('$email')");
			    if($q){
			    	echo "1";
			    }
		    }
		}
	}
	else{
		echo "2";
	}
}

function spamCheck($field){
	//sanitize email
	$field=filter_var($field, FILTER_SANITIZE_EMAIL);
	//validate email
	if(filter_var($field, FILTER_VALIDATE_EMAIL)){
		return true;
	}
	else{
		return false;
	}
}

function cleanInput($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = strip_tags($data, "<br>");
	return $data;
}
?>
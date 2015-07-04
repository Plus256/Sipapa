<?php
$shule_title=mysql_real_escape_string($_POST['shule_title']);
$shule_cover=$_FILES['shule_cover']['name'];
$shule_cat=mysql_real_escape_string($_POST['shule_cat']);
$shule_ctype=mysql_real_escape_string($_POST['shule_ctype']);
$shule_status=mysql_real_escape_string($_POST['shule_status']);
$shule_body=mysql_real_escape_string($_POST['shule_body']);
$upload=move_uploaded_file($_FILES['shule_cover']['tmp_name'], "./img/".$_FILES['shule_cover']['name']);
if($upload){
	$q=mysqli_query($con, "insert into pic (src) values ('$shule_cover')");
	if($q){
		mysqli_query($con, "select last_insert_id() into @shule_cover");
		$q=mysqli_query($con, "update shule set title='$shule_title', 
		cover=@shule_cover, body='$shule_body',
		status=$shule_status, category=$shule_cat,
		ctype=$shule_ctype where id=$token");
		if($q){
			header('Location:'.$_SERVER['PHP_SELF'].'?option=Shules');
		}
		else{echo mysql_error();}
	}
}
else{
	$q=mysqli_query($con, "update shule set title='$shule_title', body='$shule_body',
	status=$shule_status, category=$shule_cat,
	ctype=$shule_ctype where id=$token");
	if($q){
		header('Location:'.$_SERVER['PHP_SELF'].'?option=Shules');
	}
	else{echo mysql_error();}
}
?>
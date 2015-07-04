<?php
$uname=mysqli_real_escape_string($_POST['uname']);
$pwd=mysqli_real_escape_string($_POST['pwd']);
$hash=hash('sha256', $pwd);
$q=mysqli_query($con, "select * from user where uname='$uname'");
if(mysqli_num_rows($q)<1){
	$err=1;
	header('Location: '.$_SERVER['PHP_SELF'].'?err='.$err.'');
}
else{
	$q=mysqli_query($con, "select * from user where hash='$hash' and uname='$uname'");
	if(mysqli_num_rows($q)>0){
		$r=mysqli_fetch_assoc($q);
		$_SESSION['adm_logged']=$r['id'];
		header('Location: '.$_SERVER['PHP_SELF'].'');
	}
	else{
		$err=2;
		header('Location: '.$_SERVER['PHP_SELF'].'?err='.$err.'');
	}
}
?>
<?php
ob_start();
session_start();
$power="Plus256 Network";
$short_name="Spapa";
$tagline="Entertainment";
$logo="gra/logo.png";
$menu_icon="gra/menu_icon.png";
$cover="img/cover.jpg";
require_once("db.php");
//Dynamically Setting Facebook Open Graph Properties
if(isset($_GET['id'])){
	$shule_id=$_GET['id'];
	$q=mysqli_query($con, "select *, s.id as sid from shule as s join pic as p join user as u on s.author=u.id and s.cover=p.id where s.id=$shule_id");
	$r=mysqli_fetch_assoc($q);
	$og_title=$r['title']; $og_cover="http://www.minzani.com/img/".$r['src']; $og_descr=strip_tags($r['body']);
}
else{
	$og_title="Minzani";
	$og_descr=$tagline;
	$og_cover="http://www.minzani.com/gra/logo.png";
}
?>

<?php
require_once("cnf.php");
if(isset($_GET['fetch_shule'])){
	$data=array();
	$q=mysql_query("select *, s.id as sid, u.fname, u.lname from shule as s join pic as p join user as u on s.author=u.id and s.cover=p.id where s.status=1 order by s.id desc limit 1,6");
	$qt=mysql_query("select id from shule");
	$tot_r=mysql_num_rows($qt);
	while($r=mysql_fetch_assoc($q)){
		$id=$r['sid']; $title=$r['title']; $cover=$r['src']; $intro=$r['body']; $published=$r['created']; $author=$r['fname']." ".$r['lname']; $category=$r['category'];
		$published=elapsedTime($published);
		$intro=trunc($intro,25, $id);
		switch($category){
			case 1: $category="Policy"; break;
			case 2: $category="Tech"; break;
			case 3: $category="Lifestyle"; break;
			case 4: $category="Business"; break;
			case 5: $category="Entertainment"; break;
		}
		$rec=array("id"=>$id, "title"=>$title, "cover"=>$cover, "intro"=>$intro, "published"=>$published, "author"=>$author, "category"=>$category, "tot_r"=>$tot_r);
		array_push($data, $rec);
	}
	echo json_encode($data);
}

if(isset($_GET['top_shule'])){
	$data=array();
	$q=mysql_query("select *, s.id as sid, u.fname, u.lname from shule as s join pic as p join user as u on s.author=u.id and s.cover=p.id where s.status=1 order by s.id desc limit 1");
	while($r=mysql_fetch_assoc($q)){
		$id=$r['sid']; $title=$r['title']; $cover=$r['src']; $intro=$r['body']; $published=$r['created']; $author=$r['fname']." ".$r['lname']; $category=$r['category'];
		$published=elapsedTime($published);
		$intro=trunc($intro,25, $id);
		switch($category){
			case 1: $category="Policy"; break;
			case 2: $category="Tech"; break;
			case 3: $category="Lifestyle"; break;
			case 4: $category="Business"; break;
			case 5: $category="Entertainment"; break;
		}
		$rec=array("id"=>$id, "title"=>$title, "cover"=>$cover, "intro"=>$intro, "published"=>$published, "author"=>$author, "category"=>$category);
		array_push($data, $rec);
	}
	echo json_encode($data);
}

if(isset($_GET['shule_cat'])){
	$shule_cat=$_GET['cat_id'];
	switch($shule_cat){
		case "Policy": $shule_cat=1; break;
		case "Tech": $shule_cat=2; break;
		case "Lifestyle": $shule_cat=3; break;
		case "Business": $shule_cat=4; break;
		case "Entertainment": $shule_cat=5; break;
	}
	$data=array();
	$q=mysql_query("select *, s.id as sid, u.fname, u.lname from shule as s join pic as p join user as u on s.author=u.id and s.cover=p.id where s.category=$shule_cat and s.status=1 order by s.id desc limit 6");
	while($r=mysql_fetch_assoc($q)){
		$id=$r['sid']; $title=$r['title']; $cover=$r['src']; $intro=$r['body']; $published=$r['created']; $author=$r['fname']." ".$r['lname']; $category=$r['category'];
		$published=elapsedTime($published);
		$intro=trunc($intro,25, $id);
		switch($category){
			case 1: $category="Policy"; break;
			case 2: $category="Tech"; break;
			case 3: $category="Lifestyle"; break;
			case 4: $category="Business"; break;
			case 5: $category="Entertainment"; break;
		}
		$rec=array("id"=>$id, "title"=>$title, "cover"=>$cover, "intro"=>$intro, "published"=>$published, "author"=>$author, "category"=>$category);
		array_push($data, $rec);
	}
	echo json_encode($data);
}

if(isset($_GET['more_shule'])){
	$shule_id=$_GET['shule_id'];
	$q_v=mysql_query("update shule set views=views+1 where id=$shule_id");
	$q=mysql_query("select *, s.id, u.fname, u.lname as sid from shule as s join pic as p join user as u on s.author=u.id and s.cover=p.id where s.id=$shule_id");
	$r=mysql_fetch_assoc($q);
	$id=$r['sid']; $title=$r['title']; $cover=$r['src']; $intro=$r['body']; $published=$r['created']; $author=$r['fname']." ".$r['lname']; $category=$r['category']; $views=$r['views'];
	$published=elapsedTime($published);
	switch($category){
		case 1: $category="Policy"; break;
		case 2: $category="Tech"; break;
		case 3: $category="Lifestyle"; break;
		case 4: $category="Business"; break;
		case 5: $category="Entertainment"; break;
	}
	$data=array("id"=>$id, "title"=>$title, "cover"=>$cover, "intro"=>$intro, "published"=>$published, "author"=>$author, "category"=>$category, "views"=>$views);
	echo json_encode($data);
}

if(isset($_GET['fill_right'])){
	$shule_id=$_GET['shule_id'];
	$data=array();
	$q=mysql_query("select *, s.id as sid, u.fname, u.lname from shule as s join pic as p join user as u on s.author=u.id and s.cover=p.id where s.id!=$shule_id and s.status=1 order by s.id desc limit 6");
	while($r=mysql_fetch_assoc($q)){
		$id=$r['sid']; $title=$r['title']; $cover=$r['src']; $intro=$r['body']; $published=$r['created']; $author=$r['fname']." ".$r['lname']; $category=$r['category'];
		$published=elapsedTime($published);
		$intro=trunc($intro,25, $id);
		switch($category){
			case 1: $category="Policy"; break;
			case 2: $category="Tech"; break;
			case 3: $category="Lifestyle"; break;
			case 4: $category="Business"; break;
			case 5: $category="Entertainment"; break;
		}
		$rec=array("id"=>$id, "title"=>$title, "cover"=>$cover, "intro"=>$intro, "published"=>$published, "author"=>$author, "category"=>$category);
		array_push($data, $rec);
	}
	echo json_encode($data);
}

function trunc($phrase, $max_words, $this_shule){
	$phrase_array=explode(" ", $phrase);
	if(count($phrase_array)>$max_words && $max_words>0){
		$phrase=implode(" ", array_slice($phrase_array, 0, $max_words))."... "."<a class='read_more' href='shule.php?id=".$this_shule."'>More</a>";
	}
	return $phrase;
}

if(isset($_GET['load_more'])){
    $l_id=$_GET['l_id'];
	$data=array();
	$q=mysql_query("select *, s.id as sid, u.fname, u.lname from shule as s join pic as p join user as u on s.author=u.id and s.cover=p.id where s.id<$l_id and s.status=1 order by s.id desc limit 6");
	$qt=mysql_query("select id from shule");
	$tot_r=mysql_num_rows($qt);
	while($r=mysql_fetch_assoc($q)){
		$id=$r['sid']; $title=$r['title']; $cover=$r['src']; $intro=$r['body']; $published=$r['created']; $author=$r['fname']." ".$r['lname']; $category=$r['category'];
		$published=elapsedTime($published);
		$intro=trunc($intro,25, $id);
		switch($category){
			case 1: $category="Policy"; break;
			case 2: $category="Tech"; break;
			case 3: $category="Lifestyle"; break;
			case 4: $category="Business"; break;
			case 5: $category="Entertainment"; break;
		}
		$rec=array("id"=>$id, "title"=>$title, "cover"=>$cover, "intro"=>$intro, "published"=>$published, "author"=>$author, "category"=>$category, "tot_r"=>$tot_r);
		array_push($data, $rec);
	}
	echo json_encode($data);
}

if(isset($_GET['fetch_ad'])){
	$data=array();
	$q=mysql_query("select *, a.id as aid from ad as a join pic as p on a.pic=p.id where a.status=1 order by a.id desc limit 5");
	while($r=mysql_fetch_assoc($q)){
		$id=$r['aid']; $title=$r['title']; $pic=$r['src']; $descr=$r['descr']; $exl=$r['exl']; $type=$r['type'];
		$rec=array("id"=>$id, "title"=>$title, "pic"=>$pic, "descr"=>$descr, "exl"=>$exl, "type"=>$type);
		array_push($data, $rec);
	}
	echo json_encode($data);
}

if(isset($_GET['fetch_poll'])){
	$data=array();
	$q=mysql_query("select *, c.id as cid from p_cand as c join poll as pp join pic as p on c.poll=pp.id and c.cover=p.id where pp.status=1 order by c.id asc");
	while($r=mysql_fetch_assoc($q)){
		$id=$r['cid']; $poll=$r['poll']; $topic=$r['topic']; $pic=$r['src']; $descr=$r['descr']; $votes=$r['votes']; $cat=$r['category']; $start=$r['created'];
		$votes=voteShare($votes, $poll)."%";
		$total="Total Votes: ".totalVotes($poll);
		$start=elapsedTime($start);
		switch($cat){
			case 1: $cat="Policy"; break;
			case 2: $cat="Tech"; break;
			case 3: $cat="Lifestyle"; break;
			case 4: $cat="Business"; break;
			case 5: $cat="Entertainment"; break;
		}
		$rec=array("id"=>$id, "topic"=>$topic, "pic"=>$pic, "descr"=>$descr, "votes"=>$votes, "total"=>$total, "cat"=>$cat, "start"=>$start);
		array_push($data, $rec);
	}
	echo json_encode($data);
}

if(isset($_GET['vote'])){
	$data=array();
	$p_cand=$_GET['vote'];
	$q=mysql_query("select votes from p_cand where id=$p_cand");
	if($q){
		$r=mysql_fetch_assoc($q);
		$votes=$r['votes']; $votes++;
		$q=mysql_query("update p_cand set votes=$votes where id=$p_cand");
		if($q){
			echo '{"ret":"1"}';
		}
	}
}

if(isset($_GET['poll_result'])){
	$data=array();
	$q=mysql_query("select *, c.id as cid from p_cand as c join poll as pp join pic as p on c.poll=pp.id and c.cover=p.id where pp.status=1 order by c.id asc");
	while($r=mysql_fetch_assoc($q)){
		$id=$r['cid']; $poll=$r['poll']; $topic=$r['topic']; $pic=$r['src']; $descr=$r['descr']; $votes=$r['votes']; $cat=$r['category']; $start=$r['created'];
		$votes=voteShare($votes, $poll)."%";
		$total="Total Votes: ".totalVotes($poll);
		$start=elapsedTime($start);
		switch($cat){
			case 1: $cat="Policy"; break;
			case 2: $cat="Tech"; break;
			case 3: $cat="Lifestyle"; break;
			case 4: $cat="Business"; break;
			case 5: $cat="Entertainment"; break;
		}
		$rec=array("id"=>$id, "topic"=>$topic, "pic"=>$pic, "descr"=>$descr, "votes"=>$votes, "total"=>$total, "cat"=>$cat, "start"=>$start);
		array_push($data, $rec);
	}
	echo json_encode($data);
}

function voteShare($p_cand_share, $poll){
	$percent;
	$total=0;
	$q=mysql_query("select votes from p_cand where poll=$poll");
	while($r=mysql_fetch_assoc($q)){
		$total+=$r['votes'];
	}
	$percent=floor(($p_cand_share/$total)*100);
	return $percent;
}

function totalVotes($poll){
	$total=0;
	$q=mysql_query("select votes from p_cand where poll=$poll");
	while($r=mysql_fetch_assoc($q)){
		$total+=$r['votes'];
	}
	return $total;
}

if(isset($_GET['send_msg'])){
    if(!empty($_POST['frm'])){
		$mail_check=spamCheck($_POST['frm']);
		if($mail_check==false){
			echo '{"ret":"0"}';
		}
		else{
			if(!empty($_POST['msg']) && $_POST['msg']!="Write Message Here..." && preg_match("/^[0-9a-zA-Z]+/", $_POST['msg'])){
				$frm=cleanInput($_POST['frm']);
				$sbj=cleanInput($_POST['sbj']);
				$msg=cleanInput($_POST['msg']);
				
				$q=mysql_query("select id, email from news_l where email='$frm'");
			    if(mysql_num_rows($q)>0){
			    	//email exists in our news_l subscriptions
			    	$r=mysql_fetch_assoc($q);
			    	$frm_id=$r['id'];
			    	$q=mysql_query("insert into feed_b (sbj, msg, frm) values ('$sbj', '$msg', $frm_id)");
			    	if($q){
						echo '{"ret":"2"}';
					}
					else{
						echo '{"ret":"3"}';
					}
			    }
			    else{//new email
			    	$q=mysql_query("insert into news_l (email) values ('$frm')");
			    	mysql_query("select last_insert_id() into @frm_id");
				    $q=mysql_query("insert into feed_b (sbj, msg, frm) values ('$sbj', '$msg', @frm_id)");
			    	if($q){
						echo '{"ret":"2"}';
					}
					else{
						echo '{"ret":"3"}';
					}
			    }
			}
			else{
				echo '{"ret":"1"}';
			}
		}
	}
	else{
		echo '{"ret":"0"}';
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

function elapsedTime($t_stamp){
	$occurred=strtotime($t_stamp);
	$diff=time()-$occurred;
	if($diff<60){
		$elapsed=$diff;
		if($elapsed==1){
			$elapsed=$elapsed." Second";
		}
		else{
			$elapsed=$elapsed." Seconds";
		}
	}
	elseif($diff>=60 && $diff<(60*60)){
		$elapsed=floor($diff/(60));
		if($elapsed==1){
			$elapsed=$elapsed." Minute";
		}
		else{
			$elapsed=$elapsed." Minutes";
		}
	}
	elseif($diff>=(60*60) && $diff<(60*60*24)){
		$elapsed=floor($diff/(60*60));
		if($elapsed==1){
			$elapsed=$elapsed." Hour";
		}
		else{
			$elapsed=$elapsed." Hours";
		}
	}
	elseif($diff>=(60*60*24) && $diff<(60*60*24*7)){
		$elapsed=floor($diff/(60*60*24));
		if($elapsed==1){
			$elapsed=$elapsed." Day";
		}
		else{
			$elapsed=$elapsed." Days";
		}
	}
	elseif($diff>=(60*60*24*7) && $diff<(60*60*24*7*4)){
		$elapsed=floor($diff/(60*60*24*7));
		if($elapsed==1){
			$elapsed=$elapsed." Week";
		}
		else{
			$elapsed=$elapsed." Weeks";
		}
	}
	elseif($diff>=(60*60*24*7*4) && $diff<(60*60*24*7*4*12)){
		$elapsed=floor($diff/(60*60*24*7*4));
		if($elapsed==1){
			$elapsed=$elapsed." Month";
		}
		else{
			$elapsed=$elapsed." Months";
		}
	}
	elseif($diff>=(60*60*24*7*4*12)){
		$elapsed=floor($diff/(60*60*24*7*4*12));
		if($elapsed==1){
			$elapsed=$elapsed." Year";
		}
		else{
			$elapsed=$elapsed." Years";
		}
	}
	return $elapsed;
}
?>
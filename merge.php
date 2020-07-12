<?php
//Ponzi Script
//BY FLASHWEBTECH INC
//ADESANOYE ADELEYE BENJAMIN 
//BennySWAG DACYBERPOWER
//09022165970 or 08110446469
// flashwebtech@gmail.com
//Dacyberpower Ltd
include('../inc/header.php');
FlashTitle('Merge User |' .$set['title']);
echo '<!-- Custom stylesheet - for your changes -->
    <link href="'.$set['url'].'/assets/style.css" rel="stylesheet">';
defined('ADESFLASH') or exit('404 Access Blocked!');
if(FLASHWEBTECHINC !== 1) {
	echo 'No Direct Script Access!';
	exit('Access Forbiden!');
}
if(!$Function->isLogin()){
	include '../member/login2.php';
}
else {
	if($prof['right'] > 0){
		if(isset($_GET['plan'])){
			if($_GET['plan'] == 1){
		$planxm = $mcplan1;
		$emoney = $mcprice1;
	}
	elseif($_GET['plan'] == 2){
		$planxm = $mcplan2;
		$emoney = $mcprice2;
	}
	elseif($_GET['plan'] == 3){
		$planxm = $mcplan3;
		$emoney = $mcprice3;
	}
	elseif($_GET['plan'] == 4){
		$planxm = $mcplan4;
		$emoney = $mcprice4;
	}
	elseif($_GET['plan'] == 5){
		$planxm = $mcplan5;
		$emoney = $mcprice5;
	}
	else{
		$planxm = 'NO PLAN';
		$emoney = '00';
	}
	echo '<p><div class="info">&bull; Choose To Merge User with Thesame Plan
	Together Else Error will occur! Except if He/She is Admin<br/>
	&bull; Only choose User With <font color="green"><b>'.$planxm.'</b></font> For '.$_GET['user'].'</div></p>';
		}
  if(isset($_GET['user'])){
	  $ceebv = $flash->query("SELECT * FROM `user` WHERE `username`='{$_GET['user']}'");
	  $vbn = $ceebv->fetch();
	  if($vbn['right'] > 0){
		  $muser = $flash->query("SELECT * FROM `user` WHERE id>0 AND `tomerge`<'1' AND `plan`>'0' AND `switched`<'1'
			AND `username`!='{$_GET['user']}'
			AND `username` NOT IN
			(
			SELECT `sender` FROM `merge` WHERE `id`>0
			)
			AND `username` NOT IN
			(
			SELECT `reciever` FROM `merge` WHERE `id`>0
			)
			LIMIT {$startpoint} , {$limit}");
			echo '<p><div class="main"><div class="main title">Users Available</div> ';
			if($muser->rowcount() < 1){
				echo '<p><div class="info">No User Available For Marging!</div></p>';
			}
	  }
	  else {
			$muser = $flash->query("SELECT * FROM `user` WHERE id>0 AND `tomerge`<'1' AND `switched`<'1' AND
			`plan`='{$_GET['plan']}'
			AND `username`!='{$_GET['user']}'
			AND `username` NOT IN
			(
			SELECT `sender` FROM `merge` WHERE `id`>0
			)
			AND `username` NOT IN
			(
			SELECT `reciever` FROM `merge` WHERE `id`>0
			)
			LIMIT {$startpoint} , {$limit}");
			echo '<p><div class="main"><div class="main title">Users Available</div> ';
			if($muser->rowcount() < 1){
				echo '<p><div class="info">No User Available For Marging!</div></p>';
			}
	  }
			while($mresult = $muser->fetch()){
	if($mresult['plan'] == 1){
		$planx = $mcplan1;
		$emoney = $mcprice1;
	}
	elseif($mresult['plan'] == 2){
		$planx = $mcplan2;
		$emoney = $mcprice2;
	}
	elseif($mresult['plan'] == 3){
		$planx = $mcplan3;
		$emoney = $mcprice3;
	}
	elseif($mresult['plan'] == 4){
		$planx = $mcplan4;
		$emoney = $mcprice4;
	}
	elseif($mresult['plan'] == 5){
		$planx = $mcplan5;
		$emoney = $mcprice5;
	}
	else{
		$planx = 'NO PLAN';
		$emoney = '00';
	}
			echo '<div class="left"><b>
			First Name: '.$mresult['firstname'].' <br/>
			Last Name: '.$mresult['lastname'].' <br/>
			Username: '.$mresult['username'].'<br/>
            Email: '.$mresult['email'].'<br/>
            Phone: '.$mresult['phone'].'<br/>
            Location: '.$mresult['location'].'<br/>
			Plan: '.$planx.'</b></div>
			<form method="POST">
			<input type="hidden" name="senda" value="'.$mresult['username'].'"/>
			<table><tr><td align="left"><small>Replace old Marge With This, Merge is only replace by one(1)<br/>
			<button style="float:left;" name="repm">Replace Marge</button>
			</td>
			<td align="right"><small>Save as new merge so as to increase merge.</small><br/>
			<button style="float:center;" name="newm">New Marge</button>
			</td></tr></table></form>
			<br/>
			<hr/>';	
			}
		
			echo '</div></p>';
			if($vbn['right'] > 0){
			$statement = "`user` WHERE id>0 AND `tomerge`<'1' AND `plan`>'0' AND `switched`<'1'
			AND `username`!='{$_GET['user']}'
			AND `username` NOT IN
			(
			SELECT `sender` FROM `merge` WHERE `id`>0
			)";
			}
			else {
				$statement = "`user` WHERE id>0 AND `tomerge`<'1' AND `switched`<'1' AND
			`plan`='{$_GET['plan']}'
			AND `username`!='{$_GET['user']}'
			AND `username` NOT IN
			(
			SELECT `sender` FROM `merge` WHERE `id`>0
			)";
			}
            $query = $flash->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
            echo Ben::page($statement,$limit,$page,'?user='.$_GET['user'].'&plan='.$_GET['plan'].'&');
				//Manage Merging
		if(isset($_POST['repm'])){
		$mergnn  = date('Y-m-d');
		$meTimex  = (time() + (60 * 60 * 6));
		$meTimxxc = (date('H') + 6).':'.date('i:s');
		if($flash->query("DELETE FROM `merge` WHERE `reciever`='{$_GET['user']}' LIMIT 1")){
		if($flash->query("INSERT INTO `merge`(sender,reciever,mergeon,xtime,ntime)
		VALUES('{$_POST['senda']}','{$_GET['user']}','{$mergnn}','{$meTimex}','{$meTimxxc}')")){
		echo '<p><div class="success">Successfully Merge Deleted AND Replaced! </div></p>';
				}
				else{
						echo '<div class="info">Not Completed Try Later!</div>';
					}
			}
		}
		if(isset($_POST['newm'])){
		$mergnn  = date('Y-m-d');
		$meTimex  = (time() + (60 * 60 * 6));
		$meTimxxc = (date('H') + 6).':'.date('i:s');
		if($flash->query("INSERT INTO `merge`(sender,reciever,mergeon,xtime,ntime)
		VALUES('{$_POST['senda']}','{$_GET['user']}','{$mergnn}','{$meTimex}','{$meTimxxc}')")){
			$uVb = $flash->query("SELECT * FROM `user` WHERE `username`='{$_GET['user']}'");
			$Veb = $uVb->fetch();
			$absttc = abs(($Veb['totaltomerge'] - 1));
	 $updmt = $flash->query("UPDATE `user` SET `totaltomerge`='{$absttc}' WHERE `username`='{$Veb['username']}'");

		echo '<p><div class="success">Successfully Merged! </div></p>';
					}
					else{
						echo '<div class="info">Not Completed Try Later!</div>';
					}
		}
		}
		else{
		echo '<br/><h3 class="title">Merge User<h3>';
		echo '<div class="menu2"><div class="main"><form method="GET">
		<label style="color:green;">Search User By Username:</label>
		<br/><input type="text" style="width:50%;" name="q" value="'.$_GET['q'].'"/>
		<button name="sch" value="flash">Search</button></form><br/>';
		if(isset($_GET['q'])){
			$searchr = $_GET['q'];
			$suser = $flash->prepare("SELECT * FROM `user` WHERE MATCH(username) AGAINST(:sch)
			AND `tomerge`>'0' AND `tomerge`<'10'
			LIMIT {$startpoint} , {$limit}");
			$suser->bindParam(':sch',$searchr);
			$suser->execute();
			echo '<p><div class="main"><div class="main title">Search Result For
			" <font color="red"> '.$_GET['q'].'</font> "</div> ';
			if($suser->rowCount() < 1){
				echo '<div class="info">User Not Found Or Not Available For Merging!</div>';
			}
			while($sresult = $suser->fetch()){
				if($sresult['plan'] == 1){
		$planxx = $mcplan1;
		$emoney = $mcprice1;
	}
	elseif($sresult['plan'] == 2){
		$planxx = $mcplan2;
		$emoney = $mcprice2;
	}
	elseif($sresult['plan'] == 3){
		$planxx = $mcplan3;
		$emoney = $mcprice3;
	}
	elseif($sresult['plan'] == 4){
		$planxx = $mcplan4;
		$emoney = $mcprice4;
	}
	elseif($sresult['plan'] == 5){
		$planxx = $mcplan5;
		$emoney = $mcprice5;
	}
	else{
		$planxx = 'NO PLAN';
		$emoney = '00';
	}
			echo '<div class="left"><b>First Name: '.$sresult['firstname'].' <br/>
			Last Name: '.$sresult['lastname'].' <br/>
			Username: '.$sresult['username'].'<br/>
            Email: '.$sresult['email'].'<br/>
            Phone: '.$sresult['phone'].'<br/>
            Location: '.$sresult['location'].'<br/>
			Plan: '.$planxx.'</b></div>
			<a class="buttong" style="float:left;" href="'.$set['url'].'/admin/merge.php?user='.$sresult['username'].'&plan='.$sresult['plan'].'">
			Marge User</a>
			<br/><br/>
			<hr/>';		
			}
			echo '</div></p>';
			$statement = "`user` WHERE MATCH(username) AGAINST('{$searchr}') AND `tomerge`>'0' AND `tomerge`<'10'";
            $query = $flash->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
            echo Ben::page($statement,$limit,$page,'?q='.$_GET['q'].'&');
		}
//Rest User
			$ssuser = $flash->query("SELECT * FROM `user` WHERE id>0 AND `tomerge`>'0' AND `tomerge`<'10' ORDER BY `id` ASC
			LIMIT {$startpoint} , {$limit}");
			echo '<p><div class="main"><div class="main title">Users Available</div> ';
			while($ssresult = $ssuser->fetch()){
				if($ssresult['plan'] == 1){
				$planxs = $mcplan1;
		$emoney = $mcprice1;
	}
	elseif($ssresult['plan'] == 2){
		$planxs = $mcplan2;
		$emoney = $mcprice2;
	}
	elseif($ssresult['plan'] == 3){
		$planxs = $mcplan3;
		$emoney = $mcprice3;
	}
	elseif($ssresult['plan'] == 4){
		$planxs = $mcplan4;
		$emoney = $mcprice4;
	}
	elseif($ssresult['plan'] == 5){
		$planxs = $mcplan5;
		$emoney = $mcprice5;
	}
	else{
		$planxs = 'NO PLAN';
		$emoney = '00';
	}
			echo '<div class="left"><b>
			First Name: '.$ssresult['firstname'].' <br/>
			Last Name: '.$ssresult['lastname'].' <br/>
			Username: '.$ssresult['username'].'<br/>
            Email: '.$ssresult['email'].'<br/>
            Phone: '.$ssresult['phone'].'<br/>
            Location: '.$ssresult['location'].'<br/>
			Plan: '.$planxs.'</b></div>
			<a class="buttong" style="float:left;" href="'.$set['url'].'/admin/merge.php?user='.$ssresult['username'].'&plan='.$ssresult['plan'].'">Marge User</a>
			<br/><br/>
			<hr/>';	
			}
			echo '</div></p>';
			$statement = "`user` WHERE id>0 AND `tomerge`>'0' AND `tomerge`<'10'";
            $query = $flash->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
            echo Ben::page($statement,$limit,$page,'?');
		}
		echo '</center><center><br/><p><a class="buttong" href="'.$set['url'].'/member/main">Go Back</a></p>
	<br/></div></div></center>';
	}
	else {
		header('Location: '.$set['url'].'/member/main');
		exit;
	}
}
include('../inc/footer.php');
?>
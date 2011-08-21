
<?php

echo(var_dump($_GET, true));
/*** mysql hostname ***/
$hostname = '127.0.0.1';

/*** mysql username ***/
$username = 'iitk_shahbaz';

/*** mysql password ***/
$password = 'iitk_shahbaz_gameiq';

$con = mysql_connect($hostname, $username, $password);
$db = mysql_select_db("iitk_shahbaz_gameiq");

if (!$db) {
	die("DB selection failed");
}

    /*** echo a message saying we have connected ***/
    echo 'Connected to database </br>';
    
if( isset($_GET['user'])and isset($_GET['com'])and isset($_GET['qid'])and isset($_GET['id']))
{//Inserting a C

	$user = $_GET['user'];
	$com = $_GET['com'];
	$comi =(int) $_GET['id'];
	$qi	=(int)	$_GET['qid'];
	
	if($comi==NULL)
	{
	$sql = "insert into comments (user,data) values ('".$user."','".$com."')";
	}
	else
	{
	$sql = "insert into comments (user,data,next_id) values ('".$user."','".$com."',".$comi.")";
	}
	
	mysql_query($sql);
	$id=mysql_insert_id();
	$sql = "update questions set comment_id=".$id." where id=".$qi;
	$count = mysql_query($sql);
	echo $count;
}	
else if( isset($_GET['user'])and isset($_GET['data'])and isset($_GET['anso']))
{//Inserting a Q

	$user = $_GET['user'];
	$data = $_GET['data'];
	$anso = $_GET['anso'];
	
	$sql = "select user,credit from users where user ='".$user."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	
	
	$pts = (int) $row['credit'];
	$pts = $pts/10 +5;
	
	
	echo $pts;
	
	$sql = "insert into questions(user, ques, ans, points) values ('$user', '$data', '$anso',$pts)";
	
	$count = mysql_query($sql);
	echo $count;
}	
else if (isset($_GET['user'])and isset($_GET['ans'])and isset($_GET['id'])) 
{

	$user = $_GET['user'];
	$data = $_GET['ans'];
	$id =(int) $_GET['id'];;

	$sql = "SELECT ans,points FROM questions WHERE id=$id";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	
	#print $row["ans"] .' - '. $data . '<br />';

	
	#var_dump($row['ans']);
	#var_dump($data);
	if($row["ans"]==$data)
	{
		echo "Inside the loop";
		$query = "UPDATE questions SET status=1,solved_by='" . $user . "',solved_time='" . date('Y-m-d H:i:s') . "'  where id=" . $id;
		$result = mysql_query($query);
		
		$sql = "select user,credit from users where user ='".$user."'";

		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		
		
		$pts = (int) $row['credit'];
		
		$sql = "select points from questions where id =".$id;

		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		
		
		$pts = $pts + (int)$row['points'];
		
		$query = "UPDATE questions SET status=1,solved_by='" . $user . "',solved_time='" . date('Y-m-d H:i:s') . "'  where id=" . $id;
		$result = mysql_query($query);
		
		$query = "UPDATE users SET credit=".$pts."  where user='" .$user."'";
		$result = mysql_query($query);
		
		
		echo $query;
	} 
	
	

}
	var_dump($result);
/*** close the database connection ***/
$dbh = null;
header( 'Location: http://hackyourworld.org/~iitk_shahbaz_gameiq/IQC/home.php' ) ;
?>
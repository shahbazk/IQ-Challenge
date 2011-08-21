<!doctype html>
<html>
<head>
	<title>IQ Challenge </title>

	
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.4.0/build/cssreset/reset.css">
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.4.0/build/cssfonts/fonts.css">
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.4.0/build/cssgrids/grids-min.css">
	<link type="text/css" rel="stylesheet" href="http://yui.yahooapis.com/gallery-2010.05.21-18-16/build/gallery-node-accordion/assets/skins/sam/gallery-node-accordion.css" />
	<style>
		img { width: 100%; height: 80px; }
		.title { font-size: 1.5em; font-weight: bold; color: #38ACEC; margin: 20px 0px; }
		.bd { padding-right: 20px; }
		.yui3-accordion .yui3-accordion-item
			{
				text-align: left;
			}
		.yui3-accordion .yui3-accordion-item .yui3-accordion-item-bd p
			{
				padding: 5px;
			}
	</style>
</head>
<?php

//Relative Date Function

function relative_date($time) {

$today = strtotime(date('M j, Y'));

$reldays = ($time - $today)/86400;

if ($reldays >= 0 && $reldays < 1) {

return 'Today';

} else if ($reldays >= 1 && $reldays < 2) {

return 'Tomorrow';

} else if ($reldays >= -1 && $reldays < 0) {

return 'Yesterday';

}

if (abs($reldays) < 7) {

if ($reldays > 0) {

$reldays = floor($reldays);

return 'In ' . $reldays . ' day' . ($reldays != 1 ? 's' : '');

} else {

$reldays = abs(floor($reldays));

return $reldays . ' day' . ($reldays != 1 ? 's' : '') . ' ago';

}

}

if (abs($reldays) < 182) {

return date('l, j F',$time ? $time : time());

} else {

return date('l, j F, Y',$time ? $time : time());

}

}
//echo(var_dump($_GET, true));
/*** mysql hostname ***/
$hostname = '127.0.0.1';

/*** mysql username ***/
$username = 'iitk_shahbaz';

/*** mysql password ***/
$password = 'iitk_shahbaz_gameiq';

?>
<body class="yui3-skin-sam">
<div id="doc" class='yui3-g'>
<div class='header'><img src='http://hackyourworld.org/~iitk_shahbaz_gameiq/IQC/Top.jpg' alt='IQ Challenge banner'></div>
	<div class='yui3-u-1-3'>

		<h3 class="title" align="center">Leader board</h3>

<?php 
$dbh = new PDO("mysql:host=$hostname;dbname=iitk_shahbaz_gameiq", $username, $password);

$sql = "select * from users order by credit desc";

echo('<ul align="center">');
foreach ($dbh->query($sql) as $row)
        {
		echo('<li><b>'.$row['user'].'</b>   :  '.$row['credit'].'</li>');
		}
	echo('</ul>');


?>
		
	</div>

		<div id="demo" class='yui3-u-2-3'>
			<div class="hd">
				<h3 class="title" align="center" >Questions</h3>
				
			</div>
			<div class="bd">

				<div id="myaccordion" class="yui3-accordion">


							<div class="yui3-module yui3-accordion-item yui3-accordion-item-active first-of-type">
							
									<div class="yui3-hd yui3-accordion-item-hd">
									<form name="input" action='http://hackyourworld.org/~iitk_shahbaz_gameiq/IQC/post.php' method='GET'>
										<a href="#" class="yui3-accordion-item-trigger">Enter a question:</a>
											Name:
											<input type="text" name="user" id="user" value="">
											</br> Question:
											<input type='text' name="data" id="data" value="">
											</br> Answer:
											<input type="text" name="anso" id="anso" value="">
											<input type='submit' value='Submit'>
											
									</form>
											
									</div>
							
									<div class="yui3-bd yui3-accordion-item-bd">
										
									</div>
									
						
							</div>
 

<?php


try {
    $dbh = new PDO("mysql:host=$hostname;dbname=iitk_shahbaz_gameiq", $username, $password);

	$sql = "SELECT * FROM questions where status=0 order by points desc";
				
    foreach ($dbh->query($sql) as $row)
        {
   	
		echo('<div class="yui3-module yui3-accordion-item">
							
									<div class="yui3-hd yui3-accordion-item-hd">
										<a href="#" class="yui3-accordion-item-trigger"><b>Points: '.$row['points'].'</br>'.$row['user'].'</b> : '.$row['ques'].'   <i>(Posted '.relative_date(strtotime($row['data_time'] )).')</i></a>
										');
						if($row['status']==0)
						echo('		<form name="input" action="http://hackyourworld.org/~iitk_shahbaz_gameiq/IQC/post.php" method="GET">
										<a href="#" class="yui3-accordion-item-trigger">Solve</a>
											Name:
											<input type="text" name="user" id="user" value="">
											Answer:
											<input type="text" name="ans" id="ans" value="">
											<input type="hidden" name="id" id="id" value="'.$row['id'].'">
											<input type="submit" value="Submit">
											
									</form>
							');
						else
						echo('
									<p> Solved by <b>'.$row['solved_by'].'</b>.');
						echo('	
									</div>
							<div class="yui3-bd yui3-accordion-item-bd">
								'); 
								

										
											$con = mysql_connect($hostname, $username, $password);
											$db = mysql_select_db("iitk_shahbaz_gameiq");
											
											$com=$row['comment_id'];
											while($com!=NULL)
											{
											//echo("Inside");

											//var_dump($com);
											$sql = "SELECT * FROM comments WHERE comment_id=". $com;
											$result = mysql_query($sql);
											//var_dump($result);
											$sow = mysql_fetch_assoc($result);	
											
											echo('<p><b>'.$sow['user'].'</b> : '.$sow['data'].'</p>');
											$com=$sow['next_id'];
											}
										
										
										//echo('<p>'.$row['comment_id'].'</p>');
										
								echo('
										<p>Add a comment:</p>
										 <form name="input" action="http://hackyourworld.org/~iitk_shahbaz_gameiq/IQC/post.php" method="GET">
										<a href="#" class="yui3-accordion-item-trigger"></a>
											Name:
											<input type="text" name="user" id="user" value="">
											Comment:
											<input type="text" name="com" id="com" value="">
											<input type="hidden" name="id" id="id" value='.$row['comment_id'].'>
											<input type="hidden" name="qid" id="qid" value='.$row['id'].'>
											
											<input type="submit" value="Submit">
										</form> 
										
										
									</div>
								</div>'
							);
		}


	$sql = "SELECT * FROM questions where status = 1 order by points desc";
	
	
	
				
    foreach ($dbh->query($sql) as $row)
        {
   	
		echo('<div class="yui3-module yui3-accordion-item">
							
									<div class="yui3-hd yui3-accordion-item-hd">
										<a href="#" class="yui3-accordion-item-trigger"><b>Points: '.$row['points'].'</br>'.$row['user'].'</b> : '.$row['ques'].'     <i>(Posted '.relative_date(strtotime($row['data_time'] )).')</i></br><b>Answer:</b> '.$row['ans'].'</a>
										');
						if($row['status']==0)
						echo('		<form name="input" action="http://hackyourworld.org/~iitk_shahbaz_gameiq/IQC/post.php" method="GET">
										<a href="#" class="yui3-accordion-item-trigger">Enter a question:</a>
											Name:
											<input type="text" name="user" id="user" value="">
											Answer:
											<input type="text" name="ans" id="ans" value="">
											<input type="hidden" name="id" id="id" value="'.$row['id'].'">
											<input type="submit" value="Submit">
											
									</form>
							');
						else
						echo('
									<p> Solved by <b>'.$row['solved_by'].'</b>.');
						echo('	
									</div>
									<div class="yui3-bd yui3-accordion-item-bd">
								'); 
								

										
											$con = mysql_connect($hostname, $username, $password);
											$db = mysql_select_db("iitk_shahbaz_gameiq");
											
											$com=$row['comment_id'];
											while($com!=NULL)
											{
											//echo("Inside");

											//var_dump($com);
											$sql = "SELECT * FROM comments WHERE comment_id=". $com;
											$result = mysql_query($sql);
											//var_dump($result);
											$sow = mysql_fetch_assoc($result);	
											
											echo('<p><b>'.$sow['user'].'</b> : '.$sow['data'].'</p>');
											$com=$sow['next_id'];
											}
										
										
										//echo('<p>'.$row['comment_id'].'</p>');
										
								echo('
										<p>Add a comment:</p>
										 <form name="input" action="http://hackyourworld.org/~iitk_shahbaz_gameiq/IQC/post.php" method="GET">
										<a href="#" class="yui3-accordion-item-trigger"></a>
											Name:
											<input type="text" name="user" id="user" value="">
											Comment:
											<input type="text" name="com" id="com" value="">
											<input type="hidden" name="id" id="id" value='.$row['comment_id'].'>
											<input type="hidden" name="qid" id="qid" value='.$row['id'].'>
											
											<input type="submit" value="Submit">
										</form> 
										
										
									</div>
			
								</div>'	);
		}





    /*** close the database connection ***/
    $dbh = null;
	}
catch(PDOException $e)
    {
    echo $e->getMessage();
    }
	
	

	
	
?>




			
				</div>
					
			</div>
		</div>

	</div>

<!-- YUI 3 Seed //-->
<script type="text/javascript" src="http://yui.yahooapis.com/3.2.0/build/yui/yui-min.js"></script>
<!-- Initialization process //-->
<script type="text/javascript">
	YUI({
			//Last Gallery Build of this module
			gallery: 'gallery-2010.05.21-18-16'
	}).use('anim', 'gallery-node-accordion', function (Y) {
		
			Y.one("#myaccordion").plug(Y.Plugin.NodeAccordion, { 
			anim: Y.Easing.backIn
		});
		
	});
</script>
</body>
</html>

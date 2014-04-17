<?php
require_once("initialise.php");
if(!$session->is_logged_in()){
	redirect_to("index.php");
}
$id=$session->user_id;
$user_name = $session->getUserUname();
$name = $session->getUserName();
?>
<html>
<head>
<title>Home - <?php echo $name;?></title>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style.css">
<link href="bower_components/bootstrap/docs/assets/css/bootstrap.css" rel="stylesheet">
<script src="bower_components/jquery/jquery.js"></script>
<script src="bower_components/underscore/underscore.js"></script>
<script src="http://<?php echo $_SERVER['SERVER_ADDR']=='127.0.0.1'?"localhost:8090":$_SERVER['SERVER_ADDR'].":8090" ;?>/socket.io/socket.io.js"></script>
<script>
      $(document).ready(function()
      {
        var socket = io.connect("http://<?php echo $_SERVER['SERVER_ADDR']=='127.0.0.1'?"localhost":$_SERVER['SERVER_ADDR']?>:8090");
        var template = _.template($('#js-news-template').html());
        socket.on('news', function (news) {
          // alert("Hey ");
          var element = template({news: news});

          $(element).hide().prependTo('#js-news-container').slideDown();
        });
      });
    </script>
    <script type="text/template" id="js-news-template">
      <p class="well"><%- news %></p>
    </script>
</head>
<body>

<div id="container">
		<div id="mastHead">
			<span class="navBar">
			</span>
		</div>
		<div id="carousel">
			<form method="post" action="posts.php">
				<input name="feed" type="text" class="form-control input-lg" placeholder="Shout Here!"/>
				<input name="submit" type="submit" value="Post" class="form-control btn btn-primary"/>
			</form>
		</div>
		<div id="content">
		<?php $session->getMessage();?>
			<?php
				echo "Hello $name @{$user_name} <BR>";
				echo "<a href='logout.php' class='btn btn-primary'>Logout</a>";

				$other_users_query= "SELECT * from users where id NOT IN (".$id.")";
				$usersrows = $db->query($other_users_query);
				echo '<div style="margin:5px;"><div id="js-news-container" style="float:right;">';

				$sql = "SELECT id,username FROM users";
				$id_user_pair=array();
				$rows = $db->query($sql);

				foreach($rows as $row){
				$id_user_pair[$row['id']]=$row['username'];
				}
				$sql = "SELECT * FROM feeds ORDER BY id DESC";
				$rows = $db->query($sql);
				echo "<ul>"; 
				foreach($rows as $row){
					echo "<li class='well'>".$row['feed'].", *".$id_user_pair[$row['user_id']]."</li>";
				}
				echo "</ul></div>";
				echo "<div style='float:left;'>";
				echo "<ul class='lists users'>";
				$following_list=$session->getFollowingList();
				if(!empty($following_list)){
					$following_list=explode(",",$session->getFollowingList());
				}
				else{
					$following_list=array();
				}
				foreach($usersrows as $row){
					
						echo "<li><span class='users'>".$row['username'];
						if(!in_array($row['id'], $following_list)){
							echo " <a href='follow.php?id=".$row['id']."' class='btn btn-primary'>Follow</a>";
						}
						else{
							echo " <span class='btn btn-success'></span>";
						}

						echo "</span></li>";
				}
				echo "</ul></div></div>";
			?> 
			</div>
			
		</div>
	</div>



</body>
</html>
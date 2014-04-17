<?php require_once("initialise.php");
if($session->is_logged_in()){
	redirect_to("home.php");
}	
?>
<html>
<head>
	<title>
		ShoutOutLoud
	</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style.css">
<link href="bower_components/bootstrap/docs/assets/css/bootstrap.css" rel="stylesheet">

</head>
<body>
	<div id="container">
		<div id="mastHead">
			<span class="home_">ShoutOutLoud</span>
			<span class="navBar"><form action="login.php" method="post"> 
				<input name="uname" type="text" class="textBox" placeholder="Username"/>
				<input name="pswd" type="password" class="textBox" placeholder="Password"/> 
				<input name="login" type="submit" value="Login" class="btn btn-primary"/>
			</form>
			</span>
		</div>
		<hr>
		<div id="carousel">
		</div>
		<div id="content">
		<?php $session->getMessage();?>
			<H4> Not a registered user? Register Here </H4>
			<form action="register.php" method="post">
				<input name="name" type="text" class="textBox" placeholder="Your Name"/><br/>
				<input name="uname" type="text" class="textBox" placeholder="Username"/><br/>
				<input name="pswd" type="password" class="textBox" placeholder="Password"/><br/>
				<input name="register" type="submit" value="Register Me" class="btn btn-primary">
			</form>
		</div>
	</div>
</body>
</html>

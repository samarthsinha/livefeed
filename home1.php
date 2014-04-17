<?php
require_once("initialise.php");
if(!$session->is_logged_in()){
  redirect_to("index.php");
}
$id=$session->user_id;
$user_name = $session->getUserUname();
$name = $session->getUserName();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>PHP-Node Demo</title>
    <link href="bower_components/bootstrap/docs/assets/css/bootstrap.css" rel="stylesheet" media="screen">
    <script src="bower_components/jquery/jquery.js"></script>
    <script src="bower_components/underscore/underscore.js"></script>
     <script src="/socket.io/socket.io.js"></script>
    <script>
      $(document).ready(function()
      {
        var socket = io.connect("http://localhost:8090");
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
    <div class="container">
      <h1>Latest News</h1>
      <div id="js-news-container" style="width:500px;"></div>
      <h2>Session</h2>
      <?php var_dump($_SESSION); ?>
    </div>
  </body>
</html>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" href="./base.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>
<img id= "logo" src="./logo.png"/>
  <div class='text'>
  <div class='content'></div>
  <div class='dash'></div>
    <h2><?php echo $header_description; ?></h2>
    <?php
    $recent_users = $data[ 'recent_users' ];
   foreach ($recent_users as $key => $value) {
     echo "<section class=\"recent-user card\">";
   }
    ?>

<script src="./thrill.js"></script>
</body>
</html>

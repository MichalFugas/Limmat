<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    body{
      margin-left: 40%;
    }
    li{
      margin-bottom:10px;
      font-size: 0.5em;
    }
  </style>
  

</head>
<body>
  <div class='list'>
  <ul>
  <?php 
      $myfile = fopen("/home/pi/Limmat/driver_log.txt", "r") or die("Unable to open file!");
      while($line = fgets($myfile)) {
        echo"<li>".$line."</li>";
      }
      fclose($myfile);
    ?>
  <ul>
  </div>
  
  







  <div class="app"></div>

</body>
</html>

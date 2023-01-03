<!DOCTYPE html>
<html>
<head>
    <title>Seite zum quittieren</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/CSS/main.css">
    <link href="https://unpkg.com/ionicons@4.5.0/dist/css/ionicons.min.css" rel="stylesheet">
</head>

<body>





<!--    <a class="close">Close</a>-->

</div>
<script type="text/javascript">
    var c = 0;
    function pop(){
        if (c == 0){
            document.getElementById("box").style.display = "block";
            c = 1;
            setTimeout(function(){
                document.getElementById("box").style.display = "none";
                c = 0;
            }, 3000);
            // return false;
        }else{
            document.getElementById("box").style.display = "none";
            c = 0;
        }
    }
</script>


<img class="imgLimmat" src="Limmat.png">

<form action="" method="post" autocomplete="off">
    <input class="centered width-200px" type="text" name="dienst" id="dienst" maxlength="3" placeholder="Dienst Nr:" autofocus="autofocus">
    <button class="Quittieren width-200px"  type="submit" name="ok">Quittieren</button>
</form>

<button class="centered_myWindow width-200px" onclick="openWin(),setTimeout(closeWin, 5000) ">Unquittierte</button>
<!--  <button onclick="closeWin()">Close "myWindow"</button>-->



<p class="centeredTIME" id="TIME"></p>
<div class="bottom">Autor: Michal Fugas, michal.fugas@hotmail.com</div>

<script>
    var display=setInterval(function(){Time()},0);

    function Time()
    {
        var date=new Date();
        var time=date.toLocaleTimeString();
        document.getElementById("TIME").innerHTML=time;
    }
</script>

<?php

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('/db/Limmat.db');
    }
}
$db = new MyDB();
if(!$db){
    echo $db->lastErrorMsg();
} else {
    echo "Opened database successfully</br>";
}


$q_dienst = $_POST['dienst'];

$sql =<<<EOF
    SELECT * from TT;
EOF;


if($$q_dienst=null){
    ;
}

if($q_dienst !=null && $q_dienst<100){
    //echo "Dienstnummer falsch";
    echo "<SCRIPT>
            alert('Dienstnummer falsch');
          </SCRIPT>";

}
elseif ($q_dienst<=200){

    $sql =<<<EOF
    UPDATE TT SET Checkbox_part_1="1" WHERE Part_1='$q_dienst';
EOF;
    $ret = $db->exec($sql);
    if(!$ret) {
        echo $db->lastErrorMsg();
    } else {
        echo $db->changes(), " Record updated successfully ";
//        $chauffeur = $db->query("SELECT Name FROM TT WHERE Part_1='$q_dienst");
      $chauffeur = $sql =<<<EOF
        SELECT Name FROM TT WHERE Part_1='$q_dienst';
EOF;


        echo "<SCRIPT>alert('$chauffeur'+' oloblol')</SCRIPT>";
    }
}
elseif ($q_dienst<=299) {

    $sql =<<<EOF
    UPDATE TT SET Checkbox_part_2="1" WHERE Part_2='$q_dienst';
EOF;
    $ret = $db->exec($sql);
    if(!$ret) {
        echo $db->lastErrorMsg();
    } else {
        echo $db->changes(), " Record updated successfully ";
    }
}
elseif ($q_dienst<=399) {
    $sql =<<<EOF
    UPDATE TT SET Checkbox_part_3="1" WHERE Part_3='$q_dienst';
EOF;
    $ret = $db->exec($sql);
    if(!$ret) {
        echo $db->lastErrorMsg();
    } else {
        echo $db->changes(), " Record updated successfully ";
    }
}
elseif ($q_dienst==920) {
    $sql =<<<EOF
    UPDATE TT SET Checkbox_part_1="1" WHERE Part_1='$q_dienst';
EOF;
    $ret = $db->exec($sql);
    if(!$ret) {
        echo $db->lastErrorMsg();
    } else {
        echo $db->changes(), " Record updated successfully ";
    }
}

elseif ($q_dienst==921) {
    $sql =<<<EOF
    UPDATE TT SET Checkbox_part_2="1" WHERE Part_1='$q_dienst';
EOF;
    $ret = $db->exec($sql);
    if(!$ret) {
        echo $db->lastErrorMsg();
    } else {
        echo $db->changes(), " Record updated successfully ";
    }
}
elseif ($q_dienst==924) {
    $sql =<<<EOF
    UPDATE TT SET Checkbox_part_1="1" WHERE Part_1='$q_dienst';
EOF;
    $ret = $db->exec($sql);
    if(!$ret) {
        echo $db->lastErrorMsg();
    } else {
        echo $db->changes(), " Record updated successfully ";
    }
}
else {
    echo "Bitte richtige Nummer eingeben";
}

?>


<script>
    var myWindow;

    function openWin() {
        myWindow = window.open("http://192.168.0.39/unquittierte.php");
        // myWindow.document.write("<p>This is 'myWindow'</p>");
    }

    function closeWin() {
        myWindow.close();
    }
    window.onkeypress = function(e) {
        if ((e.which || e.keyCode) == 113) {
            openWin(),setTimeout(closeWin, 5000)
        }
    }
</script>

</body>
</html>

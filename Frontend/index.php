<!DOCTYPE html>
<html>
<head>
  <title>Seite zum quittieren</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="./CSS/main.css">
</head>
<body>
<header>


</header>

<main>

    <div class="main" >
        <div class="center">

            <div class="time">
                <p class="centeredTIME" id="TIME"></p>
            </div>
            <div class="alertPa"><p  id="alertPa"></p></div>
            <div class="form">
                <form action="" method="post" autocomplete="off">
                    <input class="centered width-200px" type="text" name="dienst" id="dienst" maxlength="3" placeholder="Dienst Nr:" autofocus="autofocus">
                    <button class="quittieren"  type="submit" name="ok">Quittieren</button>
                </form>
            </div>
            <div class="button">
                <button class="unquittierte" onclick="openWin(),setTimeout(closeWin, 5000) ">Unquittierte (F2)</button>
            </div>




    </div>
</main>
<script>

    function openBoxx(alert){
        console.log(alert)
        document.getElementById(`alertPa`).innerHTML=alert;
        setTimeout(() => {
            document.getElementById('alertPa').innerHTML='';
        }, 5000);
    }

    var display=setInterval(function(){Time()},0);

    function Time()
    {
      var date=new Date();
      var time=date.toLocaleTimeString();
      document.getElementById("TIME").innerHTML=time;
    }

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


    var myWindow;

    function openWin() {
        myWindow = window.open("/unquittierte.php");
        // myWindow.document.write("<p>This is 'myWindow'</p>");
    }

    function closeWin() {
        myWindow.close();
    }
    window.onkeypress = function(e) {

        if ((e.which || e.keyCode) == 113) {
            openWin(),setTimeout(closeWin, 13000)
        }
    }

</script>
<div class="php"><p ><?php

        class MyDB extends SQLite3
        {
            function __construct()
            {
                $this->open('/home/pi/Limmat/Limmat.db');
            }
        }
        $db = new MyDB();
        if(!$db){
            echo $db->lastErrorMsg();
        } else {
            echo "+</br>";
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
        openBoxx('Dienstnummer falsch');
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
//                    echo $db->changes(), " Record updated successfully ";
                $zapytanie = $db->query("SELECT Name FROM TT WHERE Part_1='$q_dienst'");
                $chauffeur = $zapytanie->fetchArray();
                if($q_dienst !=null){
                    echo "<SCRIPT>
                        var message = '$chauffeur[0], Gute Fahrt';
                        openBoxx(message);
                    </SCRIPT>";
                }
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
//                    echo $db->changes(), " Record updated successfully ";
                $zapytanie = $db->query("SELECT Name FROM TT WHERE Part_2='$q_dienst'");
                $chauffeur = $zapytanie->fetchArray();
                if($q_dienst !=null){
                    echo "<SCRIPT>
                        var message = '$chauffeur[0], Gute Fahrt';
                        openBoxx(message);
                    </SCRIPT>";
                }
            }
        }
        elseif ($q_dienst==300) {

            $sql =<<<EOF
UPDATE TT SET Checkbox_part_1="1" WHERE Part_1='$q_dienst';
EOF;
            $ret = $db->exec($sql);
            if(!$ret) {
                echo $db->lastErrorMsg();
            } else {
//                    echo $db->changes(), " Record updated successfully ";
                $zapytanie = $db->query("SELECT Name FROM TT WHERE Part_1='$q_dienst'");
                $chauffeur = $zapytanie->fetchArray();
                if($q_dienst !=null){
                    echo "<SCRIPT>
                        var message = '$chauffeur[0], Gute Fahrt';
                        openBoxx(message);
                    </SCRIPT>";
                }
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
//                    echo $db->changes(), " Record updated successfully ";
                $zapytanie = $db->query("SELECT Name FROM TT WHERE Part_3='$q_dienst'");
                $chauffeur = $zapytanie->fetchArray();
                if($q_dienst !=null){
                    echo "<SCRIPT>
                        var message = '$chauffeur[0], Gute Fahrt';
                        openBoxx(message);
                    </SCRIPT>";
                }
            }
        }
        elseif ($q_dienst==400) {

          $q = $db->query("SELECT * FROM TT WHERE Part_1='$q_dienst'");
          $q_driver = $q->fetchArray();
          if($q_driver[4] == NULL){
            $sql = $db->query("UPDATE TT SET Checkbox_part_1='1' WHERE Part_1='$q_dienst'");
            echo "<SCRIPT>
                        var message = '$q_driver[17], Gute Fahrt';
                        openBoxx(message);
                    </SCRIPT>";
          }else{
            $sql = $db->query("UPDATE TT SET Checkbox_part_2='1' WHERE Part_1='$q_dienst'");
            echo "<SCRIPT>
                        var message = '$q_driver[17], Gute Fahrt';
                        openBoxx(message);
                    </SCRIPT>";
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
//                    echo $db->changes(), " Record updated successfully ";
                $zapytanie = $db->query("SELECT Name FROM TT WHERE Part_1='$q_dienst'");
                $chauffeur = $zapytanie->fetchArray();
                if($q_dienst !=null){
                    echo "<SCRIPT>
                        var message = '$chauffeur[0], Gute Fahrt';
                        openBoxx(message);
                    </SCRIPT>";
                }
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
//                    echo $db->changes(), " Record updated successfully ";
                $zapytanie = $db->query("SELECT Name FROM TT WHERE Part_1='$q_dienst'");
                $chauffeur = $zapytanie->fetchArray();
                if($q_dienst !=null){
                    echo "<SCRIPT>
                        var message = '$chauffeur[0], Gute Fahrt';
                        openBoxx(message);
                    </SCRIPT>";
                }
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
//                    echo $db->changes(), " Record updated successfully ";
                $zapytanie = $db->query("SELECT Name FROM TT WHERE Part_1='$q_dienst'");
                $chauffeur = $zapytanie->fetchArray();
                if($q_dienst !=null){
                    echo "<SCRIPT>
                        var message = '$chauffeur[0], Gute Fahrt';
                        openBoxx(message);
                    </SCRIPT>";
                }
            }
        }
        else {
            echo "<SCRIPT>
                openBoxx('Bitte richtige Nummer eingeben');
            </SCRIPT>";
        }
        ?></p></div>

<footer>
    <p class="foot">Autor: Michal Fugas, michal.fugas@hotmail.com</p>
</footer>
</body>
</html>


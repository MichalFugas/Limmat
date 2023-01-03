<!DOCTYPE html>
<html>
<head>
  <title>Seite zum quittieren</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="/CSS/main1.css">
</head>
<body>
<header>
    <script>
        function openBoxx(alert){
            console.log(alert)
            document.getElementById(`alertPa`).innerHTML=alert;
            setTimeout(() => {
                document.getElementById('alertPa').innerHTML='';
            }, 5000);
        }
    </script>

    <div class="alertPa"><p  id="alertPa"></p></div>
    <div class="php"><p ><?php

            class MyDB extends SQLite3
            {
                function __construct()
                {
                    $this->open('home/pi/Limmat/Limmat.db');
                }
            }
            $db = new MyDB();
            if(!$db){
                echo $db->lastErrorMsg();
            } else {
                echo ".</br>";
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
</header>

<main>

    <div class="main" >
        <div class="center">

            <div class="time">
                <p class="centeredTIME" id="TIME"></p>
            </div>
            <div class="form">
                <form action="" method="post" autocomplete="off">
                    <input class="centered width-200px" type="text" name="dienst" id="dienst" maxlength="3" placeholder="Dienst Nr:" autofocus="autofocus">
                    <button class="quittieren"  type="submit" name="ok">Quittieren</button>
                </form>
            </div>
            <div class="button">
                <button class="unquittierte" onclick="openWin(),setTimeout(closeWin, 5000) ">Unquittierte (F2)</button>

                
            </div>

        <script>
            function openBox(){
                document.getElementById('alertP').innerHTML="TTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTT";
                setTimeout(() => {
                    document.getElementById('alertP').innerHTML="";
                }, 3000);
            }
        </script>

        <script>
        var display=setInterval(function(){Time()},0);

        function Time()
        {
            var date=new Date();
            var time=date.toLocaleTimeString();
            document.getElementById("TIME").innerHTML=time;
        }
    </script>

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






        <script>
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
    </div>
</main>
<footer>
    <p class="foot">Autor: Michal Fugas, michal.fugas@hotmail.com</p>
</footer>
</body>
</html>

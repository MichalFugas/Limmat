<!DOCTYPE html>
<html>
<head>
    <title>Unquittierte Dienste</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/CSS/unquittierte_css.css">

    <script type="text/javascript">
        function closeCurrentTab(){
            var conf=confirm("Are you sure, you want to close this tab?");
            if(conf==true){
                close();
            }
        }
    </script>




</head>

<body>

<?php

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
     //echo "Opened database successfully</br>";
  }

$sql =<<<EOF
 DROP VIEW unquittierte;
EOF;
$db->exec($sql);


$sql =<<<EOF
    CREATE VIEW unquittierte(Dienst,Zeit,Name) AS SELECT Part_1,Begin_part_1,Name FROM TT WHERE Checkbox_part_1 IS NOT '1' AND Begin_part_1 IS NOT '' AND Begin_part_1 IS NOT NULL UNION SELECT Part_2,Begin_part_2,Name FROM TT WHERE Checkbox_part_2 IS NOT '1' AND Begin_part_2 IS NOT '' AND Begin_part_2 IS NOT NULL UNION SELECT Part_3,Begin_part_3,Name FROM TT WHERE Checkbox_part_3 IS NOT '1' AND Begin_part_3 IS NOT '' AND Begin_part_3 IS NOT NULL;  
EOF;

$db->exec($sql);


$sql =<<<EOF
    COMMIT;
EOF;
$db->exec($sql);

$query=<<<EOF
    SELECT * FROM unquittierte ORDER BY Zeit;
EOF;

$ret = $db->query($query);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
      echo $row['Zeit'] . "\t";
      echo $row['Dienst'] ."\t";
      echo $row['Name'] ."</br>";
   }
  // echo "Operation done successfully\n";
   $db->close();

?>


</body>

</html>

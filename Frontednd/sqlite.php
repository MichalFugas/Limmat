<h1>Cos noweggo</h1>
<h2><?php echo $chauffeur[17] ?></h2>


<?php

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('/var/www/html/database/Limmat.db');
    }
}
$db = new MyDB();
if(!$db){
    echo $db->lastErrorMsg();
} else {
    echo "Opened database successfully</br>";
}
$zapytanie = $db->query('SELECT * FROM TT WHERE Part_1="100"');
$chauffeur = $zapytanie->fetchArray();
echo "$chauffeur[17]";
?>
<h3><?php echo $chauffeur[17] ?></h3>

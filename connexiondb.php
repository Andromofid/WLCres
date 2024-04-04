<?php
    $lhost = "localhost:3306";
    $dbname = "wlc_res";
    $username = "root";
    $pass = "Youssefwac2003";
    try {
        $db = new PDO("mysql:host=$lhost;dbname=$dbname", $username, $pass);
    } catch (PDOException $e) {
        echo "something is incorecct" . $e->getMessage();
    }

    ?>
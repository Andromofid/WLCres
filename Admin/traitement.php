<?php
if (!isset($_SESSION["Exist"])) {
    header("location:login.php");
} else {
    if (isset($_POST['done'])) {
        require("./connexiondb.php");
        extract($_POST);
        $image = file_get_contents($_FILES['Photo']['tmp_name']);
        // var_dump($_POST,$image);
        $sql = $db->prepare("INSERT INTO restaurant(Nom_Res,Photo_Res,Ville,Cartier,Specialites,C_Latitude,C_Longitude) VALUES(?,?,?,?,?,?,?)");
        $sql->execute([$Nom, $image, $Ville, $Cartier, $Specialites, $Latitude, $Longitude]);
        header("location:./index.php");
    } elseif (isset($_POST['exit'])) {
        session_start();
        session_destroy();
        header("location:./login.php");
    } else {
        header("location:./index.php");
    }
}

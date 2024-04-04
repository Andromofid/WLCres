<?php
session_start();
if (!isset($_SESSION["Data"])) {
    header("location:login.php");
} else {
    if (isset($_POST['done'])) {
        require("../connexiondb.php");
        extract($_POST);
        $image = file_get_contents($_FILES['Photo']['tmp_name']);
        $type = $_FILES['Photo']['type'];
        var_dump($_POST,$type);

        $sql = $db->prepare("INSERT INTO restaurant(Nom_Res,Photo_Res,Type_Photo,Ville,Cartier,Specialites,C_Latitude,C_Longitude) VALUES(?,?,?,?,?,?,?,?)");
        $sql->execute([$Nom, $image,$type, $Ville, $Cartier, $Specialites, $Latitude, $Longitude]);
        header("location:./index.php");
    } elseif (isset($_POST['exit'])) {
        session_start();
        session_destroy();
        header("location:./login.php");
    } else {
        header("location:./index.php");
    }
}

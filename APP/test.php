<?php
require("../connexiondb.php");
// Check if Specialite parameter is set in the POST request
if(isset($_POST['Specialite'])) {
    // Retrieve the value of Specialite
    extract($_POST);
    $sql=$db->prepare("SELECT Cartier FROM restaurant WHERE Ville=? AND Specialites LIKE'%$Specialite%'");
    $sql->execute([$Ville]);
    $Cartiers = $sql->fetchAll();
    print_r(json_encode($Cartiers));

} else {
    // If Specialite parameter is not set, return an error message
    echo "Error: Specialite parameter not found in the POST request.";
}
?>

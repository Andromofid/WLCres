<?php
require("../connexiondb.php");
$sql = $db->prepare("SELECT * from restaurant");
$sql->execute([]);
$restaurants = $sql->fetchAll();
if (isset($_POST['done'])) {
    extract($_POST);
    $fileimg = $_FILES["Photo"];
    $nameimg = $fileimg["name"];
    $pathtmpimgsrc = $fileimg["tmp_name"];
    $pathimgdest = "../images/Offres/$nameimg";
    $sql = $db->prepare("INSERT INTO offres (IdRes,Des,statue,NomImg)Values(?,?,?,?)");
    $sql->execute([$Res,$Des,$Statue,$nameimg]);
    move_uploaded_file($pathtmpimgsrc, $pathimgdest);
    header("location:../index.php?done=Demande Envoyer");

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.min.css" integrity="sha512-wCrId7bUEl7j1H60Jcn4imkkiIYRcoyq5Gcu3bpKAZYBJXHVMmkL4rhtyhelxSFuPMIoQjiVsanrHxcs2euu/w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-danger ">
        <div class="container justify-content-between">
            <a class="navbar-brand" href="#">
                <img src="./images/eatLogo.png" alt="" width="100px">

            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarNav">
                <ul class="navbar-nav justify-content-center w-100">
                    <li class="nav-item">
                        <a class="nav-link text-dark" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="AjouterOffres.php">Ajouter un Offres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#">Contact</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-6 d-flex flex-column justify-content-center align-items-center  bg-light" style="height: 100vh;">
                <img src="https://www.eat.ma/wp-content/uploads/eat-logo-red-small.png" width="200px" alt="" class="py-3">
                <p class="text-dark fs-6 text-center  ">
                    Bonjour dans votre espace , <br>
                    Votre demander va valider apré ws quelque heurs
                </p>

            </div>
            <div class="col-sm-12 col-md-6 form-body d-flex justify-content-center align-items-center m-auto " style="height: 100vh;">

                <div class="d-flex justify-content-center align-items-center ">

                    <div class="form-holder ">
                        <div class="form-content m-auto">
                            <div class="form-items ">
                                <h3 class="">Ajouter un offres</h3>
                                <p class="">
                                    Remplissez les données ci-dessous.</p>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="col-md-12 my-3">
                                        Choissi votre restaurant:
                                        <select class="select" name="Res">
                                            <?php foreach ($restaurants as $restaurant) { ?>
                                                <option value="<?= $restaurant['IdRes'] ?>"><?= $restaurant['Nom_Res'] ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>

                                    <div class="col-md-12 my-3">
                                        Choissi le statue de votre offre:
                                        <select class="form-select" name="Statue">
                                            <option value="Active">Active</option>
                                            <option value="Expire">Expire</option>
                                            <option value="Programe">Programe</option>
                                        </select>

                                    </div>

                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="Des" placeholder="Description d'offre " required>
                                    </div>


                                    <div class="col-md-12 my-3">
                                        <label for="" class="text-dark">Photo de restaurant:</label>
                                        <input class="form-control" type="file" accept="image/*" name="Photo" required>
                                    </div>


                                    <div class="form-button mt-3">
                                        <button id="submit" type="submit" class="btn btn-danger " name="done">Envoyer la demande</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(function() {
            $(".select").selectize();
        });
    </script>

</body>

</html>
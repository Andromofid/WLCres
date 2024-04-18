<?php
require("../connexiondb.php");
session_start();
if (!isset($_SESSION["Data"])) {
  header("location:login.php");
}
if (isset($_GET['id'])) {
  // offre id :
  $idOffre = (int)$_GET['id'];
  $sql = $db->prepare("SELECT * FROM offres WHERE idOffre = ?");
  $sql->execute([$idOffre]);
  $offre = $sql->fetch();
  if (empty($offre)) {
    header('location:offres.php');
    }
  if (isset($_POST['valider'])) {
    $sql = $db->prepare("UPDATE offres SET Activation=1 WHERE idOffre=?");
    $sql->execute([$idOffre]);
    $message = 'offre valide';
    header("location:./offres.php?done=" . $message . "");
  } else if (isset($_POST['supprimer'])) {
    $sql = $db->prepare("DELETE FROM  offres  WHERE idOffre=?");
    $sql->execute([$idOffre]);
    $message = 'offre supprimer!';
    header("location:./offres.php?done=" . $message . "");
  }
} else {
  header('location:offres.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eat | offre detail</title>
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</head>

<body>
  <nav class="navbar navbar-expand-lg bg-danger">
    <div class="container-fluid">
      <a href="https://www.eat.ma/" class="link-dark px-2 fs-4"><img class="w-50" src="https://www.eat.ma/wp-content/uploads/eat-ma-logo-e1593253424129.png" alt="eat"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link text-light" href="index.php">Ajouter restaurants</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="offres.php">Ajouter offres</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div>
    <div class="card text-center m-auto " style="width: 300px;">
      <img src="../images/Offres/<?= $offre['NomImg'] ?>" class="card-ig-top" alt="offre image">
      <div class="card-body">
        <h5 class="card-title">N° : <?= $offre['IdOffre'] ?></h5>
        <p class="card-text"><?= $offre['Des'] ?></p>
        <p class="card-text">Statue : <?= $offre['statue'] ?></p>
        <!-- form validation -->
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Confirmer
        </button>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#supprimer">
          Supprimer
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmer offre</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                valider l'offre ?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                <form action="" method="post">
                  <input type="submit" name="valider" class="btn btn-primary" value="valider">
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="supprimer" tabindex="-1" aria-labelledby="supprimer" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Supprimer l'offre</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                confimer la suppression :
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                <form action="" method="post">
                  <input type="submit" name="supprimer" class="btn btn-danger" value="supprimer">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script src=" ./js/bootstrap.min.js"></script>

</body>

</html>
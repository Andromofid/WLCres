<?php
require("../connexiondb.php");
session_start();
if (!isset($_SESSION["Data"])) {
  header("location:login.php");
}
$sql = $db->prepare("SELECT * FROM offres WHERE Activation=0");
$sql->execute([]);
$offres = $sql->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eat | ajouter offres</title>
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
  <div class="container my-5">
    <?php if (isset($_GET['done'])) {
    ?>
      <div class="alert alert-info" role="alert">
        <?= $_GET['done'] ?>
      </div>
    <?php
    } ?>
  <!-- main content -->
  <div class="container my-5">
    <div class="row g-2">
      <?php foreach ($offres as $offre) {
      ?>
        <div class="col">
          <div class="card" style="width: 18rem;">
            <img src="../images/Offres/<?= $offre['NomImg'] ?>" class="card-img-top" alt="offre image">
            <div class="card-body">
              <h5 class="card-title">N° : <?= $offre['IdOffre'] ?></h5>
              <p class="card-text">Description : <?= $offre['Des'] ?></p>
              <p class="card-text">Statue : <?= $offre['statue'] ?></p>
              <a href="offreDetails.php?id=<?= $offre['IdOffre'] ?>" class="stretched-link"></a>
            </div>
          </div>
        </div>
      <?php
      } ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>
<?php
require("./connexiondb.php");
$sql = $db->prepare("SELECT DISTINCT Ville FROM restaurant");
$sql->execute([]);
$restaurants = $sql->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
          <a class="nav-link text-dark " aria-current="page" href="index.php">Accueil</a>
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

  <div class="container my-4">
    <div class="row g-2">
      <?php
      foreach ($restaurants as $restaurant) {
      ?>
        <!-- card start -->
        <div class="col-md-3 col-sm-6">
          <div class="card text-bg-dark overflow-hidden" style="height: 150px;">
            <img src="../images/<?= $restaurant['Ville'] ?>.jpg" loading="lazy" class="card-img" alt="<?= $restaurant['Ville'] ?>">
            <div class="d-flex justify-content-center align-items-center card-img-overlay">
              <h5 class="card-title"><?= $restaurant['Ville'] ?></h5>
              <a href="./APP/index.php?Ville=<?= $restaurant['Ville'] ?>" class="stretched-link"></a>
            </div>
          </div>
        </div>

        <!-- card end -->
      <?php
      }
      ?>
    </div>
  </div>
</body>

</html>
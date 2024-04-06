<?php
require("../connexiondb.php");
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
  <div class="container my-4">
    <div class="row g-2">
      <?php
      foreach ($restaurants as $restaurant) {
      ?>
      <!-- card start -->
      <div class="col-3">
        <div class="card text-bg-dark">
          <img src="../images/Marrakech.jpg" class="card-img" alt="<?= $restaurant['Ville'] ?>">
          <div class="d-flex justify-content-center align-items-center card-img-overlay">
            <h5 class="card-title"><?= $restaurant['Ville'] ?></h5>
            <a href="./index.php?Ville=<?= $restaurant['Ville'] ?>" class="stretched-link"></a>
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
<?php
require("../connexiondb.php");

if (isset($_GET["Ville"])) {
    extract($_GET);

    // Les restaurants par Ville
    $sql = $db->prepare("SELECT * FROM restaurant WHERE Ville = ?");
    $sql->execute([$Ville]);
    $restaurants = $sql->fetchAll();

    // Toutes les Villes
    $sql = $db->prepare("SELECT DISTINCT Ville FROM restaurant");
    $sql->execute([]);
    $Villes = $sql->fetchAll();

    // Toutes les spécialités de la ville
    $sql = $db->prepare("SELECT DISTINCT Specialites FROM restaurant WHERE Ville = ?");
    $sql->execute([$Ville]);
    $Specialites = $sql->fetchAll();

    if (isset($_POST["Ville"])) {
        extract($_POST);
        // Les restaurants par Ville et Specialite
        $sql = $db->prepare("SELECT * FROM restaurant WHERE Ville = ? AND Specialites = ?");
        $sql->execute([$Ville, $Specialite]);
        $restaurants = $sql->fetchAll();
    }
} else {
    $error = "<h1 class='text-center'>404 <br/> PAGE NOT FOUND</h1>";
    header("location:./Search.php");
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        /* Add your CSS styles here */
    </style>
</head>

<body>

    <nav class="navbar bg-body-tertiary position-fixed" style="width: 100%;">
        <div class="container-fluid">
            <form action="" method="post" class="form d-flex gap-5 align-items-end " role="search">
                <!-- Form for selecting city and specialty -->
                <!-- You can keep this as it is -->
            </form>
        </div>
    </nav>

    <?php if (isset($error)) { ?>
        <!-- Display error if any -->
        <div class="d-flex align-items-center justify-content-center w-100" style="height: 100vh;">
            <?php echo $error; ?>
        </div>
    <?php } else { ?>
        <div class="container mt-5 container1">
            <!-- Display restaurant cards here -->
            <div class="col-sm-10 col-md-6 restaurant" id="restaurant-container">
                <!-- Restaurants will be loaded dynamically here -->
            </div>
        </div>
    <?php } ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(function() {
            $(".country").selectize();
        });

        // Function to load restaurants using AJAX
        function loadRestaurants() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var restaurants = JSON.parse(this.responseText);
                    var html = "";
                    restaurants.forEach(function(restaurant) {
                        var image = "data:" + restaurant.Type_Photo + ";base64," + restaurant.Photo_Res;
                        html += `
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="${image}" class="img-fluid rounded-start" alt="${restaurant.Nom_Res}">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">${restaurant.Nom_Res}</h5>
                                            <p class="card-text text-danger">${restaurant.Specialites}</p>
                                            <p class="card-text">${restaurant.Cartier}</p>
                                            <p class="header">${restaurant.Ville}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    document.getElementById("restaurant-container").innerHTML = html;
                }
            };
            xhttp.open("GET", "fetch_restaurants.php?Ville=<?php echo $_GET['Ville']; ?>", true);
            xhttp.send();
        }

        // Call the function when the page loads
        window.onload = loadRestaurants;
    </script>
</body>

</html>
<?php
require("../connexiondb.php");
if (isset($_GET["Ville"])) {
    extract($_GET);
    // Les reatau par Ville
    $sql = $db->prepare("SELECT * FROM restaurant WHERE Ville = ?");
    $sql->execute([$Ville]);
    $restaurants = $sql->fetchAll();

    // Touts les Villes
    $sql = $db->prepare("SELECT DISTINCT Ville FROM restaurant  ");
    $sql->execute([]);
    $Villes = $sql->fetchAll();
    // Touts Specialites de ville
    $sql = $db->prepare("SELECT DISTINCT Specialites FROM restaurant WHERE Ville = ?");
    $sql->execute([$Ville]);
    $Specialites = $sql->fetchAll();
    if (isset($_POST["Ville"])) {
        extract($_POST);
        // Les reatau par Ville et Specialite
        $sql = $db->prepare("SELECT * FROM restaurant WHERE Ville = ? AND Specialites =? ");
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
        #map {
            border-radius: 20px;
            height: 60vh;
            position: sticky;
            top: 100px;
            transition: 0.5s;

        }
        .container1{
            margin-top: 70px !important;
        }

        .info {
            width: 200px;
        }

        .navbar {
            top: 0px;
            z-index: 999;
        }

        .content {
            z-index: 1;
        }
                .selectize-control.single .selectize-input.input-active,
        .selectize-input {
            width: 210px;
        }
                #country {
            width: 210px !important;
            height: 35px;
            border: 1px solid #ddd;
            padding-left: 10px;
        }

        .selectize-control.single .selectize-input.input-active,
        .selectize-input {
            width: 210px;
            height: 35px;
            overflow-y: hidden;
        }

        .icon {
            width: 15px;
        }

        #country {
            width: 210px !important;
            height: 35px;
            border: 1px solid #ddd;
            padding-left: 10px;
        }

        @media screen and (max-width:769px) {
            .content {
                display: flex;
                flex-direction: column-reverse;
                align-items: center;
            }

            #map {
                display: none;
            }

            .container1 {
                margin-top: 100px !important;
            }

            .form {
                width: 100%;
                flex-direction: column;
                align-items: center !important;
            }

            .selectize-control.single .selectize-input.input-active,
            .selectize-input {
                width: 300px;

            }

            .button {
                width: 50%;
            }
        }
    </style>
    </style>
</head>

<body>

    <nav class="navbar bg-body-tertiary position-fixed" style="width: 100%;">
        <div class="container-fluid">
            <form action="" method="post" class="form d-flex gap-5 align-items-end " role="search">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="quoi" class="col-form-label">Quoi ?</label>
                    </div>
                    <div class="col-auto">
                        <select class="country" id="country" name="Specialite">
                            <?php foreach ($Specialites as $Specialite) {
                                if ($_POST['Specialite'] == $Specialite['Specialites']) { ?>
                                    <option value="<?= $Specialite['Specialites'] ?>" selected><?= $Specialite['Specialites'] ?></option>
                                <?php } else { ?>
                                    <option value="<?= $Specialite['Specialites'] ?>"><?= $Specialite['Specialites'] ?></option>

                            <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <!-- box 2 -->
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="ou" class="col-form-label">Où ?</label>
                    </div>
                    <div class="col-auto">
                        <select class="country" id="country" name="Ville">
                            <?php foreach ($Villes as $Ville) {
                                if ($_GET["Ville"] == $Ville) {
                            ?>
                                    <option value="<?= $_GET['Ville'] ?>" selected><?= $_GET['Ville'] ?></option>
                                <?php } else { ?>
                                    <option value="<?= $_GET['Ville'] ?>"><?= $_GET['Ville'] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <button class="btn btn-danger button my-1 text-center" type="submit">
                    <svg class="icon  text-center " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                    </svg>
                </button>
            </form>
        </div>
    </nav>

    <!-- hero section -->
    <?php if (isset($error)) { ?>
        <div class=" d-flex align-items-center justify-content-center w-100" style="height: 100vh;">
            <?php echo ($error) ?>
        </div>
    <?php } else { ?>
        <div class="container mt-5 container1">
            <div>
                <h1 class="fw-semibold"><span class="header">Les restos</span> <span class="text-danger "><?= $_GET["Ville"] ?></span></h1>
                <p class="paragraphe">Envie de nouveaux goûts ? Découvre les restaurants à proximité.</p>
            </div>
            <div class="row h-100  content">
                <!-- restaurant -->
                <div class="col-sm-10 col-md-6 restaurant">
                    <?php
                    foreach ($restaurants as $restaurant) {
                        $image = "data:" . $restaurant["Type_Photo"] . ";base64," . base64_encode($restaurant["Photo_Res"]);
                        $place = $restaurant['Nom_Res'];
                        // $replaced = str_replace(' ', '+', $place);
                    ?>
                        <!-- card start -->
                        <div class="card mb-3 " style="max-width: 540px;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="<?= $image ?>" class="img-fluid rounded-start" alt="<?= $restaurant['Nom_Res'] ?>">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?= $restaurant['Nom_Res'] ?>
                                        </h5>
                                        <p class=" card-text text-danger "><?= $restaurant['Specialites'] ?></p>
                                        <p class=" card-text"><?= $restaurant['Cartier'] ?></p>
                                        <p class="header"><?= $restaurant['Ville'] ?></p>

                                        <!-- 
                                            <a href="https://www.google.com/maps/place/<?= $replaced ?>/@<?= $restaurant['C_Latitude'] ?>,<?= $restaurant['C_Longitude'] ?>,13z/data=!3m1!4b1!4m2!3m1!1s0x465758d912d321b5:0x55675191e550be84?hl=en"
                                        class="stretched-link"></a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card end -->
                    <?php
                    }
                    ?>


                </div>
                <div id="map" class=" col-md-6 ">
                    <a href="https://www.maptiler.com"><img src="https://api.maptiler.com/resources/logo.svg" alt="MapTiler logo" /></a>
                </div>

            </div>
        </div>
    <?php } ?>
    <h1>+++</h1>
    <h1>+++</h1>
    <h1>+++</h1>
    <h1>+++</h1>
    <h1>+++</h1>
    <h1>+++</h1>
    <h1>+++</h1>
    <h1>+++</h1>
    <h1>+++</h1>
    <h1>+++</h1>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

    <script>
        $(function() {
            $(".country").selectize();
        });
        window.onscroll = () => {
            var vmap = document.getElementById("map");
            if (window.scrollY >= 650) {
                vmap.style.transform = "translateY(-400px)";
                // vmap.style.position = "relative";
            } else {
                vmap.style.transform = "translateY(0)";
                vmap.style.position = "sticky";
                vmap.style.top = "100px";
            }

        }
        //starting position
        const map = L.map("map").setView(
            [
                <?php echo $restaurants[0]['C_Latitude']; ?>,
                <?php echo $restaurants[0]['C_Longitude']; ?>
            ], 12);
        var marker = L.marker(
            [
                <?php echo $restaurants[0]['C_Latitude']; ?>,
                <?php echo $restaurants[0]['C_Longitude']; ?>
            ]).addTo(map);

        <?php foreach ($restaurants as $res) : ?>
            var marker<?php echo $res['IdRes']; ?> = L.marker([<?php echo $res['C_Latitude']; ?>, <?php echo $res['C_Longitude']; ?>]).addTo(map);
            marker<?php echo $res['IdRes']; ?>.bindPopup('<?php echo "<div class=" . "info" . "><h3>" . $res['Nom_Res'] . "</h3><p>" . $res['Ville'] . "</p><p class=\"text-danger\">" . $res['Specialites'] . "</p></div>"; ?>');
        <?php endforeach; ?>

        L.tileLayer(
            "https://api.maptiler.com/maps/topo-v2/256/{z}/{x}/{y}.png?key=IAKoattdnMh2FDr00Ydx", {
                //style URL
                tileSize: 512,
                zoomOffset: -1,
                minZoom: 1,
                attribution: '<?php echo '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>'; ?>',
                crossOrigin: true,
            }
        ).addTo(map);
    </script>
</body>

</html>

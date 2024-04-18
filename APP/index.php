<?php
require("../connexiondb.php");
if (isset($_GET["Ville"])) {
    extract($_GET);
    // Les reatau par Ville
    $sql = $db->prepare("SELECT * FROM restaurant WHERE Ville = ?");
    $sql->execute([$Ville]);
    $restaurants = $sql->fetchAll();
    if(empty( $restaurants)){
        header("location:../index.php");
    }
    // Touts lesVilles
    $sql = $db->prepare("SELECT DISTINCT Ville FROM restaurant  ");
    $sql->execute([]);
    $Villes = $sql->fetchAll();
    // Touts Specialites de ville
    $sql = $db->prepare("SELECT DISTINCT Specialites FROM restaurant WHERE Ville = ?");
    $sql->execute([$Ville]);
    $Specialites = $sql->fetchAll();
    // Touts Quartier de ville
    $sql = $db->prepare("SELECT DISTINCT Cartier FROM restaurant WHERE Ville = ?");
    $sql->execute([$Ville]);
    $Cartiers = $sql->fetchAll();
    if (isset($_POST["Specialite"])) {
        extract($_POST);
        // Les reatau par Ville et Specialite
        $sql = $db->prepare("SELECT * FROM restaurant WHERE Ville = ? AND Specialites  LIKE'%$Specialite%' AND Cartier LIKE'%$Cartier%' ");
        $sql->execute([$_GET['Ville']]);
        $restaurants = $sql->fetchAll();
    }
    // var_dump($restaurants);
} else {
    header("location:../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.min.css" integrity="sha512-wCrId7bUEl7j1H60Jcn4imkkiIYRcoyq5Gcu3bpKAZYBJXHVMmkL4rhtyhelxSFuPMIoQjiVsanrHxcs2euu/w==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.1/css/tom-select.min.css" integrity="sha512-fnaIKCc5zGOLlOvY3QDkgHHDiDdb4GyMqn99gIRfN6G6NrgPCvZ8tNLMCPYgfHM3i3WeAU6u4Taf8Cuo0Y0IyQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.1/js/tom-select.complete.min.js" integrity="sha512-zdXqksVc9s0d2eoJGdQ2cEhS4mb62qJueasTG4HjCT9J8f9x5gXCQGSdeilD+C7RqvUi1b4DdD5XaGjJZSlP9Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

    <style>
        #map {
            border-radius: 20px;
            height: 60vh;
            position: sticky;
            top: 100px;
            transition: 0.5s;

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


        #select,
        .form-select,
        .sel {
            width: 210px !important;
            height: 35px;
            border: 1px solid #ddd;
            padding-left: 10px;
        }

        .ts-control,
        .S2 {
            width: 210px;
            height: 35px;
            overflow-y: hidden;
        }

        .icon {
            width: 15px;
        }

        #select {
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


            .form-content,
            .select-content {
                width: 100%;
                flex-direction: column;
                align-items: center !important;
            }


            .button {
                width: 150px;
                margin-top: 15px !important;
            }
        }
    </style>
</head>

<body class="body">
    <!-- NAV BAR -->
    <nav class="bg-danger w-100 mb-3"><img src="../images/eatLogo.png" alt="" width="100px"></nav>

    <!-- Header -->
    <nav class="navbar " style="width: 100%;">

        <div class="d-flex justify-content-around w-100 form-content">
            <form action="index.php?Ville=<?= $_GET['Ville'] ?>" method="post" class="form d-flex  " role="search">
                <div class="d-flex select-content align-items-end ">
                    <div class="" style="width: 210px;">
                        Specialite:
                        <select class="S1" id="select1" name="Specialite" style="width: 200px;height: 35px;overflow-y: hidden;">
                            <option value=""></option>
                            <?php foreach ($Specialites as $Specialite) {
                                if ($_POST['Specialite'] == $Specialite['Specialites']) { ?>

                                    <option value="<?= $Specialite['Specialites'] ?>" selected><?= $Specialite['Specialites'] ?></option>
                                <?php } else { ?>
                                    <option value="<?= $Specialite['Specialites'] ?>"><?= $Specialite['Specialites'] ?></option>

                            <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="ms-md-3">
                        Quartier:
                        <select class="form-control S2" id="select" name="Cartier">
                            <option value="">
                            </option>
                            <?php foreach ($Cartiers as $Cartier) { 
                                if ($_POST['Cartier'] == $Cartier['Cartier']) {?>
                                <option value="<?= $Cartier['Cartier'] ?>" selected><?= $Cartier['Cartier'] ?></option>
                                <?php } else { ?>
                                <option value="<?= $Cartier['Cartier'] ?>"><?= $Cartier['Cartier'] ?></option>
                            <?php } }?>
                        </select>
                    </div>
                    <div class="my-1 mx-2">
                        <button class="btn btn-primary btn-sm button m-auto" id="submit">Search</button>
                    </div>
                </div>
                <!-- box 2 -->
            </form>

            <form action="" method="get" class="form d-flex " role="search">
                <div class="d-flex select-content align-items-end">
                    <div class="">
                        Ville:
                        <select class="form-control" id="select" name="Ville">
                            <?php foreach ($Villes as $Ville) {
                                if ($_GET["Ville"] == $Ville["Ville"]) {
                            ?>
                                    <option value="<?= $Ville['Ville'] ?>" selected><?= $Ville['Ville'] ?></option>
                                <?php } else { ?>
                                    <option value="<?= $Ville['Ville'] ?>"><?= $Ville['Ville'] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="my-1 mx-2">
                        <button class="btn btn-danger btn-sm  button m-auto">Changer la ville</button>
                    </div>
                </div>
            </form>
        </div>

    </nav>

    <!-- hero section -->
    <div class="container  container1">
        <div>
            <h1 class="fw-semibold"><span class="header">Les restos</span> <span class="text-danger "><?= $_GET["Ville"] ?></span></h1>
            <p class="paragraphe">Envie de nouveaux goûts ? Découvre les restaurants à proximité.</p>
        </div>
        <?php if (!empty($restaurants)) { ?>
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
        <?php } else { ?>
            <div class="row h-100  content">
                <!-- restaurant -->
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    Aucun restaurant
                </div>
                <div id="map" class=" col-md-6 bg-light ">
                    <!-- <a href="https://www.maptiler.com"><img src="https://api.maptiler.com/resources/logo.svg" alt="MapTiler logo" /></a> -->
                </div>

            </div>
        <?php } ?>
    </div>
    <script>
        // SELECT 2 AND AJAX :
        new TomSelect("#select1");
        $(function() {
            var select1 = $("#select1");
            var select2 = $("#select");

            function DoAjax() {
                var selectedValue = select1.val();
                var QuartierValue = select2.val();
                $.ajax({
                    type: "POST",
                    url: "traitementselect.php",
                    data: {
                        Specialite: selectedValue,
                        Ville: encodeURIComponent('<?= $_GET['Ville'] ?>'),
                    },
                    success: function(response) {
                        // Log the modified value to the console
                        var res = JSON.parse(response);
                        select2.empty();

                        select2.append($('<option>', {
                            value: "",
                            text: ""
                        }))
                        res.forEach(element => {

                            select2.append($('<option>', {
                                value: element.Cartier,
                                text: element.Cartier
                            }));
                            console.log(element);
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            }
            $('#select1').change(() => {
                DoAjax();
            });
            window.onload = () => {
                DoAjax();
            }
            // $("#submit").click(()=>{
            //     DoAjax();
            // });
        });
        // FIXING SCROLLING AND MAP:
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
        // STARTING MAKING FIRST POSITION ,MAP AND MARKERS!  :
        var MarkerIcon = L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/8280/8280802.png',
            iconSize: [40, 40], // point from which the popup should open relative to the iconAnchor
            iconAnchor: [20, 20],
        });
        const map = L.map("map").setView(
            [
                <?php echo $restaurants[0]['C_Latitude']; ?>,
                <?php echo $restaurants[0]['C_Longitude']; ?>
            ], 12);
        var marker = L.marker(
            [
                <?php echo $restaurants[0]['C_Latitude']; ?>,
                <?php echo $restaurants[0]['C_Longitude']; ?>
            ], {
                icon: MarkerIcon
            }).addTo(map);
        marker.bindPopup('<?php echo "<div class=" . "info" . "><h3>" . $restaurants[0]['Nom_Res'] . "</h3><p>" . $restaurants[0]['Ville'] . "</p><p class=\"text-danger\">" . $restaurants[0]['Specialites'] . "</p></div>"; ?>')
        <?php foreach ($restaurants as $res) : ?>
            var marker<?php echo $res['IdRes']; ?> = L.marker([<?php echo $res['C_Latitude']; ?>, <?php echo $res['C_Longitude']; ?>], {
                icon: MarkerIcon
            }).addTo(map);
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
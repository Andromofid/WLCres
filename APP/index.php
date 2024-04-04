<?php
require("../connexiondb.php");
$sql = $db->prepare("SELECT * FROM restaurant");
$sql->execute([]);
$Data = $sql->fetchAll();
// var_dump($Data);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>

<body>
    <div class="container-fluid py-3">
        <div class="row">
            <?php
            foreach ($Data as $res) {
                $image = "data:" . $res['Type_Photo'] . ";base64," . base64_encode($res['Photo_Res']);
            ?>
                <div class="col-4">
                    <div class=" card ">
                        <div class="card-header justify-content-center">
                            <img src="<?= $image ?>" alt="" width="200px">

                        </div>
                        <div class="card-body">
                            <?= $res["Nom_Res"] ?>

                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>

</body>

</html>
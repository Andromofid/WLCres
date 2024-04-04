<?php
require("../connexiondb.php");
if (isset($_POST['done'])) {
    extract($_POST);
    $sql = $db->prepare("SELECT * FROM Admin WHERE Email = ? AND Pass = ?");
    $sql->execute([$Email, $Pass]);
    $user = $sql->fetch();
    if (!empty($user)) {
        session_start();
        $_SESSION["Data"] = $user;
        header("location:index.php");
    } else {
        $error = "";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap');

        *,
        body {
            font-family: 'Poppins', sans-serif;
            /* font-weight: 400; */
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
            -moz-osx-font-smoothing: grayscale;

        }

        body {
            height: 100vh;
            background-color: #152733;
            overflow-y: scroll;
            overflow-x: hidden;

        }


        .form-holder {
            margin: auto;
            scale: 0.8;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            /* min-height: 100vh; */
        }

        .form-holder .form-content {
            position: relative;
            text-align: center;
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-align-items: center;
            align-items: center;
            padding: 60px;
        }

        .form-content .form-items {

            /* border: 3px solid red; */
            padding: 40px;
            display: inline-block;
            width: 100%;
            min-width: 540px;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            text-align: left;
            -webkit-transition: all 0.4s ease;
            transition: all 0.4s ease;
        }

        .form-content h3 {
            color: black;
            text-align: left;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .form-content h3.form-title {
            margin-bottom: 30px;
        }

        .form-content p {
            color: black;
            text-align: left;
            font-size: 17px;
            font-weight: 300;
            line-height: 20px;
            margin-bottom: 30px;
        }


        .form-content label,
        .was-validated .form-check-input:invalid~.form-check-label,
        .was-validated .form-check-input:valid~.form-check-label {
            color: #fff;
        }

        .form-content input[type=text],
        .form-content input[type=password],
        .form-content input[type=email],
        .form-content input[type=number],
        .form-content input[type=file],
        .form-content select {
            width: 100%;
            padding: 9px 20px;
            text-align: left;
            border: 0;
            outline: 1px solid black;
            border-radius: 6px;
            background-color: #fff;
            font-size: 15px;
            font-weight: 300;
            color: #8D8D8D;
            -webkit-transition: all 0.3s ease;
            transition: all 0.3s ease;
            margin-top: 16px;
        }


        .btn-primary {
            background-color: #6C757D;
            outline: none;
            border: 0px;
            box-shadow: none;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active {
            background-color: #495056;
            outline: none !important;
            border: none !important;
            box-shadow: none;
        }


        .mv-up {
            margin-top: -9px !important;
            margin-bottom: 8px !important;
        }

        .invalid-feedback {
            color: #ff606e;
        }

        .valid-feedback {
            color: #2acc80;
        }


        @media screen and (max-width:770px) {
            body {
                overflow-y: scroll;
                overflow-x: hidden;

            }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>


<body class="">
    <nav class="w-100 d-flex justify-content-between align-items-center bg-danger" style="padding: 5px 0;">
        <a href="https://www.eat.ma/" class="link-dark px-2 fs-4">
            <img src="https://www.eat.ma/wp-content/uploads/eat-ma-logo-e1593253424129.png" width="150px" alt="">
        </a>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-6 d-flex flex-column justify-content-center align-items-center bg-light" style="height: 100vh;">
                <img src="https://www.eat.ma/wp-content/uploads/eat-logo-red-small.png" width="300px" alt="" class="py-3">
                <p class="text-dark fs-6 text-center">Bonjour dans votre espace d'admin ,commence d'jaouter des restaurants .
            </div>
            <div class="col-sm-12 col-md-6 form-body d-flex justify-content-center align-items-center m-auto " style="height: 100vh;">

                <div class="d-flex justify-content-center align-items-center ">

                    <div class="form-holder ">
                        <div class="form-content m-auto">
                            <div class="form-items ">
                                <h3 class="my-3">Login</h3>
                                <p class="">
                                    Remplissez les données ci-dessous.</p>
                                <?php
                                if (isset($error)) {
                                ?><p class="alert alert-danger ">incorrect email or password</p><?php } ?>
                                <form action="#" method="post" class="requires-validation " enctype="multipart/form-data">
                                    <div class="col-md-12">
                                        <input class="form-control my-3" type="email" name="Email" placeholder="Email" required>
                                    </div>

                                    <div class="col-md-12">
                                        <input class="form-control my-3" type="password" name="Pass" placeholder="Mot de pass" required>
                                    </div>
                                    <div class="form-button mt-3">
                                        <button id="submit" type="submit" class="btn btn-danger" name="done">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>



    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
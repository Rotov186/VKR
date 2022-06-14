<?php
    include('login.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ специальной техники</title>
    <link rel="shortcut icon" href="img/SPK.svg">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body class="bg-primary bg-opacity-10">
    <header>

        <style>
            .navbar {
              margin-top: 32px;
              border-radius: 0.25rem;
            }
            main {
              height: 86vh;
            }
            .zakaz {
              color: rgb(0,76,156);
            }
            .btn-primary {
              background-color: rgb(0,76,156);   
            }
            .btn-primary:hover {
              background-color: rgb(0,76,156); 
            }
          </style>

          <nav class="navbar navbar-expand-lg bg-light container shadow rounded">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="index.php">
                    <img src="img/SPK.svg" alt="" width="110" class="d-inline-block align-text-top me-4 ms-4">
                    <strong class="zakaz d-sm-none d-md-block d-none d-sm-block">ЗАКАЗ СПЕЦИАЛЬНОЙ ТЕХНИКИ<br><span class="fs-6">для АУ «СПК»</span></strong>
                  </a>
              <button class="navbar-toggler me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-lg-1"></ul>
                <form class="d-flex justify-content-end" role="search">
                  <button class="btn btn-primary me-2" type="submit"><a href="index.php" class="text-light text-decoration-none">Вход</a></button>
                  <button class="btn btn-primary me-4" type="submit"><a href="reg.php" class="text-light text-decoration-none">Регистрация</a></button>
                </form>
              </div>
            </div>
          </nav>

    </header>

    <main class="container d-flex align-items-center justify-content-center">
        <form method="POST">

          <div class="form-outline mb-2">
            <input name="login" type="text" id="form1Example1" class="form-control" placeholder="Логин" aria-label="Логин" />
          </div>

          <div class="form-outline mb-2">
            <input name="password" type="password" id="form1Example2" class="form-control" placeholder="Пароль" aria-label="Пароль"/>
          </div>
        
          <div class="d-grid gap-2">
           
          <div class="d-flex align-items-center justify-content-start">
          <input type="checkbox" name="not_attach_ip">
          <h1 class="ms-4 mt-2 fs-6"><strong>Запомнить?</strong></h1> 
          </div>

          <button name="submit" type="submit" class="btn btn-primary">Войти</button>
          </div>
        </form>
      </main>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>   
</body>
</html>
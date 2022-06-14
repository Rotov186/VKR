<?
// Скрипт проверки

// Соединямся с БД
$link=mysqli_connect("localhost", "root", "", "zt");

if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
    $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);

    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])
 or (($userdata['user_ip'] !== $_SERVER['REMOTE_ADDR'])  and ($userdata['user_ip'] !== "0")))
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
        print "Хм, что-то не получилось";
    }
    else
    {
        header("Refresh: 2; url=admin.php");    
    }
}
else
{
    header("Location: index.php");
}

//logout
if(isset($_POST['logout'])) {
    setcookie("id", "", time() - 3600*24*30*12, "/");
    setcookie("hash", "", time() - 3600*24*30*12, "/",null,null,true); // httponly !!!

// Переадресовываем браузер на страницу проверки нашего скрипта
    header("Location: index.php"); exit;
}


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
            .contenta {
                margin-top: 300px;
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
                <a class="navbar-brand d-flex align-items-center" href="admin.php">
                    <img src="img/SPK.svg" alt="" width="110" class="d-inline-block align-text-top me-4 ms-4">
                    <strong class="zakaz d-sm-none d-md-block d-none d-sm-block">ЗАКАЗ СПЕЦИАЛЬНОЙ ТЕХНИКИ<br><span class="fs-6">для АУ «СПК»</span></strong>
                  </a>
              <button class="navbar-toggler me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-lg-1"></ul>
              </div>
            </div>
          </nav>

    </header>

    <main>
        <div class="container contenta">
            
            <h2 class="mt-4 mb-4 d-flex justify-content-center"><? print $userdata['user_login']; ?>, техника добовляется</h2>
            
            <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            </div>
        </div>
    </main>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>   
</body>
</html>
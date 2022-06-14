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
        
    }
}
else
{
    header("Location: index.php");
}

// Добавление заявки

if(isset($_POST['send'])) {
    $spstarta = $_POST['spstarta'];  
    $spenda = $_POST['spenda'];
    $textzayvka = $_POST['textzayvka'];
    $phone = $_POST['phone'];
    $status_zayvka = $_POST['status_zayvka'];  
    $tex_zayvka = $_POST['tex_zayvka'];
    mysqli_query($link,"INSERT INTO zayvka SET sp_start='".$spstarta."', sp_end='".$spenda."', text_zayvka='".$textzayvka."', phone='".$phone."', userid='".$userdata['user_id']."', status_zayvka='Ожидание', tex_zayvka='Ожидание'");
    header("Location: load.php");
}
else
{

}

// Выход
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
            #zatemnenie {
            display: none;
            }
            #zatemnenie:target {display: block;}
            .zakaz {
              color: rgb(0,76,156);
            }
            .btn-primary {
              background-color: rgb(0,76,156);   
            }
            .btn-primary:hover {
              background-color: rgb(0,76,156); 
            }
            .close {
             color: rgb(0,76,156);
            }
            .table-primary {
                background-color: rgb(0,76,156);
            }
          </style>

          <nav class="navbar navbar-expand-lg bg-light container shadow rounded">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="user.php">
                    <img src="img/SPK.svg" alt="" width="110" class="d-inline-block align-text-top me-4 ms-4">
                    <strong class="zakaz d-sm-none d-md-block d-none d-sm-block">ЗАКАЗ СПЕЦИАЛЬНОЙ ТЕХНИКИ<br><span class="fs-6">для АУ «СПК»</span></strong>
                  </a>
              <button class="navbar-toggler me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-lg-1"></ul>
                <form class="d-flex justify-content-end" role="search" method="POST">
                  <h4 class="me-4 d-flex align-items-center"><? print $userdata['user_login']; ?></h4>
                  <button name="logout" class="btn btn-primary me-4" type="submit">Выход</button>
                </form>
              </div>
            </div>
          </nav>

    </header>

    <main>
        <div class="container">
            <h3 class="mt-4">Информация о пользователе</h3>
            <p class="mt-4">Юзернейм: <? print $userdata['user_login']; ?></p>
            <p>Почта: <? print $userdata['user_email']; ?></p>
            <form method="post">
            <div id="zatemnenie" class="mb-4">
                <div id="okno">
                <h3 class="mb-2">Оставить заявку</h3>
                <select name="spstarta" class="form-select mb-2 rounded" id="" width="300px">
                    <option selected>Укажите СП отправления</option>
                    <option value="1">СП1</option>
                    <option value="2">СП2</option>
                    <option value="3">СП3</option>
                    <option value="4">СП4</option>
                    <option value="5">СП5</option>
                </select>
                <select name="spenda" class="form-select mb-2 rounded" id="">
                    <option selected>Укажите СП назначения</option>
                    <option value="1">СП1</option>
                    <option value="2">СП2</option>
                    <option value="3">СП3</option>
                    <option value="4">СП4</option>
                    <option value="5">СП5</option>
                </select>     
                <input type="text" id="" name="textzayvka" class="form-control mb-2 rounded w-200" placeholder="Текст заявки" aria-label="" required/> 
                <input type="text" id="" name="phone" class="form-control mb-4 rounded" placeholder="Укажите номер телефона" aria-label="" required/> 
                <button class="btn btn-primary me-2" name="send" type="submit">Отправить</button>
                <a href="#" class="close text-decoration-none"><strong>Отмена</strong></a>
                </div>
            </div>
            </form>
            <button class="btn btn-primary" name="popup"><a href="#zatemnenie" class="text-light text-decoration-none">Оставить заявку</a></button>
            <h3 class="mt-4 mb-4">Мои заявки</h3>
            
            <?php
            $sql=mysqli_query($link, "SELECT * FROM `zayvka` WHERE userid='".$userdata['user_id']."'");
            while ($result=mysqli_fetch_array($sql))
            {
                echo '
                <table class="table mb-4 table-light table-bordered border-dark">
                <thead class="table-dark">
                <tr>
                <th class="col text-center align-middle">№</th>
                <th class="col-2 text-center align-middle">СП отправления</th>
                <th class="col-2 text-center align-middle">СП назначения</th>
                <th class="col-3 align-middle text-center">Текст заявки</th>
                <th class="col-2 text-center align-middle">Номер телефона</th>
                <th class="col-1 text-center align-middle">Статус</th>
                <th class="col-2 text-center align-middle">Техника</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <th class="col text-center align-middle"> '.$result['zayvka_id'].' </th>
                <th class="col-2 text-center align-middle"> '.$result['sp_start'].' </th>
                <th class="col-2 text-center align-middle"> '.$result['sp_end'].' </th>
                <th class="col-3 align-middle"> '.$result['text_zayvka'].' </th>
                <th class="col-2 text-center align-middle"> '.$result['phone'].' </th>
                <th class="col-1 text-center align-middle"> '.$result['status_zayvka'].' </th>
                <th class="col-2 text-center align-middle"> '.$result['tex_zayvka'].' </th>
                </tr>
                </tbody>
                </table>';
            }
                ?>  
        </div>
    </main>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>   
</body>
</html>
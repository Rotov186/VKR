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

//Добавление техники

if(isset($_POST['send'])) {
    $name_tex = $_POST['name_tex'];  
    $gosnomer = $_POST['gosnomer'];
    mysqli_query($link,"INSERT INTO tex SET name_tex='".$name_tex."', gosnomer='".$gosnomer."'");
    header("Location: load2.php");
}
else
{

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
            <h3 class="mt-4">Вы зашли как администратор</h3>
            <p class="mt-4"><strong>Юзернейм:</strong> <? print $userdata['user_login']; ?></p>
            <p><strong>Почта:</strong> <? print $userdata['user_email']; ?></p>
            <form method="post">
            <div id="zatemnenie" class="mb-4">
                <div id="okno">
                <h3 class="mb-4">Добавить технику</h3>  
                <input type="text" id="" name="name_tex" class="form-control mb-2 rounded w-200" placeholder="Наименование техники" aria-label="" required/> 
                <input type="text" id="" name="gosnomer" class="form-control mb-4 rounded" placeholder="Госномер" aria-label="" required/> 
                <button class="btn btn-primary me-2" name="send" type="submit">Добавить</button>
                <a href="#" class="close text-decoration-none"><strong>Отмена</strong></a>
                </div>
            </div>
            </form>
            <button class="btn btn-primary"><a href="#zatemnenie" class="text-light text-decoration-none">Добавить технику</a></button>                
            <h3 class="mt-4 mb-4">Заявки на рассмотрении</h3>

            <?php

            $sql=mysqli_query($link, "SELECT `users`.`user_id`,`user_login`, `zayvka`.* FROM `users` INNER JOIN `zayvka` ON `users`.`user_id` = `zayvka`.`userid` WHERE `status_zayvka` = 'Ожидание'");
            
            while ($result=mysqli_fetch_array($sql))
            {
                echo '
                <form method="post">
                <table class="table mb-4 table-light table-bordered border-dark">
                <thead class="table-dark">
                <tr>
                <th class="col text-center align-middle">№</th>
                <th class="col text-center align-middle">Пользователь</th>
                <th class="col text-center align-middle">СП отправления</th>
                <th class="col text-center align-middle">СП назначения</th>
                <th class="col-3 align-middle text-center">Текст заявки</th>
                <th class="col-2 text-center align-middle">Номер телефона</th>
                <th class="col-2 text-center align-middle">Статус</th>
                <th class="col-2 text-center align-middle">Техника</th>
                <th class="col text-center align-middle">Действие</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <th class="col text-center align-middle"> '.$result['zayvka_id'].' </th>
                <th class="col text-center align-middle"> '.$result['user_login'].' </th>
                <th class="col text-center align-middle"> '.$result['sp_start'].' </th>
                <th class="col text-center align-middle"> '.$result['sp_end'].' </th>
                <th class="col-3 align-middle"> '.$result['text_zayvka'].' </th>
                <th class="col-2 text-center align-middle"> '.$result['phone'].' </th>
                <th class="col-2 text-center align-middle"> 
                <select name="status_zayvka" class="form-select rounded" id=""">
                    <option selected>Выберите</option>
                    <option class="text-success" value="Одобрено">Одобрено</option>
                    <option class="text-warning" value="Ожидание">Ожидание</option>
                    <option class="text-danger" value="Отказано">Отказано</option>
                </select>
                </th>
                <th class="col-2 text-center align-middle">
                <select name="tex_zayvka" class="form-select rounded" id=""">
                    <option selected>-</option>';
                    $tex=mysqli_query($link, "SELECT * FROM `tex`");
                    while ($resultat=mysqli_fetch_array($tex))
                    {
                        echo '
                            <option value="'.$resultat['name_tex'].'">'.$resultat['name_tex'].'</option>
                        ';
                    }
                echo ' 
                </select>
                </th>
                <th class="col text-center align-middle"><button name="apply'.$result['zayvka_id'].'" class="btn btn-dark">>
                ';
                // Одобряем заявку, присваеваем технику
                if(isset($_POST['apply'.$result['zayvka_id'].''])) {
                $status_zayvka = $_POST['status_zayvka'];  
                $tex_zayvka = $_POST['tex_zayvka'];
                mysqli_query($link,"UPDATE zayvka SET status_zayvka='".$status_zayvka."', tex_zayvka='".$tex_zayvka."' WHERE zayvka_id='".$result['zayvka_id']."'");
                }
                else
                {
                    
                }    
                echo '
                </button></th>
                </tr>
                </tbody>
                </table>
                </form>';
            }
            
        
                ?>  
        </div>
    </main>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>   
</body>
</html>
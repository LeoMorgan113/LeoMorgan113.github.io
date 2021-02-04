<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LuXDecor</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif:wght@400;700&family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">

    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
    <link rel="stylesheet" href="../css/modal.css">
    <link rel="stylesheet" href="../css/header.css">

    <link rel="stylesheet" href="../css/admin.css">
    <script>
        function showForm(show, hide) {
            document.getElementById(show).style.display = "block";
            document.getElementById(hide).style.display = "none";
        }

    </script>


</head>
<body>
<div class="backToMain">
    <a href="../index.php">
        <img src="../img/logo.png" alt="logo">
    </a>

</div>
<?php

require_once "password.php";
require_once "connection.php";
header('Content-Type: text/html; charset=utf-8');

$link = mysqli_connect($host,  $user, $password, $database, $port);
if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

mysqli_set_charset($link, "utf8");
?>



<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <h2 class="tableHeader">
                    <img src="../img/curt.png" alt="curtain" class="curtain_orange animate__animated">
                    Зв'язатися зі мною
                    <img src="../img/curt.png" alt="curtain" class="curtain_orange animate__animated">
                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-12">

            <?php
            header('Content-Type: text/html; charset=utf-8');
            $query ="SELECT * FROM form1";
            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
            $rows = mysqli_num_rows($result); // количество полученных строк
            $output = '';

            if($rows)
            {
                $output .= '
                <table class="table" bordered = "1">
                        <tr class="row main_head col-12 ">

                            <td class="d-none d-md-block col-md-3 " >Ім\'я</td>
                            <td class="d-none d-md-block col-md-3">Моб. телефон</td>
                            <td class="d-none d-md-block col-md-4">Додано</td>
                            <td class="d-none d-md-block col-md-2">Видалити</td>
                        </tr>
                ';


                for ($i = 0 ; $i < $rows ; ++$i)
                {
                    $row = mysqli_fetch_row($result);

                    $output .= '
                    <tr class="col-12 rowTable row">
                        <td class="col-6 col-md-3"><strong class="d-md-none">Ім\'я:   </strong>'.$row[2].'</td>
                        <td class="col-6 col-md-3"><strong class="d-md-none">Телефон:   </strong>'.$row[1].'</td>
                        <td class="col-12 col-md-4"><strong class="d-md-none">Додано:   </strong>'.$row[3]. '</td>
                        <td class="col-12 col-md-2">
                        <form action="delete.php" method="post">
                            <input style="display: none" name="id" value='.$row[0].' >
                            <input style="display: none" name="form_name" value="form1">
                            <button class="btn delete">Видалити</button>
                        </form>
                        </td>
                    </tr>
                    ';
                }

                $output .= '</table>';
                echo $output;
                // очищаем результат
                mysqli_free_result($result);
            }else{
                echo '<h6>Записів немає</h6>';
            }
            ?>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <h2 class="tableHeader">
                    <img src="../img/curt.png" alt="curtain" class="curtain_orange animate__animated">
                    Замовити проєкт
                    <img src="../img/curt.png" alt="curtain" class="curtain_orange animate__animated">
                </div>
            </div>

        <div class="row">
            <div class="col-lg-12 col-12">

                <?php
                $query ="SELECT * FROM form2";
                $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                $rows = mysqli_num_rows($result); // количество полученных строк
                $output = '';
                if($rows)
                {
                    $output .= '
                <table class="table" bordered = "1">
                        <tr class="row main_head col-12 ">

                            <td class="d-none d-md-block col-md-3 " >Ім\'я</td>
                            <td class="d-none d-md-block col-md-3">Моб. телефон</td>
                            <td class="d-none d-md-block col-md-4">Додано</td>
                            <td class="d-none d-md-block col-md-2">Видалити</td>
                        </tr>
                ';


                    for ($i = 0 ; $i < $rows ; ++$i)
                    {
                        $row = mysqli_fetch_row($result);

                        $output .= '
                    <tr class="col-12 rowTable row">
                        <td class="col-6 col-md-3"><strong class="d-md-none">Ім\'я:   </strong>'.$row[2].'</td>
                        <td class="col-6 col-md-3"><strong class="d-md-none">Телефон:   </strong>'.$row[1].'</td>
                        <td class="col-12 col-md-4"><strong class="d-md-none">Додано:   </strong>'.$row[3]. '</td>
                        <td class="col-12 col-md-2">
                        <form action="delete.php" method="post">
                            <input style="display: none" name="id" value='.$row[0].' >
                            <input style="display: none" name="form_name" value="form2">
                            <button class="btn delete">Видалити</button>
                        </form>
                        </td>
                    </tr>
                    ';
                    }

                    $output .= '</table>';
                    echo $output;
                    // очищаем результат
                    mysqli_free_result($result);
                }else{
                    echo '<h6>Записів немає</h6>';
                }

                if(!$rights) {
                    mysqli_close($link);
                };?>
                </table>
            </div>
        </div>
    </div>
</section>

<section>
        <?php

        if($rights){

            echo '
               
                 <div class="container">
                 <div class="row justify-content-center">
                 <button onclick="showForm(\'addAdmin\', \'btnAddAdmin\')" class="btn col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5" id="btnAddAdmin">Додати адміністратора</button>

                <form id="addAdmin" action="newAdmin.php" method="post" class="form col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 "">
                <p>
                Для того, щоб додати нового адміністратора, необхідно заповнити форму нижче.
                Необхідно вигадати унікальний логін. Не може бути 2 адміністратора з однаковим логіном. А також додати пароль.
                </p>
                    <input type="text" name="name" placeholder="Login" required><br>
                    <input type="password" name="pass" placeholder="Password" required><br>
                
                    <p class="align-items-center"><input type="checkbox" name="rights" value="1">Надати адміністратору повні права?</p>
                    <button class="btn">Додати адміністратора</button>
                </form>
                </div>
                </div>
     ';


            echo' 
             <div class="container">
             <div class="row justify-content-center">
                <button onclick="showForm(\'showAdmins\', \'btnShowAdmins\')" class="btn col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5" id="btnShowAdmins">Переглянути список адміністраторів</button>
             </div>
             <div id = "showAdmins">
        
                   <div class="row">
                        <div class="col-lg-12 col-12">
                            <h2 class="tableHeader">
                                <img src="../img/curt.png" alt="curtain" class="curtain_orange animate__animated">
                                Адміністратори
                                <img src="../img/curt.png" alt="curtain" class="curtain_orange animate__animated">
                            </h2>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12 col-12">
';

                            $sql = "SELECT * FROM admins";

                            $data = mysqli_query($link, $sql);
                            echo '<h3>Я,'.$_SERVER['PHP_AUTH_USER'].' </h3>';
                            echo '<h3>Власник - Ludmila</h3>';

                            $query ="SELECT * FROM admins";
                            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                            $rows = mysqli_num_rows($result); // количество полученных строк
                            $output = '';
                            if($rows)
                            {
                                $output .= '
                                <table class="table" bordered = "1">
                                        <tr class="row main_head col-12">
                                            <td class="d-none d-md-block col-md-4 " >Ім\'я</td>
                                            <td class="d-none d-md-block col-md-4">Права</td>
                                            <td class="d-none d-md-block col-md-2">Змінити</td>
                                            <td class="d-none d-md-block col-md-2">Видалити</td>
                                        </tr>
                                     
                                ';


                                for ($i = 0 ; $i < $rows ; ++$i)
                                {
                                    $row = mysqli_fetch_row($result);
                                    if($row[1] == $_SERVER['PHP_AUTH_USER'] || $row[1] == 'Ludmila'){
                                        continue;
                                    }

                                    $output .= '
                                    <tr class="col-12 row">
                                        <td class="col-6 col-md-4"><strong class="d-md-none">Ім\'я:   </strong>'.$row[1].'</td>
                                        <td class="col-6 col-md-4"><strong class="d-md-none">Права:   </strong>';
                                    if($row[3]){
                                        $output .= 'Супер адміністратор';
                                    }else{
                                        $output .= 'Звичайний адміністратор';
                                    }
                                    $output .='</td>
                                        <td class="col-6 col-md-2">
                                        <form action="changeRights.php" method="post">
                                            <input style="display: none" name="id" value=' .$row[0].' >
                                            <input style="display: none" name="form_name" value="admins">
                                            <input style="display: none" name="rights" value='.$row[3].'>
                                            <button class="btn">Змінити</button>
                                        </form>
                                        </td>';

                                    $output .= '<td class="col-6 col-md-2">
                                        <form action="delete.php" method="post">
                                            <input style="display: none" name="id" value=' .$row[0].' >
                                            <input style="display: none" name="form_name" value="admins">
                                            <button class="btn">Видалити</button>
                                        </form>
                                        </td>
                                    </tr>
                                    ';
                                }

                                $output .= '</table>';
                                echo $output;
                                // очищаем результат
                                mysqli_free_result($result);
                            }else{
                                echo '<h6>Записів немає</h6>';
                            }
                             mysqli_close($link);

        }
        echo '</div></div></div></div>';


        ?>
    <div class="container">
        <div class="row justify-content-center">
            <button onclick="showForm('changePassword', 'btnChangePassword')" class="btn col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5" id="btnChangePassword">Змінити пароль</button>
        <form action="change.php" method="post" id = "changePassword" class="form col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 ">

            <p>
                Для того, щоб змінити пароль, спершу введіть ваш попередній, а далі - вигадайте новий.
            </p>
            <input type="password" name="previous" placeholder="Old password" required><br>
            <input type="password" name="new1" placeholder="New password" required><br>
            <input value="<?=$_SERVER['PHP_AUTH_USER']?>" name="auth" style="display: none">
            <input value="<?=md5($_SERVER['PHP_AUTH_PW'].'kjhsdfgdlkhf')?>" name="pwd" style="display: none">
            <button class="btn">Змінити пароль</button>
        </form>
        </div>
    </div>
</section>

</body>
</html>


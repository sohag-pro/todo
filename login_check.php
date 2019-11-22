<?php
session_start();

if(isset($_POST['token']) && $_POST['token'] === $_SESSION["token"] && $_SESSION["token_used"] === false){
    $_SESSION["token_used"] = true;
    echo $_POST['token'] . '<br>';
    echo $_POST['user'] . '<br>';
    echo $_POST['pass'] . '<br>';
    //login function here
    if($_POST['user'] === 'shuvo' && $_POST['pass'] === '123'){
        $_SESSION['logged'] = true;
        header('location: index.php');
    }

}else{
    echo 'Please try again after reloading the login page';
}


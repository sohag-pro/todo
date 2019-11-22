<?php
session_start();
$first_number = rand(4, 23);
$second_number = rand(4, 23);
$sum = $first_number + $second_number;
$token = time() . '-' . $first_number . '-' . $second_number . '-' . $sum;
$_SESSION["token"] = $token;
$_SESSION["token_used"] = false;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | Todo</title>
    <style>
        body {
            text-align: center;
            padding: 20px;
            font-family: cursive;
            height: 90vh;
        }

        input {
            width: 300px;
            border: none;
            border-bottom: 1px solid black;
            line-height: 10px;
            padding: 10px;
            outline: none;
        }

        div {
            border: 1px solid black;
            padding: 20px;
            width: 400px;
            border-radius: 10px;
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        input[type="submit"] {
            background-color: transparent;
            width: 150px;
            border: 1px solid black;
            cursor: pointer;
            transition: all linear 400ms;
        }

        input[type="submit"]:hover {
            background-color: black;
            color: white;
        }

        #err {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Todo</h1>
    <div>
        <h3>-Login-</h3>
        <form action="login_check.php" method="post" onsubmit="return check()">
            <input type="text" name="user" id="" placeholder="username"><br><br>
            <input type="password" name="pass" id="" placeholder="password"><br><br>
            <p>What is <?= $first_number ?> + <?= $second_number ?></p>
            <p id="err"></p>
            <input type="number" name="sum" id="sum" placeholder="Result"><br><br>
            <input type="hidden" name="token" value="<?= $token ?>">
            <input type="submit" value="Login">
        </form>
    </div>
    <script>
        function check() {

            let sum = document.getElementById('sum').value;
            if (sum == "") {
                document.getElementById('err').innerHTML = 'Please enter the Result!';
                return false;
            } else if (parseInt(sum) !== parseInt(<?= $sum ?>)) {
                document.getElementById('err').innerHTML = 'Please enter the Result Correctly!';
                return false;
            }
        }
    </script>
</body>

</html>
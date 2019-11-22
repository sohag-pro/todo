<?php session_start();

if ($_SESSION['logged'] != true) {
    header('location: login.php');
}

require_once 'config.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo</title>
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
            padding: 0px;
            width: 400px;
            border-radius: 10px;
            margin: 10px auto;
            overflow: hidden;
            transition: all ease 500ms;

        }

        h3 {
            margin: 0;
            background-color: #000;
            color: #fff;
            border-radius: 8px 8px 0 0;
            padding-bottom: 5px;
        }

        input[type="submit"] {
            background-color: transparent;
            width: 150px;
            border: 1px solid black;
            cursor: pointer;
            transition: all linear 400ms;
            margin-bottom: 10px;
            border-radius: 10px;
        }

        input[type="submit"]:hover {
            background-color: black;
            color: white;
        }

        #err {
            color: red;
        }

        ul,
        li {
            list-style-type: none;
            text-align: center;
            margin: 0px;
            padding: 0px;
            transition: all ease 500ms;
        }

        li:last-child:hover {
            border-radius: 0 0 8px 8px;
        }

        .item {
            float: left;
        }

        li {
            text-align: left;
            padding: 5px 15px;
        }

        li:hover {
            background-color: #000;
            color: #fff;
        }

        .button {
            cursor: pointer;
            width: 30px;
            height: 30px;
            border: 1px solid black;
            border-radius: 50%;
            background-color: #000;
            color: #fff;
            transition: all ease 500ms;
            outline: none;
        }

        .delete {
            cursor: pointer;
            width: 30px;
            height: 30px;
            border: 1px solid red;
            border-radius: 50%;
            background-color: red;
            color: #000;
            transition: all ease 500ms;
            outline: none;
            margin-left: 10px;
        }

        li:hover .button {
            background-color: #fff;
            border-color: #fff;
            color: #000;
        }

        li:hover .delete {
            background-color: #fff;
            border-color: #fff;
            color: red;
        }

        .done span {
            text-decoration: line-through;
        }

        #delete-info {
            display: none;
        }

        a {
            text-decoration: none;
            margin: 0px 0px;
            color: black;
            padding: 5px 30px;
            background-color: black;
            transition: all ease 500ms;
        }

        a:hover{
            color: white;
        }
    </style>
</head>

<body>
    <h1>Todo</h1>
    <div>

        <ul id="havetodo">
            <?php

            $sql = "SELECT * FROM todos ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <li><?=$count ?>. <span><?= $row["todo"] ?></span></li>
            <?php
            $count++;
                }
            } else {
                echo '<li id="remove-have" style="text-align:center;"><span>Yes!! Nothing To Do!!!</span></li>';
            }



            ?>
        </ul>
    </div>
    <div style="text-align:center;">
        <a style="float:left;" href="logout.php">Log Out</a>
        <span style="float:left; margin:0; padding:0px 50px; line-height:32px;">Shuvo</span>
        <a style="float:right;" href="index.php">New Todo</a>
    </div>
    <script src="jquery-1.12.4.min.js"></script>
    
</body>

</html>
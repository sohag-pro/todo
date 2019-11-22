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
            text-align: right;
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

        a:hover {
            color: white;
        }
    </style>
</head>

<body>
    <h1>Todo</h1>
    <div>
        <h3>-Have to Do-</h3>

        <ul id="havetodo">
            <?php

            $sql = "SELECT * FROM todos WHERE done=0 AND status=0 ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <li><span class="item"><?= $count ?>. <?= $row["todo"] ?></span> <button id="<?= $row["id"] ?>" class="button">&#10004;</button></li>
            <?php
                    $count++;
                }
            } else {
                echo '<li id="remove-have" style="text-align:center;"><span>Yes!! Nothing To Do!!!</span></li>';
            }



            ?>
        </ul>
    </div>
    <div>
        <form id="form">
            <span id="err"></span>
            <input type="text" id="new" placeholder="What to Do?"><br><br>
            <input type="submit" id="add" value="&#10010;">
        </form>
    </div>
    <div>
        <h3>-Done Already-</h3>

        <ul id="donetodo">
            <?php

            $sql = "SELECT * FROM todos WHERE done=1 AND status=0 ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <li class="done"><span class="item"><?= $row["todo"] ?></span> <button id="<?= $row["id"] ?>" class="button">&#10008;</button><button id="<?= $row["id"] ?>" class="delete">&#9986;</button></li>
            <?php
                }
            } else {
                echo '<li id="remove_done" style="text-align:center;"><span>Oh No! Nothing Done Yet!!</span></li>';
            }
            $conn->close();


            ?>
        </ul>
        <p id="delete-info"></p>
    </div>
    <div style="text-align:center;">
        <a style="float:left;" href="logout.php">Log Out</a>
        <span style="float:left; margin:0; padding:0px 59px; line-height:32px;">Shuvo</span>
        <a style="float:right;" href="all.php">Archive</a>
    </div>
    <script src="jquery-1.12.4.min.js"></script>
    <script>
        $(document).ready(function() {
            //add todo
            $("#form").submit(function(event) {
                event.preventDefault();
                var newtodo = $('#new').val();
                var dataString = 'new=' + newtodo + '&form=newTodo';
                if (newtodo == "") {
                    $("#err").fadeIn(300).html("At First Write something to add!!").fadeOut(3000);
                } else {
                    $.ajax({
                        type: "POST",
                        url: "todo.php",
                        data: dataString,
                        cache: false,
                        success: function(html) {
                            $("#havetodo").prepend(html);
                        }
                    });

                    $('#new').val('');
                    $('#remove-have').remove();

                }
            });

            //Done Todo
            $(document).on('click', '#havetodo .button', function() {
                let id = event.target.id;
                var dataString = 'id=' + id + '&form=donetodo';
                if (id != '') {
                    $.ajax({
                        type: "POST",
                        url: "todo.php",
                        data: dataString,
                        cache: false,
                        success: function(html) {
                            $("#donetodo").prepend(html);
                        }
                    });
                    $(this).parent().remove();
                    $('#remove_done').remove();
                }
            });
            //UnDone Todo
            $(document).on('click', '#donetodo .button', function() {
                let id = event.target.id;
                var dataString = 'id=' + id + '&form=havetodo';
                if (id != '') {
                    $.ajax({
                        type: "POST",
                        url: "todo.php",
                        data: dataString,
                        cache: false,
                        success: function(html) {
                            $("#havetodo").prepend(html);
                        }
                    });
                    $(this).parent().remove();
                    $('#remove-have').remove();
                }
            });

            //delete Todo
            $(document).on('click', '#donetodo .delete', function() {
                let id = event.target.id;
                var dataString = 'id=' + id + '&form=deletetodo';
                if (id != '') {
                    $.ajax({
                        type: "POST",
                        url: "todo.php",
                        data: dataString,
                        cache: false,
                        success: function(html) {
                            $("#delete-info").fadeIn(300).html(html).fadeOut(3000);
                        }
                    });

                    $(this).parent().remove();
                }
            });

            // //move todo
            // $('#havetodo').on('click', '.doneitem', function() {
            //     $('#donetodo').prepend($(this).closest('li').addClass('done'));
            // });

        });
    </script>
</body>

</html>
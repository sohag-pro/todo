<?php
require_once 'config.php';

//add new todo
if (isset($_POST['form']) && $_POST['form'] == 'newTodo') {
    $todo = $_POST['new'];
    $sql = "INSERT INTO todos (todo) VALUES ('$todo')";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        echo '<li><span class="item">' . $todo . '</span> <button id="' . $last_id . '" class="button">&#10004;</button></li>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

//change status to done todo
if (isset($_POST['form']) && $_POST['form'] == 'donetodo') {
    $id = $_POST['id'];
    $sql = "UPDATE todos SET done=1 WHERE id=$id";

    if ($conn->query($sql) === TRUE) {

        $sql = "SELECT todo FROM todos WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo '<li class="done"><span class="item">' . $row['todo'] . '</span> <button id="' . $id . '" class="button">&#10008;</button><button id="' . $id . '" class="delete">&#9986;</button></li>';
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}

//change status to have to do todo
if (isset($_POST['form']) && $_POST['form'] == 'havetodo') {
    $id = $_POST['id'];
    $sql = "UPDATE todos SET done=0 WHERE id=$id";

    if ($conn->query($sql) === TRUE) {

        $sql = "SELECT todo FROM todos WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo '<li><span class="item">' . $row['todo'] . '</span> <button id="' . $id . '" class="button">&#10004;</button></li>';
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}

if (isset($_POST['form']) && $_POST['form'] == 'deletetodo') {
    $id = $_POST['id'];
    $sql = "UPDATE todos SET status=1 WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo 'Deleted Successfully!';
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}

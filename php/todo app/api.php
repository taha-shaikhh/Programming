<?php
include 'cred.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST["action"] === "delete") {
        $id = $_POST["id"];
        $sql = "DELETE FROM todos WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            echo "Todo deleted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        $title = $_POST["title"];
        $sql = "INSERT INTO todos (title) VALUES ('$title')";

        if (mysqli_query($conn, $sql)) {
            echo "Todo added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $sql = "SELECT * FROM todos";
    $result = mysqli_query($conn, $sql);
    $todos = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $todos[] = $row;
        }
    }

    echo json_encode($todos);
}

mysqli_close($conn);
?>

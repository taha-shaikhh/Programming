<?php
$host = "localhost";
$username = "root";
$password = "root";
$database = "todo_app";


$conn = mysqli_connect($host, $username, $password, $database);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$id = $_GET["id"];
$query = "SELECT title FROM todos WHERE id = $id";
$result = mysqli_query($conn, $query);

$data = mysqli_fetch_assoc($result);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Todo App</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Todo </h1>
        <div class="form-group">
                <textarea class="form-control" id="titleInput" rows="3" placeholder="<?php echo $data["title"] ?>" disabled ></textarea>
            </div>
    </div>
</body>
</html>
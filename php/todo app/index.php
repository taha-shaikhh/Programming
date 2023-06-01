<!DOCTYPE html>
<html>
<head>
    <title>Todo App</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Todo App</h1>

        <form id="todoForm" class="text-center">
            <div class="form-group">
                <textarea class="form-control" id="titleInput" rows="3" placeholder="Enter todo title....."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Todo</button>
        </form>

        <h2>Todo List</h2>
        <ul id="todoList" class="list-group"></ul>
    </div>

    <script>

        $(document).ready(function() {
            fetchTodos();
        });

        $("#todoForm").submit(function(event) {
            event.preventDefault();
            var title = $("#titleInput").val();
            addTodo(title);
            $("#titleInput").val("");
        });

        function fetchTodos() {
            $.ajax({
                url: "api.php",
                type: "GET",
                success: function(response) {
                    renderTodos(JSON.parse(response));
                }
            });
        }

        function renderTodos(todos) {
            $("#todoList").empty();
            todos.forEach(function(todo) {
                var listItem = $("<li>").addClass("list-group-item").text(todo.title);
                var deleteBtn = $("<button>").addClass("btn btn-danger btn-sm float-right delete-btn").text("Delete");
                var viewBtn = $("<button>").addClass("btn btn-success btn-sm float-right delete-btn").text("View");
                listItem.append(deleteBtn);
                listItem.append(viewBtn);
                $("#todoList").append(listItem);

                viewBtn.click(function() {
                    //viewTodo(todo.id);
                    //$(location).prop('href', 'http://localhost/'.concat(todo.id))
                    window.location.href = "todo.php?id=".concat(todo.id)
                })

                deleteBtn.click(function() {
                    deleteTodo(todo.id);
                });
            });
        }

        function addTodo(title) {
            $.ajax({
                url: "api.php",
                type: "POST",
                data: { title: title },
                success: function(response) {
                    fetchTodos();
                }
            });
        }

   
        function deleteTodo(id) {
            $.ajax({
                url: "api.php",
                type: "POST",
                data: { id: id, action: "delete" },
                success: function(response) {
                    fetchTodos();
                }
            });
        }
    </script>
</body>
</html>

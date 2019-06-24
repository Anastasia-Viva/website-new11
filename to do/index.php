<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tasks</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">


</head>
<body>
    <div class="container">
        
        <h1>tasks schedule</h1>
        <form action="add.php" method="post">
            <input type="text" name="task" id="task" placeholder="must be done" class="form-control">
            <button type="submit" name="sendTask" class="btn btn-success">Send</button>
            
        </form>

        <?php
        require 'configDB.php';

        echo '<ul>';
        $query = $conn->query("SELECT * FROM `tasks`.taskstodo ORDER BY 'id' DESC");
        while ($row = $query->fetch(PDO::FETCH_OBJ)){
            echo '<li> <b>' . $row->taskNew . '</b><a href="delete.php?id='.$row->id.'"><button>DELETE</button></a> </li>';
        };

        echo '</ul>';
        ?>


    </div>


</body>
</html>

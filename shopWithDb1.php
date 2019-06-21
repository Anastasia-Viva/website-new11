<?php
session_start();


$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "adv";

try {
    $conn = new PDO("mysql:host=localhost;dbname=adv", "root");
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
};


$shopAllData = $conn->query('SELECT * FROM shop');
$shopAllData = $shopAllData->fetchAll();


/*CAPTCHA*/

//$conn->formAddCaptcha("captcha");

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-----------add*/


if (isset($_POST['newAdv'])) {

   $sql = "INSERT INTO shop (title, content, phone, author) VALUES (?,?,?,?)";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(1, $_POST['title']);
    $stmt->bindParam(2, $_POST['content']);
    $stmt->bindParam(3, $_POST['phone']);
    $stmt->bindParam(4, $_POST['author']);

    //$stmt->execute();


    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    };


};

/*delete------------------------------------------------------------------------------------------*/


/*$conn = new PDO("mysql:host=localhost;dbname=adv", "root");

//Deleting a row using a prepared statement.
$sql = "DELETE FROM `shop` WHERE `id` = :id";

//Prepare our DELETE statement.
$statement = $conn->prepare($sql);

//The make that we want to delete from our adv table.
$makeToDelete = ':id';

//Bind our $makeToDelete variable to the paramater :make.
$statement->bindValue(':id', $makeToDelete);

//Execute our DELETE statement.
$delete = $statement->execute();*/


/*second version delete--------------------------------------------------------------------------*/

if (isset($_GET['id'])){

    $sql = "DELETE FROM `shop` WHERE `id` = :id";
    $statement = $conn->prepare($sql);
    $makeToDelete = $_GET['id'];
    $statement->bindValue(':id', $makeToDelete, PDO::PARAM_INT);
    $delete = $statement->execute();

};

//var_dump($makeToDelete);

/*third version delete--------------------------------------------------------------------*/

//getting id of the data from url

/*$id = $_GET['id'];

//deleting the row from table
$sql = "DELETE FROM shop WHERE id=:id";
$query = $conn->prepare($sql);
$query->execute(array(':id' => $id));*/






/*search--------------------------------------------------------------------------------------------*/
/*$search = [];

foreach($query as $question) {
    $search[] = "'%".trim($question)."%'";
}

$sql = "SELECT * FROM shop";

if (!empty($search)) {
    $sql .= " WHERE title '' "
        .array_shift($search) // remove first element from array
        .implode(" OR title LIKE ", $likes); // implode rests with 'OR'
}

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);*/



/*edit---------------------------------------------------------------------------*/


//getting id from url



if (isset($_GET['id']) && $_GET['id'] == 'edit') {

$id = $_GET['id'];

//selecting data associated with this particular id

$sql = "SELECT * FROM shop WHERE id=:id";
$query = $conn->prepare($sql);
$query->execute(array(':id' => $id));

while($row = $query->fetch(PDO::FETCH_ASSOC))
{
    $title = $_GET['title'];
    $content = $_GET['content'];
    $phone = $_GET['phone'];
    $author = $_GET['author'];
}
};

var_dump($_GET);

/*update------------------------------------------------------------------------------------------*/
/*$sql = "UPDATE shop SET title=?, content=?, phone=?, author=? WHERE id=?";
$stmt= $conn->prepare($sql);
$stmt->execute([$title, $content, $phone, $author, $id]);*/

/*update-----------------------------------------------------------------------------*/

/*$sql = "UPDATE shop SET title=?, content=?, phone=?,author=? WHERE id=?";
$conn->prepare($sql)->execute([$title, $content, $phone, $author, $id]);*/


/*update data with named placeholder-----------------------------------------------------------------------------*/

if ($_POST['action'] == "update" &&  isset($_POST['id'])){

    $data = [
        'title' => $title,
        'content' => $content,
        'phone' => $phone,
        'author' => $author,
        'id' => $id,
    ];
    $sql = "UPDATE shop SET title=:title, content=:content, phone=:phone, author=:author WHERE id=:id";
    $stmt= $conn->prepare($sql);
    $stmt->execute($data);
};




/*alternative execution*/

/*$sql = "UPDATE shop SET title=:title, content=:content, phone=:phone, author=:author WHERE id=:id";
$conn->prepare($sql)->execute($data);*/

/*update-----------------------------------------------------------------------------*/

?>


<html lang="en">
<!doctype html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contacts</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<br>
<div class="container">
    <div class="row">


        <!--add new advertisement-->
        <form action="shopWithDb1.php" method="post" style="position: center">
            <div class="form-group">
                <label for="">Title</label>
                <input type="text" class="form-control" placeholder="your ad title" name="title">
            </div>

            <div class="form-group">
                <label for="">Content</label>
                <input type="text" class="form-control" placeholder="your content" name="content">
            </div>

            <div class="form-group">
                <label for="">Contact number</label>
                <input type="text" class="form-control" placeholder="your contact number" name="phone">
            </div>

            <div class="form-group">
                <label for="">Author</label>
                <input type="text" class="form-control" placeholder="Author" name="author">
            </div>


            <input type="submit" name="newAdv" class="btn btn-success" value="Add advertisement">


        </form>
        <br> <br>

        <!--Search advertisement-->

      <!--  <?php
/*        var_dump($_GET['search']);

        $query = explode(",", $_GET['search']);
        var_dump($query);
        $searchQuery = array();

        foreach($query as $question) {
            $question = trim($question);
            $question = "%".$question."%";
            $searchQuery[] = $question;
        }

        echo "<pre>";
        var_dump($searchQuery);
        echo "</pre>";

        $searchQuery = implode(' AND title LIKE ', $searchQuery);

        echo "<pre>";
        var_dump($searchQuery);
        echo "</pre>";

        $sql = "SELECT * FROM shop WHERE title LIKE :search";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':search', $searchQuery);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<pre>";
        var_dump($result);
        echo "</pre>";

        $count = $stmt->rowCount();
        */?>

        <ul>
            <?/*
            if($count == 0) {
                echo "..............";
            } else {
                foreach ($result as $product) {
                    echo "<li>";
                    echo $product['title'].", ".$product['author'].":-";
                    echo "</li>";
                }
            }

            */?>
        </ul>-->


        <form action="shopWithDb1.php" method="get" style="margin-left: 30px ; margin-top: 50px">

            <div class="form-group">
                <label for="" style="margin-top: 30px"></label>
                <input type="text" class="form-control" placeholder="search by title" name="search">
            </div>
            <input type="submit" name="searchRes" class="btn btn-success" value="Search ad title"
                   style="margin-left: 30px">
        </form>
        <br> <br>


        <!--edit advertisement -->


        <form action="shopWithDb1.php" method="post" style="margin-left: 30px">
            <div class="form-group">
                <label for="">Edit</label>
                <input type="text" class="form-control" placeholder="edit title" name="title" value="">
            </div>


            <div class="form-group">
                <label for="">Content</label>
                <input type="text" class="form-control" placeholder="edit content" name="content" value="">
            </div>

            <div class="form-group">
                <label for="">Contact number</label>
                <input type="text" class="form-control" placeholder="edit contact number" name="phone" value="">
            </div>

            <div class="form-group">
                <label for="">Author</label>
                <input type="text" class="form-control" placeholder="edit author" name="author" value="">
            </div>


            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?= $_GET['id']?>">
            <input type="submit" name="" class="btn btn-success" value="Edit advertisement">


        </form>
        <br> <br>


    </div>
    <br>
    <!— <a href="shopWithDb1.php">Add New Advertisement</a><br/><br/> —>
    <div class="row">
        <table class="table table-striped table-hover table-sm">
            <thead>
            <tr class="table-info">
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col">Contact number</th>
                <th scope="col">Author</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($shopAllData as $shopAll) { ?>

                <tr>
                    <th scope="row"></th>

                    <td><?= $shopAll['title'] ?></td>
                    <td><?= $shopAll['content'] ?></td>
                    <td><?= $shopAll['phone'] ?></td>
                    <td><?= $shopAll['author'] ?></td>
                    <td>
                        <a href="?id=<?= $shopAll['id'] ?>&action=edit">Edit</a> |
                        <a href="?id=<?= $shopAll['id'] ?>&action=delete"> Delete</a>|

                    </td>
                </tr>
            <?php } ?>



            </tbody>
        </table>

    </div>
</div>
</body>
</html>

<?php

function connectDb()
{
    $servername = "mysql";
    $username = "groot";
    $password = "groot";
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=baseone", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

    return $conn;
}
    
$conn = connectDb();

if (isset($_POST["submit_file"])) {
    $file = $_FILES["file"]["tmp_name"];
    $file_open = fopen($file,"r");
    while (($csv = fgetcsv($file_open, 1000, ",")) !== false) {
        $id = $csv[0];
        $name = $csv[1];
        $stmt = $conn->prepare("INSERT INTO tableone (id, name) VALUES (:id, :name)");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
    }
}
?>

<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>Index</title>
    </head>
    <body>
        <div class="container">
            <form method="post" action="index.php" enctype="multipart/form-data">
                <input type="file" name="file"/>
                <input type="submit" name="submit_file" value="Submit"/>
            </form>
        </div>
        <div class="container">
            <table class="table table-bordered" style="text-align: center">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">NAME</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data = $conn->query("SELECT * FROM tableone")->fetchAll();
                foreach ($data as $row) {
                    echo "<tr>";
                    echo "<th scope='row'>" . $row['id']. "</th>";
                    echo "<td>" . $row['name']. "</td>";
                    echo "<tr>";
                }?>
            </tbody>
        </div>
    </body>
</html>
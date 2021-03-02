<?php

$servername = "";
$username = "groot";
$password = "groot";

try {
    $conn = new PDO("mysql:host=$servername;dbname=baseone", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo $e->getMessage();
}

// $stmt = $conn->prepare('INSERT INTO tableone (id, name) VALUES(:id, :name)');
//     $stmt->bindParam(':id', $id);
//     $stmt->bindParam(':name', $name);
//     $stmt->execute();

if (isset($_FILES['uploadedfile'])) {

    // get the csv file and open it up
    $file = $_FILES['uploadedfile']['tmp_name'];
    $handle = fopen($file, "r");
    try {
        // prepare for insertion
        $query_ip = $db->prepare('');

        // unset the first line like this
        fgets($handle);

        // created loop here
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $query_ip->execute($data);
        }

        fclose($handle);

    } catch(PDOException $e) {
        die($e->getMessage());
    }

    echo 'Foi';

} else {
    echo 'Não foi';
}

?>

<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>Index</title>
    </head>
    <body>
        <div class="container">
            <form enctype="multipart/form-data" method="POST" action="index.php">
                <div class="form-group">
                    <input name="userfile" type="file">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-2">Submit</button>
                </div>
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
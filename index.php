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
    $tablename = $_POST["tablename"];
    $file_open = fopen($file,"r");

    $stmt = $conn->prepare("TRUNCATE TABLE $tablename;");
    $stmt->execute();

    while (($csv = fgetcsv($file_open, 1000, ",")) !== false) {
        $id = $csv[0];
        $name = $csv[1];
        $stmt = $conn->prepare("INSERT INTO $tablename (id, name) VALUES (:id, :name)");
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
        <div class="container pt-3">
            <div class="row">
                <form method="post" action="index.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Selecione a base de dados:</label>
                        <select name="tablename"  class="form-control" id="exampleFormControlSelect1">
                            <option value="tableone">tableone</option>
                            <option value="tabletwo">tabletwo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Envie seu csv:</label>
                        <input type="file" name="file"/>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit_file" value="Submit"/>
                    </div>
                </form>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <h3>Tabela 1</h3>
                <table class="table table-bordered" style="text-align: center">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NAME</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = $conn->query("SELECT * FROM tableone limit 5")->fetchAll();
                        foreach ($data as $row) {
                            echo "<tr>";
                            echo "<th scope='row'>" . $row['id']. "</th>";
                            echo "<td>" . $row['name']. "</td>";
                            echo "<tr>";
                        }?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <p>Foram encontrados <?php echo $conn->query("SELECT * FROM tableone")->rowCount();?>
                 registros.</p>
            </div>
            <div class="row">
                <h3>Tabela 2</h3>
                <table class="table table-bordered" style="text-align: center">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NAME</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = $conn->query("SELECT * FROM tabletwo limit 5")->fetchAll();
                        foreach ($data as $row) {
                            echo "<tr>";
                            echo "<th scope='row'>" . $row['id']. "</th>";
                            echo "<td>" . $row['name']. "</td>";
                            echo "<tr>";
                        }?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <p>Foram encontrados <?php echo $conn->query("SELECT * FROM tabletwo")->rowCount();?>
                 registros.</p>
            </div>
            <div class="row">
                <h3>Diff de Tabelas</h3>
                <table class="table table-bordered" style="text-align: center">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NAME</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = $conn->query("SELECT * FROM tabletwo limit 5")->fetchAll();
                        foreach ($data as $row) {
                            echo "<tr>";
                            echo "<th scope='row'>" . $row['id']. "</th>";
                            echo "<td>" . $row['name']. "</td>";
                            echo "<tr>";
                        }?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <p>Foram encontrados 
                <?php echo $conn->query("SELECT * FROM tabletwo as t INNER JOIN tableone AS o ON t.id = o.id ")->rowCount();?>
                 registros.</p>
            </div>
        </div>
    </body>
</html>
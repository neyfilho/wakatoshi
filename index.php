<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
set_time_limit(300);

include_once "connect.php";
include_once "importcsv.php";
include_once "list.php";
    
if (isset($_POST["Import"])) {

    $file = $_FILES["file"]["tmp_name"];
    $tablename = $_POST["tablename"];
    $delimiter = $_POST["delimitador"];

    importCsv($file, $tablename, $delimiter);
}

?>

<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
        <title>Index</title>
    </head>
    <body>
        <div class="container pt-3">
            <div class="row">
                <form class="form-horizontal" method="post" action="index.php" enctype="multipart/form-data">
                    <fieldset>
                        
                        <!-- Form Name -->
                        <legend>Importação e Exportação de CSV</legend>
                        
                        <!-- Select Tables Box -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="exampleFormControlSelect1">Selecione a base de dados:</label>
                            <div class="col-md-4">
                                <select name="tablename"  class="form-control" id="exampleFormControlSelect1">
                                    <option value="tableone">tableone</option>
                                    <option value="tabletwo">tabletwo</option>
                                </select>
                            </div>
                        </div>

                        <!-- Select Delimiter Box -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="exampleFormControlSelect1">Selecione o delimitador:</label>
                            <div class="col-md-4">
                                <select name="delimitador"  class="form-control" id="exampleFormControlSelect1">
                                    <option value="<?php echo "," ?>"">Virgula</option>
                                    <option value="<?php echo "\t" ?>">Tab</option>
                                </select>
                            </div>
                        </div>

                        <!-- File Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="exampleFormControlFile1">Envie seu csv:</label>
                            <div class="col-md-4">
                                <input type="file" name="file"/>
                            </div>
                        </div>
                        
                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="singlebutton">Import data</label>
                            <div class="col-md-4">
                                <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
                            </div>
                        </div>

                    </fieldset>
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
                        $data = getAll("tableone");
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
                <p>Foram encontrados <?php echo countAll("tableone");?>
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
                        $data = getAll("tabletwo");
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
                <p>Foram encontrados <?php echo countAll("tabletwo");?>
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
                        $data = connectDb()->query("SELECT * FROM tabletwo limit 5")->fetchAll();
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
                <?php echo connectDb()->query("SELECT * FROM tabletwo as t INNER JOIN tableone AS o ON t.id = o.id ")->rowCount();?>
                 registros.</p>
            </div>
        </div>
    </body>
</html>

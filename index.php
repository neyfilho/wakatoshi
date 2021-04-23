<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('MAX_EXECUTION_TIME', '-1');
set_time_limit(30000000);

include_once "connect.php";
include_once "importcsv.php";
include_once "list.php";
    
if (isset($_POST["Import"])) {

    $file = $_FILES["file"]["tmp_name"];
    $tablename = $_POST["tablename"];
    $delimiter = $_POST["delimitador"];

    importCsv($file, $tablename, $delimiter);
}

if (isset($_POST["Update"])) {

    $tablename = $_POST["tablename"];
    $fieldTable = $_POST["fieldTable"];
    $fieldUpdate = $_POST["fieldUpdate"];

    updateField($tablename, $fieldTable, $fieldUpdate);
}

?>

<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <title>Index</title>
    </head>
    <body>

        <!-- Import csv -->
        <div class="container-fluid">
            <div class="row justify-content-center">
                <form class="form-horizontal" method="post" action="index.php" enctype="multipart/form-data">
                        
                        <!-- Select Tables Box -->
                        <div class="form-group">
                            <label class="control-label" for="exampleFormControlSelect1">Selecione a base de dados:</label>
                            <div>
                                <select name="tablename"  class="form-control" id="exampleFormControlSelect1">
                                    <option value="tableone">Tableone</option>
                                    <option value="tabletwo">Tabletwo</option>
                                </select>
                            </div>
                        </div>

                        <!-- Select Delimiter Box -->
                        <div class="form-group">
                            <label class="control-label" for="exampleFormControlSelect1">Selecione o delimitador:</label>
                            <div>
                                <select name="delimitador"  class="form-control" id="exampleFormControlSelect1">
                                    <option value="<?php echo "," ?>"">Virgula</option>
                                    <option value="<?php echo "\t" ?>">Tab</option>
                                    <option value="<?php echo ";" ?>">Ponto e Virgula</option>
                                </select>
                            </div>
                        </div>

                        <!-- File Button -->
                        <div class="form-group">
                            <label class="control-label" for="exampleFormControlFile1">Envie seu csv:</label>
                            <div>
                                <input type="file" name="file"/>
                            </div>
                        </div>
                        
                        <!-- Button -->
                        <div class="form-group">
                            <div style="text-align: center;">
                                <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
                            </div>
                        </div>

                </form>
            </div>
        </div>

        <!-- Import Tables -->
        <div class="container">
            <div class="row justify-content-center">
                <?php getAll("tableone"); ?>
                <?php getAll("tabletwo"); ?>
            </div>
        </div>

        <!-- Export csv -->
        <div class="container">
            <div class="row justify-content-center">
                <?php if(getAllDiff() != null) ?>
            </div>
        </div>

        <!-- Form update fields -->
        <div class="container">
            <div class="row justify-content-center">
                <form class="form-horizontal" method="post" action="index.php">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Selecione a tabela a ser atualizada:</label>
                        <select name="tablename"  class="form-control" id="exampleFormControlSelect1">
                            <option value="tableone">Tableone</option>
                            <option value="tabletwo">Tabletwo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Campo a ser atualziado:</label>
                        <input type="text" class="form-control" name="fieldTable">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Novo nome para atualização:</label>
                        <input type="text" class="form-control" name="fieldUpdate">
                    </div>
                    <button name="Update" type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

    </body>
</html>

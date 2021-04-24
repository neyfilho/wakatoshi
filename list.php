<?php

include_once "connect.php";

function getAll($tableName)
{
    $data = connectDb()->query("SELECT * FROM $tableName limit 5")->fetchAll();

    if ($data != null) {
        logMsg("data successfully extracted from table: ".$tableName.".", "info");

        echo "<div class='table-responsive col-md-4'>
                <h3 style='text-align: center;'>Tabela: ".$tableName."</h3>
                <table style='text-align: center;' id='myTable' class='table table-striped table-bordered'>
                    <thead>
                        <tr>
                            <th style='text-align: center;'>Id</th>
                            <th style='text-align: center;'>Name</th>
                        </tr>
                    </thead>
                <tbody>";
   
            foreach ($data as $row) {
                echo "<tr>";
                echo "<th scope='row'>" . $row['id']. "</th>";
                echo "<td>" . $row['name']. "</td>";
                echo "<tr>";
            }
        echo "</tbody></table><p style='text-align: center;'>Registros encontrados: ".countAll($tableName)."</p>";
        echo "<div>
                <form class='form-horizontal' action='index.php' method='post' name='clearTable' enctype='multipart/form-data'>
                    <div class='form-group'>
                        <div style='text-align: center;'>
                            <input type='hidden' name='tableName' value='$tableName'/>
                            <input type='submit' name='Clean' class='btn btn-danger' value='Clean Table?'/>
                        </div>
                    </div>                    
                </form>           
            </div></div>";
        
   } else {
        logMsg("error get results from table: ".$tableName.".", "error");
        echo "Você ainda não possui registros na tabela.";
   }
}

function getAllDiff()
{
    $data = connectDb()->query("SELECT * FROM tabletwo INNER JOIN tableone ON tabletwo.id = tableone.id  WHERE tableone.name <> tabletwo.name limit 5")->fetchAll();

    if ($data != null) {
        logMsg("data successfully extracted from table: tablediff", "info");

        echo "<div class='table-responsive col-md-4'>
                <h3 style='text-align: center;'>Tabela Diff</h3>
                <table style='text-align: center;' id='myTable' class='table table-striped table-bordered'>
                    <thead>
                        <tr>
                            <th style='text-align: center;'>Id</th>
                            <th style='text-align: center;'>Name</th>
                        </tr>
                    </thead>
                <tbody>";
   
            foreach ($data as $row) {
                echo "<tr>";
                echo "<th scope='row'>" . $row['id']. "</th>";
                echo "<td>" . $row['name']. "</td>";
                echo "<tr>";
            }
        echo "</tbody></table><p style='text-align: center;'>Registros diferentes encontrados: ".countDiff()."</p>";
        echo "<div>
                <form class='form-horizontal' action='index.php' method='post' enctype='multipart/form-data'>
                    <div class='form-group'>
                        <div style='text-align: center;'>
                            <input type='submit' name='Export' class='btn btn-success' value='export to excel'/>
                        </div>
                    </div>                    
                </form>           
            </div></div>";
        }
}

function updateField($tableName, $fieldTable, $fieldUpdate)
{
    $stmt = connectDb()->prepare("UPDATE $tableName SET name = '$fieldUpdate' WHERE name = '$fieldTable'");
    $result = $stmt->execute();

    if(!$result ){
        echo "<script type=\"text/javascript\">
                alert(\"Não foi possivel atualizar o campo.\");
                window.location = \"index.php\"
            </script>";		
    }

    logMsg("data: ".$fieldTable. " successfully update to: ".$fieldUpdate." table: ".$tableName, "info");

    echo "<script type=\"text/javascript\">
            alert(\"Campo atualizado com sucesso.\");
            window.location = \"/\"
        </script>";
}

function countAll($tableName)
{
    $data = connectDb()->query("SELECT * FROM $tableName")->rowCount();
    return $data;
}

function countDiff()
{
    $data = connectDb()->query("SELECT * FROM tabletwo INNER JOIN tableone ON tabletwo.id = tableone.id  WHERE tableone.name <> tabletwo.name")->rowCount();
    return $data;
}

function cleanTable($tableName)
{
    $stmt = connectDb()->prepare("TRUNCATE TABLE $tableName;");
    $stmt->execute();

    echo "<script type=\"text/javascript\">
            alert(\"Tabela foi limpa com sucesso.\");
            window.location = \"/\"
        </script>";
}

?>
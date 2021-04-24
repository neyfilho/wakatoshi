<?php

include_once "connect.php";

function getAll($tablename)
{
    $data = connectDb()->query("SELECT * FROM $tablename limit 5")->fetchAll();

    if ($data != null) {
        echo "<div class='table-responsive col-md-4'>
                <h3 style='text-align: center;'>Tabela: ".$tablename."</h3>
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
        echo "</tbody></table><p style='text-align: center;'>Registros encontrados: ".countAll($tablename)."</p>";
        echo "<div>
                <form class='form-horizontal' action='index.php' method='post' name='clearTable' enctype='multipart/form-data'>
                    <div class='form-group'>
                        <div style='text-align: center;'>
                            <input type='hidden' name='tableName' value='$tablename'/>
                            <input type='submit' name='Clear' class='btn btn-danger' value='Clean Table?'/>
                        </div>
                    </div>                    
                </form>           
            </div></div>";
        
   } else {
        echo "Você ainda não possui registros na tabela.";
   }
}

function getAllDiff()
{
    $data = connectDb()->query("SELECT * FROM tabletwo INNER JOIN tableone ON tabletwo.id = tableone.id  WHERE tableone.name <> tabletwo.name limit 5")->fetchAll();

    if ($data != null) {
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

function updateField($tablename, $fieldTable, $fieldUpdate)
{
    $stmt = connectDb()->prepare("UPDATE $tablename SET name = '$fieldUpdate' WHERE name = '$fieldTable'");
    $result = $stmt->execute();

    if(!$result ){
        echo "<script type=\"text/javascript\">
                alert(\"Não foi possivel atualizar o campo.\");
                window.location = \"index.php\"
            </script>";		
    }

    echo "<script type=\"text/javascript\">
            alert(\"Campo atualizado com sucesso.\");
            window.location = \"/\"
        </script>";
}

function countAll($tablename)
{
    $data = connectDb()->query("SELECT * FROM $tablename")->rowCount();
    return $data;
}

function countDiff()
{
    $data = connectDb()->query("SELECT * FROM tabletwo INNER JOIN tableone ON tabletwo.id = tableone.id  WHERE tableone.name <> tabletwo.name")->rowCount();
    return $data;
}

function cleanTable($tablename)
{
    $stmt = connectDb()->prepare("TRUNCATE TABLE $tablename;");
    $stmt->execute();
}

?>
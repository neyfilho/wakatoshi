<?php

include_once "connect.php";

function getAll($tablename)
{
    $data = connectDb()->query("SELECT * FROM $tablename limit 5")->fetchAll();

    if ($data != null) {
        echo "<div class='table-responsive col-md-4'>
                <table style='text-align: center' id='myTable' class='table table-striped table-bordered'>
                    <thead>
                        <tr>
                            <th style='text-align: center'>Id</th>
                            <th style='text-align: center'>Name</th>
                        </tr>
                    </thead>
                <tbody>";
   
            foreach ($data as $row) {
                echo "<tr>";
                echo "<th scope='row'>" . $row['id']. "</th>";
                echo "<td>" . $row['name']. "</td>";
                echo "<tr>";
            }
        echo "</tbody></table></div>";
        
   } else {
        echo "Você ainda não possui registros na tabela.";
   }
}

function countAll($tablename)
{
    $data = connectDb()->query("SELECT * FROM $tablename")->rowCount();
    return $data;
}

?>
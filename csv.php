<?php

include_once "connect.php";
include_once "log.php";

function importCsv($file, $tablename, $delimiter)
{
    $file_open = fopen($file,"r");

    while (($csv = fgetcsv($file_open, 1000, $delimiter)) !== false) {
        $id = $csv[0];
        $name = $csv[1];
        $stmt = connectDb()->prepare("INSERT INTO $tablename (id, name) VALUES (:id, :name) ON DUPLICATE KEY UPDATE name = :name");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $result = $stmt->execute();

        logMsg("record [".$id."]-[".$name."] was added to base ".$tablename.".", "info");
        
        if(!$result ){
            logMsg("records was not added to base ".$tablename.".", "error");

            echo "<script type=\"text/javascript\">
                    alert(\"Arquivo invalido: Envie um arquivo csv valido.\");
                    window.location = \"index.php\"
                </script>";		
        }
    }

    fclose($file);
    echo "<script type=\"text/javascript\">
            alert(\"Arquivo csv importdo com sucesso.\");
            window.location = \"/\"
        </script>";	
    
}

function exportCsv()
{

    header('Content-Type: text/csv; charset=utf-8');  
    header('Content-Disposition: attachment; filename=data.csv');  
    
    $output = fopen("php://output", "w");  
    
    fputcsv($output, array('Id', 'Name'));  
    
    $data = connectDb()->query("SELECT * FROM tabletwo INNER JOIN tableone ON tabletwo.id = tableone.id  WHERE tableone.name <> tabletwo.name");

    logMsg("data successfully extracted tablediff", "info");
    
    while($row = $data->fetch(PDO::FETCH_ASSOC))  
    {  
        fputcsv($output, $row);  
    }  
    
    fclose($output);  
}

?>
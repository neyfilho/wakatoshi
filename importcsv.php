<?php

include_once "connect.php";

function importCsv($file, $tablename, $delimiter)
{
    $file_open = fopen($file,"r");

    $stmt = connectDb()->prepare("TRUNCATE TABLE $tablename;");
    $stmt->execute();

    while (($csv = fgetcsv($file_open, 1000, $delimiter)) !== false) {
        $id = $csv[0];
        $name = $csv[1];
        $stmt = connectDb()->prepare("INSERT INTO $tablename (id, name) VALUES (:id, :name)");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $result = $stmt->execute();
        
        if(!$result ){
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

?>
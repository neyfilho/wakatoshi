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

?>
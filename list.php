<?php

include_once "connect.php";

function getAll($tablename)
{
    $data = connectDb()->query("SELECT * FROM $tablename limit 5")->fetchAll();
    return $data;
}

function countAll($tablename)
{
    $data = connectDb()->query("SELECT * FROM $tablename")->rowCount();
    return $data;
}

?>
<?php

function logMsg( $msg, $level)
{
    $date = date('d.m.Y h:i:s');
    error_log("datetime: [".$date ."] level: ". $level . " message: ". $msg);

};

?>

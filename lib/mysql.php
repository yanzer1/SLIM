<?php

function connect_db(){
    $server = 'localhost';
    $user = 'root';
    $pass =  '';
    $database = 'unicodtohan';

    $connection = new mysqli($server, $user, $pass, $database);
    return $connection;
}
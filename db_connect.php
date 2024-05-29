<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    // Connessione al database
    $host = 'localhost'; 
    $dbname = 'pgcrypto'; //'progettoltw';
    $dbuser = 'root'; 
    $dbpass = '';

    $username = 'doadmin';
    $password = 'AVNS_bcist4gqFKQ_1udwyw1';
    $host = 'db-mysql-nyc3-78004-do-user-16640846-0.c.db.ondigitalocean.com';
    $port = 25060;
    $dbname= 'defaultdb';

    // Crea la connessione
    $conn = new mysqli($host, $username, $password, $dbname, $port);
    //$conn = new mysqli($host, $dbuser, $dbpass, $dbname);


    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }
?>
<?php

try {
    $connection = new PDO('mysql:dbname=ppi;host=localhost', 'root', '');
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo 'Something went wrong!';
}



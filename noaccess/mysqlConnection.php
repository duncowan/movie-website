<?php
    $conn = new mysqli('localhost', 'dcowan', 'p!s@w(r#', 'dcowan_dev');
    if ($conn->connect_errno) {
        echo "Could not connect to database.";
    }

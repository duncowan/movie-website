<?php
    session_start();
    unset($_SESSION['role']);
    unset($_SESSION['authenticatedUser']);
    header('Location: '.(isset($_SESSION['lastPage']) ? $_SESSION['lastPage'] : "index.php"));
    exit;
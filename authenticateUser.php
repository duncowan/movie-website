<?php
    session_start();
    if(isset($_POST['Login'])) {
        include("noaccess/mysqlConnection.php");
        $_SESSION['loginError'] = "";
        // Prevent HTML and SQL Injection
        $username = $conn->real_escape_string(htmlentities($_POST['loginUser']));
        $password = $conn->real_escape_string(htmlentities($_POST['loginPassword']));
        
        // Search the User database for users with the username and password that were entered
        $query = "SELECT * FROM Users WHERE username = '$username' AND password = '".sha1($password)."'";
        $result = $conn->query($query);

        if(strlen(trim($username)) < 1 || strlen(trim($password)) < 1) {
            // If the username and/or password are empty, show error.
            $_SESSION['loginError'] = "Please enter username and password.";
        } else if($result->num_rows === 0) {
            // If the user isn't in the database, show error.
            $_SESSION['loginError'] = "Incorrect username or password.";
        } else {
            $user = $result->fetch_assoc();

            $_SESSION['authenticatedUser'] = $username;
            $_SESSION['role'] = $user['role'];
            unset($_SESSION['loginError']);
        }

        $result->free();
        $conn->close();

        if(!isset($_SESSION['lastPage']))
            $_SESSION['lastPage'] = "index.php";

        header('Location: '.$_SESSION['lastPage']);
        exit;
    }

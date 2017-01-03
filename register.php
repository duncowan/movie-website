<?php
    session_start();
    if(isset($_SESSION['authenticatedUser'])) {
        header('Location: '.(isset($_SESSION['lastPage']) ? $_SESSION['lastPage'] : "index.php"));
        exit;
    }

    if(isset($_POST['submit'])) {
        include("noaccess/mysqlConnection.php");
        $_SESSION['formErrors'] = array();
        // Prevent HTML and SQL Injection
        $username = $conn->real_escape_string(htmlentities($_POST['username']));
        $password = $conn->real_escape_string(htmlentities($_POST['password']));
        $confirmPassword = $conn->real_escape_string(htmlentities($_POST['confirmPassword']));
        $email = $conn->real_escape_string(htmlentities($_POST['email']));

        $query = "SELECT * FROM Users WHERE username = '$username'";
        $result = $conn->query($query);

        if(strlen(trim($username)) > 0 && $result->num_rows !== 0) {
            $_SESSION['formErrors'][] = "Username is already taken.";
        }
        if(count($_SESSION['formErrors']) < 1 &&
            (strlen(trim($username)) < 1 || strlen(trim($password)) < 1)) {

            $_SESSION['formErrors'][] = "A username and password must be provided.";
        }
        if(strlen(trim($password)) > 0 && strlen(trim($confirmPassword)) < 1) {
            $_SESSION['formErrors'][] = "You must confirm your password.";
        }
        if(strlen(trim($password)) > 0 && strlen(trim($confirmPassword)) > 0 &&
           $password !== $confirmPassword) {

            $_SESSION['formErrors'][] = "Incorrect confirmation password.";
        }

        if(count($_SESSION['formErrors']) > 0) {
            $result->free();
            $conn->close();
            header("location: register.php?errors");
            exit();
        }

        // Remove errors from session if everything is valid
        unset($_SESSION['formErrors']);
    }

    if(!isset($_GET['errors'])) {
        // Remove errors from session if the user came from another page
        unset($_SESSION['formErrors']);
    }
?>
<!DOCTYPE html>
<html lang="en">
        <?php
            include("noaccess/header.php");
        ?>

        <div id="main">
            <h2>Register</h2>
            <?php
                if(isset($_POST['submit'])) {
                    // Encrypt password
                    $password = sha1($password);

                    if ($result->num_rows === 0) {
                        $query = "INSERT INTO Users (username, password, email, role) 
                                  VALUES ('$username', '$password', '$email', 'user')";
                        $conn->query($query);
                        if ($conn->error) {
                            echo "<p>Could not create new user.</p>";
                        } else {
                            echo "<p>Welcome " . stripslashes($username) . ", your account has been created.";
                            $_SESSION['authenticatedUser'] = $username;
                            $_SESSION['role'] = 'user';
                        }
                    } else {
                        echo "<p>Username is already taken.</p>";
                    }

                    $result->free();
                    $conn->close();
                } else {
            ?>

            <form id="registerForm" class="onPageForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <fieldset id="userDetails">
                    <div id="errors">
                        <?php
                            if(isset($_SESSION['formErrors'])) {
                                echo "<p><strong>There were errors processing your form</strong></p>";
                                echo "<ul>";
                                foreach($_SESSION['formErrors'] as $error) {
                                    echo "<li> $error";
                                }
                                echo "</ul>";
                            }
                        ?>
                    </div>
                    <legend>User Details</legend>
                    <p>
                        <label for="username">Username: </label>
                        <input class="field" type="text" id="username" name="username">
                    </p>
                    <p>
                        <label for="password">Password: </label>
                        <input class="field" type="password" id="password" name="password">
                    </p>
                    <p>
                        <label for="confirmPassword">Confirm Password: </label>
                        <input class="field" type="password" id="confirmPassword" name="confirmPassword">
                    </p>
                    <p>
                        <label for="email">Email: </label>
                        <input class="field" type="email" id="email" name="email">
                    </p>
                    <p>
                        <input type="submit" id="submitButton" name="submit" value="Submit">
                    </p>
                </fieldset>
            </form>
            <?php } ?>
        </div>
        <?php include("noaccess/footer.php"); ?>
    </body>
</html>

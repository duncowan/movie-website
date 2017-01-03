<?php
    session_start();
    if(isset($_SESSION['authenticatedUser'])) {
        header('Location: index.php');
        exit;
    }
?>

<!--
    Login page.
-->

<!DOCTYPE html>
<html lang="en">
        <?php
            include("noaccess/header.php");
        ?>

        <div id="main">
            <h2>Login</h2>
            <form id="loginForm" class="onPageForm" action="authenticateUser.php" method="post">
                <fieldset>
                    <legend>Login Details</legend>
                    <p id="errors"><?php echo (isset($_SESSION['loginError']) ? $_SESSION['loginError'] : "") ?></p>
                    <p>
                        <label for="loginUser">Username: </label>
                        <input type="text" name="loginUser" id="loginUser">
                    </p>
                    <p>
                        <label for="loginPassword">Password: </label>
                        <input type="password" name="loginPassword" id="loginPassword">
                    </p>
                    <p>
                        <input type="submit" id="loginSubmit" name="Login" value="Login">
                    </p>
                </fieldset>
            </form>
        </div>

        <?php include("noaccess/footer.php"); ?>
    </body>
</html>

<?php
    if(session_id() === "") {
        session_start();
    }
    $_SESSION['lastPage'] = $_SERVER['PHP_SELF'];

    $pages = array();
    $pages[] = array("Home", "index.php");
    $pages[] = array("Classics", "classic.php");
    $pages[] = array("Science Fiction and Horror", "scifi.php");
    $pages[] = array("Alfred Hitchcock", "hitchcock.php");
    if(isset($_SESSION['authenticatedUser'])) {
        $pages[] = array("Cart", "cart.php");
        $pages[] = array("Orders", "orders.php");
    } else {
        $pages[] = array("Login", "login.php");
    }
?>

<head>
    <title>Classic Cinema</title>
    <link rel="stylesheet" href="fonts/uppereastside/stylesheet.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="jquery/jquery-3.1.0.min.js"></script>
    <?php
        if(isset($scripts) && is_array($scripts)) {
            foreach($scripts as $script) {
                echo "<script src=\"$script\"></script>";
            }
        }
    ?>
    <meta charset="utf-8">
</head>

<body>

<header>
    <h1>Classic Cinema</h1>
</header>

<div id="user">
    <?php if(!isset($_SESSION['authenticatedUser'])) { ?>
    <div id="login">
        <form id="loginForm" action="authenticateUser.php" method="post">
            <p id="errors"><?php echo (isset($_SESSION['loginError']) ? $_SESSION['loginError'] : "") ?></p>
            <label for="loginUser">Username: </label>
            <input type="text" name="loginUser" id="loginUser">
            <label for="loginPassword">Password: </label>
            <input type="password" name="loginPassword" id="loginPassword">
            <input type="submit" id="loginSubmit" name="Login" value="Login">
            <input type="button" id="register" value="Register" onclick="location.href = 'register.php'">
        </form>
    </div>
    <?php } else { ?>
    <div id="logout">
        <p>Welcome, <span id="logoutUser"><?php echo $_SESSION['authenticatedUser']; ?></span></p>
        <form id="logoutForm" action="logout.php" method="post">
            <input type="submit" id="logoutSubmit" name="Logout" value="Logout">
        </form>
    </div>
    <?php } ?>
</div>

<nav>
    <ul>
        <?php
            if(isset($pages) && is_array($pages)) {
                foreach($pages as $page) {
                    if(isset($page) && is_array($page)) {
                        if($page[1] === basename($_SERVER['PHP_SELF'])) {
                            echo "<li> $page[0]";
                        } else {
                            echo "<li> <a href=\"$page[1]\">$page[0]</a>";
                        }
                    }
                }
            }
        ?>
    </ul>
</nav>

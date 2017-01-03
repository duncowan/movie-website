<?php
    session_start();
    if(!isset($_SESSION['authenticatedUser'])) {
        header('Location: index.php');
        exit;
    }

    if(isset($_POST['Submit'])) {
        $xmlFileName = "../".htmlentities($_POST['xmlFileName']);
        $rating = htmlentities($_POST['rating']);

        // Add review to xml file
        $reviews = simplexml_load_file($xmlFileName);
        $newReview = $reviews->addChild('review');

        $newReview->addChild('user', $_SESSION['authenticatedUser']);
        $newReview->addChild('rating', $rating);

        // Save xml
        $reviews->saveXML($xmlFileName);
    }

    header('Location: '.(isset($_SESSION['lastPage']) ? $_SESSION['lastPage'] : "index.php"));
    exit;
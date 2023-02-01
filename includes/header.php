<?php
/*
*Created by Sofia Widholm. 
*Webbutveckling III, Webbutveckling, Mittuniversitetet.
*Last update 2022-06-02
*/
?>

<?php
// Inclusion of configuration file
include_once('includes/config.php');
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $site_title . $divider . $page_title; ?></title>
    <link rel="favicon" href="images/favicon32x32.png">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header with userbar that is shown when logged in and logotype -->
    <header>
    <?php
    // Check if session variable is set
    if (isset($_SESSION['loggedIn'])) {
    ?>
        <!-- User bar -->
        <div class="login-info">
            <nav>
                <a href="admin.php">HUVUDMENY</a>
                <a href="courses.php">MAT</a>
                <a href="drinks.php">DRYCK</a>
                <a href="bookings.php">BOKNINGAR</a>
                <a href="logout.php">LOGGA UT</a>
            </nav>
        </div>
    <?php
    }
    ?>

        <!-- Logotype -->
        <img src="images/biglogotype.svg" alt="Restaurang PNYs logotyp">
    </header>
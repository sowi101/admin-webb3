<?php
/*
*Created by Sofia Widholm. 
*Webbutveckling III, Webbutveckling, Mittuniversitetet.
*Last update 2022-06-02
*/
?>

<?php
// Inclusion of configuration file
include("includes/config.php");

// Unsets and destroy session variables
session_unset();
session_destroy();

// Redirect to login page
header("Location: index.php");
?>
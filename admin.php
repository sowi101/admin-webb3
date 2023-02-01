<?php
/*
*Created by Sofia Widholm. 
*Webbutveckling III, Webbutveckling, Mittuniversitetet.
*Last update 2022-06-02
*/
?>

<?php
// Variable that store page title
$page_title = "Huvudmeny";
// Inclusion of header.php
include("includes/header.php");

// Check if session variable is not set
if (!$_SESSION["loggedIn"]) {
    // Redirect to login page
    header("location: index.php");
}
?>
    <!-- Main content -->
    <main class="small-width">
        <h1>Adminstration för Restaurang PNY</h1>

        <!-- Picture links to menu and bookings -->
        <div class="flex">
            <a href="courses.php" class="banner-link flex-item-mini">
                <img src="images/food2.jpg" alt="Olika kötträtter">
                <h2 class="centered-text">MAT</h2>
            </a>

            <a href="drinks.php" class="banner-link flex-item-mini">
                <img src="images/drinks.jpg" alt="Röd drink i högt glas">
                <h2 class="centered-text">DRYCK</h2>
            </a>

            <a href="bookings.php" class="banner-link flex-item-mini">
                <img src="images/table.jpg" alt="Dukat bord">
                <h2 class="centered-text">BOKNINGAR</h2>
            </a>
        </div>

    </main>
    
<?php
// Inclusion of footer.php
include("includes/footer.php");
?>
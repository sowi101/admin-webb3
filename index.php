<?php
/*
*Created by Sofia Widholm. 
*Webbutveckling III, Webbutveckling, Mittuniversitetet.
*Last update 2022-06-02
*/
?>

<?php
// Variable that store page title
$page_title = "Inloggning";
// Inclusion of header.php
include("includes/header.php");

// If statement that check if user is logged in
if (isset($_SESSION["loggedIn"])) {
    // Redirection to admin page
    header("location: admin.php");
}

// If statement that check if form has been set
if (isset($_POST["username"])) {
    // If statement that check if both variables are empty
    if ($_POST["username"] === "" && $_POST["password"] === "") {
        // Save error message to variable
        $formMessage = "Du har inte fyllt i något av fälten.";
        // Else if statement that check if any of the variables is empty
    } else if ($_POST["username"] === "" || $_POST["password"] === "") {
        // If statements that check if a specific variable is empty and when true, saves an error message to a variable
        if ($_POST["username"] === "") {
            $usernameMessage = "Du har inte fyllt i ett användarnamn.";
        }
        if ($_POST["password"] === "") {
            $passwordMessage = "Du har inte fyllt i ett lösenord.";
        }
    } else {
        // Initializes a new curl session, return a handle (the variable) to use.
        $curl = curl_init();
        
        // Options for transfer

        // The URL to the webservice
        curl_setopt($curl, CURLOPT_URL, "https://studenter.miun.se/~sowi2102/writeable/dt173g/projekt/webservice/login.php");
        // To make a regular HTTP POST
        curl_setopt($curl, CURLOPT_POST, true);
        // The data to be posted to the webservice, converted to JSON
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($_POST));
        // Returns the transfer as a string (to be saved with curl_exec)
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Execute the curl session and save returned data in a variable
        $response = curl_exec($curl);
        // Close the curl session, deletes the handle
        curl_close($curl);

        // Convert the returned data from JSON
        $data = json_decode($response, true);

        // If statement that check if a certain array key exists in the returned data
        if (array_key_exists('correctUser', $data)) {
            // Save the array key and value to a variable
            $correctUser = $data["correctUser"];
        } else {
            // Save the opposite bool value to variable
            $correctUser = false;
        }

        // If statement that check is variable is true
        if ($correctUser === true) {
            // Set a session variable to true
            $_SESSION["loggedIn"] = true;
            // Redirect to admin page
            header("Location: admin.php");
        } else {
            // Save an error message to a variable
            $formMessage = "Felaktiga användaruppgifter.";
        }
    }
}
?>

    <!-- Main content -->
    <main class="login">
        <h1>Inloggning för administration</h1>

        <!-- Form to login -->
        <form action="index.php" method="POST">

            <p>
                <label for="username"><strong>Användarnamn</strong></label>
                <br />
                <input type="text" id="username" name="username">
                <br />
                <?php
                // If statement that check if variable has been set
                if (isset($usernameMessage)) {
                    // Prints error message
                    echo "<span class='error'>" . $usernameMessage . "</span>";
                }
                ?>
            </p>
            <p>
                <label for="password"><strong>Lösenord</strong></label>
                <br />
                <input type="password" id="password" name="password">
                <br />
                <?php
                // If statement that check if variable has been set
                if (isset($passwordMessage)) {
                    // Prints error message
                    echo "<span class='error'>" . $passwordMessage . "</span>";
                }
                ?>
            </p>

            <p>
                <input type="submit" value="Logga in">
            </p>

            <?php
            // If statement that check if variable has been set
            if (isset($formMessage)) {
                // Prints error message
                echo "<p class='error'>" . $formMessage . "</p";
            }
            ?>
        </form>

    </main>
<?php
// Inclusion of footer.php
include("includes/footer.php");
?>
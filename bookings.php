<?php 
/*
*Created by Sofia Widholm. 
*Webbutveckling III, Webbutveckling, Mittuniversitetet.
*Last update 2022-06-04
*/
?>

<?php
// Variable that store page title
$page_title = "Hantera bokningar";
// Inclusion of header.php
include("includes/header.php");

// Check if session variable is not set
if (!$_SESSION["loggedIn"]) {
    // Redirection to login page
    header("location: index.php");
}

// Empty variable
$tableMessage = "";

// If statement to check if form has been sent
if (isset($_POST["firstname"])) {
    // Save to new variables
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phonenum = $_POST["phonenum"];
    $request = $_POST["request"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $guests = $_POST["guests"];

    // If statement to check if all POST variables are empty
    if ($_POST["firstname"] === "" && $_POST["lastname"] === "" && $_POST["email"] === "" && $_POST["phonenum"] === "" && $_POST["date"] === "" && $_POST["time"] === "" && $_POST["guests"] === "") {
        // Save error message to variable
        $formMessage = "Du har inte fyllt i något av fälten";
        // Else if statement to check if any of the POST variables is empty
    } else if ($_POST["firstname"] === "" || $_POST["lastname"] === "" || $_POST["email"] === "" || $_POST["phonenum"] === "" || $_POST["date"] === "" || $_POST["time"] === "" || $_POST["guests"] === "") {
        // If statements to check if a specific POST variable is empty and save error message
        if ($_POST["firstname"] === "") {
            $firstNameMessage = "Du har glömt att fylla i förnamn.";
        }

        if ($_POST["lastname"] === "") {
            $lastNameMessage = "Du har glömt att fylla i efternamn.";
        }

        if ($_POST["email"] === "") {
            $emailMessage = "Du har glömt att fylla i en e-postadress.";
        }

        if ($_POST["phonenum"] === "") {
            $phoneMessage = "Du har glömt att fylla i ett telefonnummer.";
        }

        if ($_POST["date"] === "") {
            $dateMessage = "Du har glömt att välja ett datum.";
        }

        if ($_POST["time"] === "") {
            $timeMessage = "Du har glömt att välja en tid";
        }

        if ($_POST["guests"] === "") {
            $guestMessage = "Du har glömt att välja antal gäster.";
        }
    } else {
        // POST call

        // Initializes a new curl session, return a handle (the variable) to use.
        $curl = curl_init();

        // Options for transfer

        // The URL to the webservice
        curl_setopt($curl, CURLOPT_URL, "https://studenter.miun.se/~sowi2102/writeable/dt173g/projekt/webservice/bookingapi.php");
        // Returns the transfer as a string (to be saved with curl_exec)
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // To make a regular HTTP POST
        curl_setopt($curl, CURLOPT_POST, true);
        // The data to be posted to the webservice, converted to JSON
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($_POST));

        // Execute the curl session and save returned data in a variable
        $response = curl_exec($curl);
        // Close the curl session, deletes the handle
        curl_close($curl);

        // Convert the returned data from JSON
        $response = json_decode($response, true);
        // Save the message from webservice to a variable
        $formMessage = $response["message"];

        // Empty variables
        $firstname = "";
        $lastname = "";
        $email = "";
        $phonenum = "";
        $request = "";
        $date = "";
        $time = "";
        $guests = "";
    }
} else {
    // Empty variables
    $firstname = "";
    $lastname = "";
    $email = "";
    $phonenum = "";
    $request = "";
    $date = "";
    $time = "";
    $guests = "";
}

// GET call

// Initializes a new curl session, return a handle (the variable) to use.
$curl = curl_init();

// Options for transfer

// The URL to the webservice
curl_setopt($curl, CURLOPT_URL, "https://studenter.miun.se/~sowi2102/writeable/dt173g/projekt/webservice/bookingapi.php");
// Returns the transfer as a string (to be saved with curl_exec)
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Execute the curl session and save returned data in a variable
$bookingResponse = curl_exec($curl);
// Close the curl session, deletes the handle
curl_close($curl);

// Convert the returned data from JSON
$data = json_decode($bookingResponse, true);
?>

    <main>

        <h1>Hantera bokningar</h1>

        <h2>Lägg till bokning</h2>

        <!-- Form to post a booking -->
        <form method="POST" action="bookings.php">
            
            <div class="flex">
                <p class="flex-item">
                    <label for="firstname"><strong>Förnamn</strong></label>
                    <br />
                    <input type="text" id="firstname" name="firstname" value="<?= $firstname ?>">
                    <br />
                    <?php
                    // If statement that checks if variable has been set
                    if (isset($firstNameMessage)) {
                        // Prints error message
                        echo "<span class='error'>" . $firstNameMessage . "</span>";
                    }
                    ?>
                </p>
                
                <p class="flex-item">
                    <label for="lastname"><strong>Efternamn</strong></label>
                    <br />
                    <input type="text" id="lastname" name="lastname" value="<?= $lastname ?>">
                    <br />
                    <?php
                    // If statement that checks if variable has been set
                    if (isset($lastNameMessage)) {
                        // Prints error message
                        echo "<span class='error'>" . $lastNameMessage . "</span>";
                    }
                    ?>
                </p>
            </div>

            <div class="flex">
                <p class="flex-item">
                    <label for="email"><strong>E-postadress</strong></label>
                    <br />
                    <input type="email" id="email" name="email" <?= $email ?>>
                    <br />
                    <?php
                    // If statement that checks if variable has been set
                    if (isset($emailMessage)) {
                        // Prints error message
                        echo "<span class='error'>" . $emailMessage . "</span>";
                    }
                    ?>
                </p>

                <p class="flex-item">
                    <label for="phonenum"><strong>Telefonnummer</strong></label>
                    <br />
                    <input type="number" min="0" id="phonenum" name="phonenum" value="<?= $phonenum ?>">
                    <br />
                    <?php
                    // If statement that checks if variable has been set
                    if (isset($phoneMessage)) {
                        // Prints error message
                        echo "<span class='error'>" . $phoneMessage . "</span>";
                    }
                    ?>
                </p>
            </div>

            <p>
                <label for="request"><strong>Allergier/Önskemål</strong></label>
                <br />
                <textarea name="request" id="request" cols="30" rows="10"><?= $request ?></textarea>
            </p>

            <div class="flex">
                <p class="flex-item-mini">
                    <label for="date"><strong>Datum</strong></label>
                    <br />
                    <input type="date" name="date" id="date" min="<?php echo date('Y-m-d'); ?>" value="<?= $date ?>">
                    <br />
                    <?php
                    // If statement that checks if variable has been set
                    if (isset($dateMessage)) {
                        // Prints error message
                        echo "<span class='error'>" . $dateMessage . "</span>";
                    }
                    ?>
                </p>
                <p class="flex-item-mini">
                    <label for="time"><strong>Tid</strong></label>
                    <br />
                    <input type="time" id="time" name="time" min="16:00" max="22:30" value="<?= $time ?>">
                    <br />
                    <?php
                    // If statement that checks if variable has been set
                    if (isset($timeMessage)) {
                        // Prints error message
                        echo "<span class='error'>" . $timeMessage . "</span>";
                    }
                    ?>
                </p>

                <p class="flex-item-mini">
                    <label for="guests"><strong>Antal gäster</strong></label>
                    <br />
                    <select name="guests" id="guests">
                        <option value="" selected>Välj</option>
                        <option value="1" <?php if ($guests == "1") echo 'selected=""'; ?>>1</option>
                        <option value="2" <?php if ($guests == "2") echo 'selected=""'; ?>>2</option>
                        <option value="3" <?php if ($guests == "3") echo 'selected=""'; ?>>3</option>
                        <option value="4" <?php if ($guests == "4") echo 'selected=""'; ?>>4</option>
                        <option value="5" <?php if ($guests == "5") echo 'selected=""'; ?>>5</option>
                        <option value="6" <?php if ($guests == "6") echo 'selected=""'; ?>>6</option>
                        <option value="7" <?php if ($guests == "7") echo 'selected=""'; ?>>7</option>
                        <option value="8" <?php if ($guests == "8") echo 'selected=""'; ?>>8</option>
                    </select>
                    <br />
                    <?php
                    // If statement that checks if variable has been set
                    if (isset($guestMessage)) {
                        // Prints error message
                        echo "<span class='error'>" . $guestMessage . "</span>";
                    }
                    ?>
                </p>
            </div>

            <p>
                <input type="submit" value="Lägg till bokning">
            </p>

            <?php
            // If statement that checks if variable has been set
            if (isset($formMessage)) {
                // Prints error message
                echo "<p class='message'>" . $formMessage . "</p>";
            }
            ?>
            
        </form>

        <h2>Bokningar</h2>

        <!-- Table for bookings -->
        <table>
            <thead>
                <tr>
                    <td>Datum</td>
                    <td class="centered">Tid</td>
                    <td class="centered">Antal</td>
                    <td class="hidden-mobile">Förnamn</td>
                    <td>Efternamn</td>
                    <td class="hidden-tablet hidden-mobile">Önskemål</td>
                    <td class="change sr-only">Ändra</td>
                    <td class="delete sr-only">Radera</td>
                </tr>
            </thead>
            <tbody>
                <?php
                // If statement that if a certain key in the array does not exist
                if(!array_key_exists("message", $data)) {
                    // For each that loops through all objects in the array 
                    foreach ($data as $booking) {
                        // Prints information of booking
                ?>
                    <tr>
                        <td class="twenty"><?= $booking["date"] ?></td>
                        <td class="five centered"><?= $booking["time"] ?></td>
                        <td class="ten centered"><?= $booking["guests"] ?></td>
                        <td class="hidden-mobile"><?= $booking["firstname"] ?></td>
                        <td class="fifthteen"><?= $booking["lastname"] ?></td>
                        <td class="hidden-tablet hidden-mobile"><?= $booking["request"] ?></td>
                        <td class="change"><a class="change-btn" href="editbooking.php?id=<?= $booking["id"] ?>">Ändra</a></td>
                        <td class="delete"><a class="delete-btn" href="deletebooking.php?id=<?= $booking["id"] ?>">Radera</a></td>
                    </tr>
                <?php
                }
            } else {
                // Save message from webservice to a variable
                $tableMessage = $data["message"];
            }

                ?>
            </tbody>
        </table>
        <!-- Print message -->
        <p><?php echo $tableMessage; ?></p>

    </main>

<?php
// Inclusion of footer.php
include("includes/footer.php");

?>
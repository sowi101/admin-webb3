<?php
/*
*Created by Sofia Widholm. 
*Webbutveckling III, Webbutveckling, Mittuniversitetet.
*Last update 2022-06-04
*/
?>

<?php
// Variable that store page title
$page_title = "Ändra bokning";
// Inclusion of header.php
include("includes/header.php");

// Check if session variable is not set
if (!$_SESSION["loggedIn"]) {
    // Redirection to login page
    header("location: index.php");
}

// If statement to check if a GET parameter has been set
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // GET call

    // Initializes a new curl session, return a handle (the variable) to use.
    $curl = curl_init();
    
    // Options for transfer

    // The URL to the webservice
    curl_setopt($curl, CURLOPT_URL, "https://studenter.miun.se/~sowi2102/writeable/dt173g/projekt/webservice/bookingapi.php?id=$id");
    // Returns the transfer as a string (to be saved with curl_exec)
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    // Execute the curl session and save returned data in a variable
    $response = curl_exec($curl);
    // Close the curl session, deletes the handle
    curl_close($curl);

    // Convert the returned data from JSON
    $data = json_decode($response, true);
}

// If statement to check if a form has been sent
if (isset($_POST["firstname"])) {
    // Save to "new" variable
    $data["id"] = $_POST["id"];
    $data["firstname"] = $_POST["firstname"];
    $data["lastname"] = $_POST["lastname"];
    $data["email"] = $_POST["email"];
    $data["phonenum"] = $_POST["phonenum"];
    $data["request"] = $_POST["request"];
    $data["date"] = $_POST["date"];
    $data["time"] = $_POST["time"];
    $data["guests"] = $_POST["guests"];

    // If statement to check if any of the POST variables is empty
    if ($_POST["id"] === "" || $_POST["firstname"] === "" || $_POST["lastname"] === "" || $_POST["email"] === "" || $_POST["phonenum"] === "" || $_POST["date"] === "" || $_POST["time"] === "" || $_POST["guests"] === "") {
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
        // Save all POST variables to an array
        $input = array(
            "firstname" => $_POST["firstname"],
            "lastname" => $_POST["lastname"],
            "email" => $_POST["email"],
            "phonenum" => $_POST["phonenum"],
            "request" => $_POST["request"],
            "date" => $_POST["date"],
            "time" => $_POST["time"],
            "guests" => $_POST["guests"]
        );

        // Convert to JSON
        $jsonStr = json_encode($input);

        // PUT call

        // Initializes a new curl session, return a handle (the variable) to use.
        $curl = curl_init();
        
        // Options for transfer

        // The URL to the webservice
        $url = "https://studenter.miun.se/~sowi2102/writeable/dt173g/projekt/webservice/bookingapi.php?id=" . $_POST['id'];
        curl_setopt($curl, CURLOPT_URL, $url);
        // Which request method to use
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        // The data to be posted to the webservice, converted to JSON
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonStr);
        // Set header of content type to JSON
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));
        // Returns the transfer as a string (to be saved with curl_exec)
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Execute the curl session and save returned data in a variable
        $bookingResponse = curl_exec($curl);
        // Close the curl session, deletes the handle
        curl_close($curl);

        // Convert the returned data from JSON
        $bookingResponse = json_decode($bookingResponse, true);
        // Save the message from webservice to a variable
        $formMessage = $bookingResponse["message"];
    }
}
?>

    <main>
        <h1>Ändra bokning</h1>

        <!-- Form to post updates to booking -->
        <form method="POST" action="editbooking.php?id=<?= $data["id"]; ?>">

            <input type="hidden" name="id" value="<?= $data["id"] ?>">

            <div class="flex">
                <p class="flex-item">
                    <label for="firstname"><strong>Förnamn</strong></label>
                    <br />
                    <input type="text" id="firstname" name="firstname" value="<?= $data["firstname"] ?>">
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
                    <br>
                    <input type="text" id="lastname" name="lastname" value="<?= $data["lastname"] ?>">
                    <br>
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
                    <br>
                    <input type="email" id="email" name="email" value="<?= $data["email"] ?>">
                    <br>
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
                    <br>
                    <input type="number" min="0" id="phonenum" name="phonenum" value="<?= $data["phonenum"] ?>">
                    <br>
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
                <textarea name="request" id="request" cols="30" rows="10"><?= $data["request"] ?></textarea>
            </p>

            <div class="flex">
                <p class="flex-item-mini">
                    <label for="date"><strong>Datum</strong></label>
                    <br>
                    <input type="date" name="date" id="date" value="<?= $data["date"] ?>">
                    <br>
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
                    <br>
                    <input type="time" id="time" name="time" value="<?= $data["time"] ?>">
                    <br>
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
                    <br>
                    <select name="guests" id="guests">
                        <option value="1" <?php if ($data['guests'] == "1") echo 'selected="selected"'; ?>>1</option>
                        <option value="2" <?php if ($data['guests'] == "2") echo 'selected="selected"'; ?>>2</option>
                        <option value="3" <?php if ($data['guests'] == "3") echo 'selected="selected"'; ?>>3</option>
                        <option value="4" <?php if ($data['guests'] == "4") echo 'selected="selected"'; ?>>4</option>
                        <option value="5" <?php if ($data['guests'] == "5") echo 'selected="selected"'; ?>>5</option>
                        <option value="6" <?php if ($data['guests'] == "6") echo 'selected="selected"'; ?>>6</option>
                        <option value="7" <?php if ($data['guests'] == "7") echo 'selected="selected"'; ?>>7</option>
                        <option value="8" <?php if ($data['guests'] == "8") echo 'selected="selected"'; ?>>8</option>
                    </select>
                    <br>
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
                <input type="submit" value="Ändra bokning">
            </p>
            
            <?php
            // If statement that checks if variable has been set
            if (isset($formMessage)) {
                // Prints error message
                echo "<p class='message'>" . $formMessage . "</p>";
            }
            ?>
        </form>

    </main>

<?php
// Inclusion of footer.php
include("includes/footer.php");
?>
<?php
/*
*Created by Sofia Widholm. 
*Webbutveckling III, Webbutveckling, Mittuniversitetet.
*Last update 2022-06-04
*/
?>

<?php
// Variable that store page title
$page_title = "Ändra menyinformation";
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
    curl_setopt($curl, CURLOPT_URL, "https://studenter.miun.se/~sowi2102/writeable/dt173g/projekt/webservice/menuapi.php?id=$id");
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
if (isset($_POST["name"])) {
    // Save to "new" variable
    $data["id"] = $_POST["id"];
    $data["name"] = $_POST["name"];
    $data["price"] = $_POST["price"];
    $data["description"] = $_POST["description"];
    $data["category"] = $_POST["category"];
    $data["subcategory"] = $_POST["subcategory"];

    // If statement to check if any of the POST variables is empty
    if ($_POST["id"] === "" || $_POST["name"] === "" || $_POST["price"] === "" || $_POST["description"] === "" || $_POST["category"] === "" || $_POST["subcategory"] === "") {
        // If statements to check if a specific POST variable is empty and save error message
        if ($_POST["name"] === "") {
            $nameMessage = "Du har glömt att fylla i namn.";
        }

        if ($_POST["price"] === "" || $_POST["price"] === 0) {
            $priceMessage = "Du har glömt att fylla i pris.";
        }

        if ($_POST["description"] === "") {
            $descriptionMessage = "Du har glömt att fylla i en beskrivning.";
        }

        if ($_POST["category"] === "") {
            $categoryMessage = "Du har glömt att välja en kategori.";
        }

        if ($_POST["subcategory"] === "") {
            $subcategoryMessage = "Du har glömt att välja en underkategori.";
        }
    } else {
        // Save all POST variables to an array
        $input = array(
            "name" => $_POST["name"],
            "price" => $_POST["price"],
            "description" => $_POST["description"],
            "category" => $_POST["category"],
            "subcategory" => $_POST["subcategory"]
        );

        // Convert to JSON
        $jsonStr = json_encode($input);

        // POST call

        // Initializes a new curl session, return a handle (the variable) to use.
        $curl = curl_init();

        // Options for transfer

        // The URL to the webservice
        $url = "https://studenter.miun.se/~sowi2102/writeable/dt173g/projekt/webservice/menuapi.php?id=" . $_POST['id'];
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
        $menuResponse = curl_exec($curl);
        // Close the curl session, deletes the handle
        curl_close($curl);

        // Convert the returned data from JSON
        $menuResponse = json_decode($menuResponse, true);
        // Save the message from webservice to a variable
        $formMessage = $menuResponse["message"];
    }
}
?>

    <main>
        <h1>Ändra <?= $data["name"] ?></h1>

        <!-- Form to post updates to menu -->
        <form method="POST" action="editmenuitem.php?id=<?= $data["id"]; ?>">

            <input type="hidden" name="id" value="<?= $data["id"] ?>">

            <div class="flex">
                <p class="flex-item">
                    <label for="name"><strong>Namn</strong></label>
                    <br />
                    <input type="text" id="name" name="name" value="<?= $data["name"] ?>">
                    <br />
                    <?php
                    // If statement that checks if variable has been set
                    if (isset($nameMessage)) {
                        // Prints error message
                        echo "<span class='error'>" . $nameMessage . "</span>";
                    }
                    ?>

                </p>
                <p class="flex-item">
                    <label for="price"><strong>Pris</strong></label>
                    <br />
                    <input type="number" min="0" id="price" name="price" value="<?= $data["price"] ?>">
                    <br />
                    <?php
                    // If statement that checks if variable has been set
                    if (isset($priceMessage)) {
                        // Prints error message
                        echo "<span class='error'>" . $priceMessage . "</span>";
                    }
                    ?>
                </p>
            </div>

            <p>
                <label for="description"><strong>Beskrivning</strong></label>
                <br />
                <textarea name="description" id="description" cols="30" rows="10"><?= $data["description"] ?></textarea>
                <br />
                <?php
                // If statement that checks if variable has been set
                if (isset($descriptionMessage)) {
                    // Prints error message
                    echo "<span class='error'>" . $descriptionMessage . "</span>";
                }
                ?>
            </p>

            <div class="flex">
                <p class="flex-item">
                    <label for="category"><strong>Kategori</strong></label>
                    <br />
                    <select name="category" id="category">
                        <option value="Maträtt" <?php if ($data['category'] == "Maträtt") echo 'selected="selected"'; ?>>Maträtt</option>
                        <option value="Dryck" <?php if ($data['category'] == "Dryck") echo 'selected="selected"'; ?>>Dryck</option>
                    </select>
                    <br />
                    <?php
                    // If statement that checks if variable has been set
                    if (isset($categoryMessage)) {
                        // Prints error message
                        echo "<span class='error'>" . $categoryMessage . "</span>";
                    }
                    ?>
                </p>

                <p class="flex-item">
                    <label for="subcategory"><strong>Underkategori</strong></label>
                    <br />
                    <select name="subcategory" id="subcategory">
                        <?php
                        if ($data["category"] === "Maträtt") {
                        ?>
                            <option value="Förrätt" <?php if ($data['subcategory'] == "Förrätt") echo 'selected="selected"'; ?>>Förrätt</option>
                            <option value="Huvudrätt" <?php if ($data['subcategory'] == "Huvudrätt") echo 'selected="selected"'; ?>>Huvudrätt</option>
                            <option value="Dessert" <?php if ($data['subcategory'] == "Dessert") echo 'selected="selected"'; ?>>Dessert</option>
                        <?php
                        } else {
                        ?>
                            <option value="Rött vin" <?php if ($data['subcategory'] == "Rött vin") echo 'selected="selected"'; ?>>Rött vin</option>
                            <option value="Vitt vin" <?php if ($data['subcategory'] == "Vitt vin") echo 'selected="selected"'; ?>>Vitt vin</option>
                            <option value="Öl och cider" <?php if ($data['subcategory'] == "Öl och cider") echo 'selected="selected"'; ?>>Öl och cider</option>
                            <option value="Alkoholfritt" <?php if ($data['subcategory'] == "Alkoholfritt") echo 'selected="selected"'; ?>>Alkoholfritt</option>
                        <?php
                        }
                        ?>
                    </select>
                    <br />
                    <?php
                    // If statement that checks if variable has been set
                    if (isset($subcategoryMessage)) {
                        // Prints error message
                        echo "<span class='error'>" . $subcategoryMessage . "</span>";
                    }
                    ?>
                </p>
            </div>
            
            <p>
                <input type="submit" value="Ändra maträtt/dryck">
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
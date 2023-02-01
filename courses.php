<?php
/*
*Created by Sofia Widholm. 
*Webbutveckling III, Webbutveckling, Mittuniversitetet.
*Last update 2022-06-04
*/
?>

<?php
// Variable that store page title
$page_title = "Hantera maträtter";
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
if (isset($_POST["category"])) {
    // Save to new variables
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $category = $_POST["category"];
    $subcategory = $_POST["subcategory"];

    // If statement to check if all POST variables are empty
    if ($_POST["name"] === "" && $_POST["price"] === "" && $_POST["description"] === "" && $_POST["category"] === "" && $_POST["subcategory"] === "") {
        // Save error message to variable
        $formMessage = "Du har inte fyllt i något av fälten";
        // Else if statement to check if any of the POST variables is empty
    } else if ($_POST["name"] === "" || $_POST["price"] === "" || $_POST["description"] === "" || $_POST["category"] === "" || $_POST["subcategory"] === "") {
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
        // POST call

        // Initializes a new curl session, return a handle (the variable) to use.
        $curl = curl_init();

        // Options for transfer

        // The URL to the webservice
        curl_setopt($curl, CURLOPT_URL, "https://studenter.miun.se/~sowi2102/writeable/dt173g/projekt/webservice/menuapi.php");
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
        $name = "";
        $price = "";
        $description = "";
        $category = "";
        $subcategory = "";
    }
} else {
    // Empty variables
    $name = "";
    $price = "";
    $description = "";
    $category = "";
    $subcategory = "";
}

// GET call

// Initializes a new curl session, return a handle (the variable) to use.
$curl = curl_init();

// Options for transfer

// The URL to the webservice
curl_setopt($curl, CURLOPT_URL, "https://studenter.miun.se/~sowi2102/writeable/dt173g/projekt/webservice/menuapi.php");
// Returns the transfer as a string (to be saved with curl_exec)
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Execute the curl session and save returned data in a variable
$menuResponse = curl_exec($curl);
// Close the curl session, deletes the handle
curl_close($curl);

// Convert the returned data from JSON
$data = json_decode($menuResponse, true);
?>

    <!-- Main content -->
    <main>
        <h1>Hantera maträtter</h1>

        <h2>Lägg till maträtt</h2>

        <!-- Form to post items to menu -->
        <form method="POST" action="courses.php">
            <div class="flex">
                <p class="flex-item">
                    <label for="name"><strong>Namn</strong></label>
                    <br />
                    <input type="text" id="name" name="name" value="<?= $name ?>">
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
                    <input type="number" min="0" id="price" name="price" value="<?= $price ?>">
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
                <textarea name="description" id="description" cols="30" rows="10"><?= $price ?></textarea>
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
                        <option value="Maträtt">Maträtt</option>
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
                    <label for="subcategory"><strong>Kategori</strong></label>
                    <br />
                    <select name="subcategory" id="subcategory">
                        <option value="" selected>Välj en underkategori</option>
                        <option value="Förrätt" <?php if ($subcategory == "Förrätt") echo 'selected=""'; ?>>Förrätt</option>
                        <option value="Huvudrätt" <?php if ($subcategory == "Huvudrätt") echo 'selected=""'; ?>>Huvudrätt</option>
                        <option value="Dessert" <?php if ($subcategory == "Dessert") echo 'selected=""'; ?>>Dessert</option>
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
                <input type="submit" value="Lägg till">
            </p>

            <?php
            // If statement that checks if variable has been set
            if (isset($formMessage)) {
                // Prints error message
                echo "<p class='message'>" . $formMessage . "</p>";
            }
            ?>

        </form>

        <h2>Nuvarande maträtter</h2>

        <!-- Table for starters -->
        <h3>Förrätter</h3>
        <table>
            <thead>
                <tr>
                    <td class="twentyfive">Namn</td>
                    <td class="centered">Pris</td>
                    <td class="hidden-mobile">Beskrivning</td>
                    <td class="change sr-only">Ändra</td>
                    <td class="delete sr-only">Radera</td>
                </tr>
            </thead>
            <tbody>
                <?php
                // If statement that if a certain key in the array does not exist
                if (!array_key_exists("message", $data)) {
                    // For each that loops through all objects in the array
                    foreach ($data as $menuitem) {
                        // If statement that checks if the object belongs to a certain subcategory 
                        if ($menuitem["subcategory"] === "Förrätt") {
                            // Prints information of menuitem
                ?>
                            <tr>
                                <td><?= $menuitem["name"] ?></td>
                                <td class="centered ten"><?= $menuitem["price"] ?> kr</td>
                                <td class="hidden-mobile"><?= $menuitem["description"] ?></td>
                                <td class="change"><a class="change-btn" href="editmenuitem.php?id=<?= $menuitem["id"] ?>">Ändra</a></td>
                                <td class="delete"><a class="delete-btn" href="deletemenuitem.php?id=<?= $menuitem["id"] ?>">Radera</a></td>
                            </tr>
                <?php
                        }
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

        <!-- Table for main courses -->
        <h3>Huvudrätter</h3>
        <table>
            <thead>
                <tr>
                    <td class="twentyfive">Namn</td>
                    <td class="centered">Pris</td>
                    <td class="hidden-mobile">Beskrivning</td>
                    <td class="change sr-only">Ändra</td>
                    <td class="delete sr-only">Radera</td>
                </tr>
            </thead>
            <tbody>
                <?php
                // If statement that if a certain key in the array does not exist
                if (!array_key_exists("message", $data)) {
                    // For each that loops through all objects in the array
                    foreach ($data as $menuitem) {
                        // If statement that checks if the object belongs to a certain subcategory 
                        if ($menuitem["subcategory"] === "Huvudrätt") {
                            // Prints information of menuitem
                ?>
                            <tr>
                                <td><?= $menuitem["name"] ?></td>
                                <td class="ten centered"><?= $menuitem["price"] ?> kr</td>
                                <td class="hidden-mobile"><?= $menuitem["description"] ?></td>
                                <td class="change"><a class="change-btn" href="editmenuitem.php?id=<?= $menuitem["id"] ?>">Ändra</a></td>
                                <td class="delete"><a class="delete-btn" href="deletemenuitem.php?id=<?= $menuitem["id"] ?>">Radera</a></td>
                            </tr>
                <?php
                        }
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

        <!-- Table for desserts -->
        <h3>Desserter</h3>
        <table>
            <thead>
                <tr>
                    <td class="twentyfive">Namn</td>
                    <td class="centered">Pris</td>
                    <td class="hidden-mobile">Beskrivning</td>
                    <td class="change sr-only">Ändra</td>
                    <td class="delete sr-only">Radera</td>
                </tr>
            </thead>
            <tbody>
                <?php
                // If statement that if a certain key in the array does not exist
                if (!array_key_exists("message", $data)) {
                    // For each that loops through all objects in the array
                    foreach ($data as $menuitem) {
                        // If statement that checks if the object belongs to a certain subcategory 
                        if ($menuitem["subcategory"] === "Dessert") {
                            // Prints information of menuitem
                ?>
                            <tr>
                                <td><?= $menuitem["name"] ?></td>
                                <td class="ten centered"><?= $menuitem["price"] ?> kr</td>
                                <td class="hidden-mobile"><?= $menuitem["description"] ?></td>
                                <td class="change"><a class="change-btn" href="editmenuitem.php?id=<?= $menuitem["id"] ?>">Ändra</a></td>
                                <td class="delete"><a class="delete-btn" href="deletemenuitem.php?id=<?= $menuitem["id"] ?>">Radera</a></td>
                            </tr>
                <?php
                        }
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
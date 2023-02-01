<?php
/*
*Created by Sofia Widholm. 
*Webbutveckling III, Webbutveckling, Mittuniversitetet.
*Last update 2022-06-02
*/
?>

<?php
// Initializes a new curl session, return a handle (the varible) to use.
$curl = curl_init();

// Options for transfer

// The URL to the webservice
$url = "https://studenter.miun.se/~sowi2102/writeable/dt173g/projekt/webservice/bookingapi.php?id=" . $_GET['id'];
curl_setopt($curl, CURLOPT_URL, $url);
// Which request method to use
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
// Returns the transfer as a string (to be saved with curl_exec)
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Execute the curl session and save returned data in a variable
$response = curl_exec($curl);
// Close the curl session, deletes the handle
curl_close($curl);

// Convert the returned data from JSON
$response = json_decode($response);

// Redirect to booking page
header('Location: bookings.php');
?>
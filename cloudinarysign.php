<?php 
// Import Cloudinary Environmental Variables
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/includes/cloudinary.env.php";
use Cloudinary\Api\ApiUtils;

// Example: Making sure we are getting a GET request
if (!isset($_GET)) {
    http_response_code(400);
    die("This request is not eligible.");
} 

// Example: Checking if data parameters are set correctly
if (!isset($_GET["data"]) || !isset($_GET["data"]["source"]) 
    || $_GET["data"]["source"] !== "uw" || !isset($_GET["data"]["timestamp"])) {
    http_response_code(400);
    die("This request is missing required parameters.");
};

// Example: Is the session expired? Use a timer to check the session.
session_start();
$cloudinary_timer_duration = 300;
if (!isset($_SESSION['cloudinary_timer_start']) 
    || (time() - $_SESSION['cloudinary_timer_start'] > $cloudinary_timer_duration)
    || ($_GET["data"]["timestamp"] - $_SESSION['cloudinary_timer_start'] > $cloudinary_timer_duration)
) {
    http_response_code(401);
    die("This session has expired. Please refresh the page and try again.");
}

// Since we only allow one preset, fill it in on the server side
$PARAMS = $_GET;
$PARAMS["uploadPreset"] = $CLOUDINARY_UPLOAD_PRESET;

 ApiUtils::signRequest($PARAMS["data"], (object) array(
    "apiSecret" => $CLOUDINARY_API_SECRET,
    "apiKey" => $CLOUDINARY_API_KEY,
    "signatureAlgorithm" => "sha256",
));

echo $PARAMS["data"]["signature"];
?>
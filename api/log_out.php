<?php
$accessToken = $_POST["accessToken"];
$acc = explode("|", $accessToken)[1];
$token = explode("|", $accessToken)[0];

include $_SERVER["DOCUMENT_ROOT"] . "/Gridwell_mobile/api/mysql.php";

$conn = new mysqli($server_name, $username, $password, 'Mobile', $port);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
mysqli_query($conn, "set character set utf8");

$search = "SELECT * FROM permission where account='$acc'";
$result = $conn->query($search);
if (mysqli_num_rows($result)) {
    $res = $result->fetch_assoc();
    if ($token === hash("sha256", $res["password"])) {
        $message = array("valid" => true);
    } else {
        $message = array("valid" => false);
    }
} else {
    $message = array("valid" => false);
}
echo json_encode($message);
$conn->close();

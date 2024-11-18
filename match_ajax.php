<?php
require_once "config.php";

$team = $_POST['value1'];

$sql = "SELECT DISTINCT team FROM $team";

$result = $conn->query($sql);

$response = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = array(
            'team1' => $row['team'], 
            'team2' => $row['team']
        );
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>

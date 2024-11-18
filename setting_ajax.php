<?php
require_once "config.php";

$team1 = $_POST['team1Id'];
$team2 = $_POST['team2Id'];
$match = $_POST['match'];

$response = array();

// Prepare and execute SQL query for team1
$sql = "SELECT distinct players FROM $match WHERE team='$team1'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Add players to response under 'todo' key
        $response['todo'][] = $row['players']; 
    }
}

// Prepare and execute SQL query for team2
$sql1 = "SELECT distinct players FROM $match WHERE team='$team2'";
$result1 = $conn->query($sql1);

if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        // Add players to response under 'in-progress' key
        $response['in-progress'][] = $row['players']; 
    }
}

$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

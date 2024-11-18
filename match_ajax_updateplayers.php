<?php
require_once "config.php";

$team = $_POST['value1'];

$sql1 = "SELECT DISTINCT players FROM ipl WHERE team = '$team'";
$sql2 = "SELECT DISTINCT players FROM world_cup WHERE team = '$team'";

$response = array();

$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        $response[] = array(
            'players' => $row['players']
        );
    }
} else {
    $result2 = $conn->query($sql2);
    if ($result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
            $response[] = array(
                'players' => $row['players']
            );
        }
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>

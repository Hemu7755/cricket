<?php
require_once "config.php";
session_start();
$userid = $_SESSION['id'];
if (!isset($userid) || empty($userid)) {
    header("Location: login.php");
    exit();
}
if (isset($_POST['create'])) {
    header("Location: create_match.php");
}
if (isset($_POST['match'])) {
    header("Location: setting_match.php");
}
if (isset($_POST['home'])) {
    header("Location: admin_page.php");
}
if (isset($_POST['Exit'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
// if (isset($_POST['save'])) {
//     // Assuming $conn is your mysqli connection object
//     $result = array();
//     // Load the HTML content from a file or a string (replace 'example.html' with your actual HTML content)
//     // $html = file_get_contents('./setting_match.php');

//     // Create a DOMDocument object
//     $dom = new DOMDocument();

//     // Load HTML content into the DOMDocument
//     // $dom->loadHTMLFile('setting_match.php');
//     echo $dom ;


//     // Select all <td> elements inside #team11 and #team22
//     $xpath = new DOMXPath($dom);
//     $tdNodes1 = $xpath->query("//table[@id='team11']//td");
//     $tdNodes2 = $xpath->query("//table[@id='team22']//td");

//     // Extract content from each <td> element and store it in the result array
//     foreach ($tdNodes1 as $tdNode) {
//         $result[] = $tdNode->nodeValue;
//     }

//     foreach ($tdNodes2 as $tdNode) {
//         $result[] = $tdNode->nodeValue;
//     }

//     foreach ($result as $player) {
//         $userDetailsQuery = "SELECT team FROM ipl WHERE players='$player'";
//         $userDetailsResult = mysqli_query($conn, $userDetailsQuery);

//         // Check if user details were fetched successfully
//         if ($userDetailsResult) {
//             $userDetails = mysqli_fetch_assoc($userDetailsResult);

//             // Display user details
//             if ($userDetails) {
//                 $teamname = $userDetails['team'];
//                 $teamDetailsQuery = "SELECT sno FROM matchs WHERE team1='$teamname' or team2='$teamname'";
//                 $teamDetailsResult = mysqli_query($conn, $teamDetailsQuery);

//                 // Check if team details were fetched successfully
//                 if ($teamDetailsResult) {
//                     $teamDetails = mysqli_fetch_assoc($teamDetailsResult);

//                     // Display team details
//                     if ($teamDetails) {
//                         $matchplayers = $teamDetails['sno'];
//                         $qry = mysqli_query($conn, "INSERT INTO admin_selected (match_id,select_team,select_players) VALUES ('$matchplayers', '$teamname', '$player')") or die(mysqli_error($conn));
//                         if ($qry) {
//                             echo ""; // Assuming you want to output something here
//                         } else {
//                             echo "insert error";
//                         }
//                     }
//                 }
//             }
//         }
//     }
// }


function generateCard($transaction)

{
    date_default_timezone_set('Asia/Kolkata');
    $startTime = new DateTime($transaction['data'] . ' ' . $transaction['time']);
    $currentTime = new DateTime();
    $remainingTime = $startTime->getTimestamp() - $currentTime->getTimestamp();

    $remainingTimeFormatted = ($remainingTime > 0) ? formatTime($remainingTime) : 'Match Over';
    // Format date as dd-mm-yy
    $formattedDate = date('jS-F-Y', strtotime($transaction['data']));

    // Format time in am/pm format
    $formattedTime = date('h:i A', strtotime($transaction['time']));

    return "
    <div class='col-12'>
        <div class='card' data-remaining-time='$remainingTime'>
            <div class='card-body'>
                <center>
                    <h5 class='card-title'>" . strtoupper($transaction['match']) . "</h5>
                </center>
                <p class='card-text'>
                    <center>
                        <strong style='color:#CEAF1D';>" . strtoupper($transaction['team1']) . " VS  " . strtoupper($transaction['team2']) . "</strong><br>
                    </center>
                    <strong>Date:</strong> $formattedDate<br>
                    <strong>Time:</strong> $formattedTime<br>
                </p>
                <form method='post'> 
                    <input class='nasa1' type='hidden' id='team1' value='" . $transaction['team1'] . "'/>
                    <input class='nasa2' type='hidden' id='team2' value='" . $transaction['team2'] . "'/>
                    <input class='nasa3' type='hidden' id='match' value='" . $transaction['match'] . "'/>                 
                    <button type='button' class='nasa btn' name='activate' id='activate' onClick='handleSubmit(\"" . $transaction['team1'] . "\", \"" . $transaction['team2'] . "\", \"" . $transaction['match'] . "\")'>Select players</button>
                </form>
            </div>
        </div>
    </div>
";
}


function formatTime($seconds)
{
    $interval = new DateInterval('PT' . $seconds . 'S');
    $formattedTime = $interval->format('%h hours, %i minutes, %s seconds');

    return $formattedTime;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>create_Match</title>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.min.css" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Open Sans", sans-serif;
        }

        .header {
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            padding: .8em 2%;
            background-color: navy;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            box-shadow: 10px 10px 10px rgba(0, 0, 0, .5);

        }

        .Btn {
            --black: #000000;
            --ch-black: #141414;
            --eer-black: #1b1b1b;
            --night-rider: #2e2e2e;
            --white: #ffffff;
            --af-white: #f3f3f3;
            --ch-white: #e1e1e1;
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            width: 30px;
            height: 35px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition-duration: .3s;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
            background-color: var(--af-white);
        }

        .sign {
            width: 100%;
            transition-duration: .3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ion-icon {
            width: 17px;
            font-size: 1.2em;
            font-weight: bold;
        }


        .text {
            position: absolute;
            right: 0%;
            width: 0%;
            opacity: 0;
            color: var(--night-rider);
            font-size: 1.2em;
            font-weight: 600;
            transition-duration: .3s;
        }

        .Btn:hover {
            width: 125px;
            border-radius: 5px;
            transition-duration: .3s;
        }

        .Btn:hover .sign {
            width: 30%;
            transition-duration: .3s;
            padding-left: 20px;
        }

        .Btn:hover .text {
            opacity: 1;
            width: 70%;
            transition-duration: .3s;
            padding-right: 10px;
        }

        .Btn:active {
            transform: translate(2px, 2px);
        }

        .h1 {
            margin: 5px 0px;
            ;
        }

        .box1 {
            overflow-x: auto;
            height: 550px;
        }

        .card {
            margin: 5px;
        }

        .card2 {
            margin: 10px 0;
            border: none;
            padding: 15px;
            background-color: navy;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            border: none;
            border-radius: 10px;
            padding: 15px;
        }

        .card-body:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .card-text {
            font-size: 1rem;
            color: #666;
        }

        .running-time {
            /* float: right; */
            /* color: #0E1F5A; */
            color: #ccc;
            font-weight: bold;
            font-size: 20px;
        }

        .box2 {
            overflow-x: auto;
            height: 550px;
        }

        .box123 {
            margin: 10px;
            background-color: navy;
            padding: 10px;
        }

        .table {
            width: 100%;
            margin-bottom: 20px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .table th {
            color: #fff;
            font-weight: bold;
            padding: 10px;
            text-align: center;
        }

        .table td {
            padding: 8px;
        }

        .btn {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <form action="" method="post">
        <header class="header">
            <?php
            $data = mysqli_query($conn, "SELECT name FROM admin_login WHERE id='$userid'");

            if ($data) {
                $userData = mysqli_fetch_assoc($data);
                if ($userData) {
                    $name = strtoupper($userData['name']);
            ?>
                    <p class="card-title" style="font-size: 1.8em; color:#CEAF1D;">Welcome to Dream11, <strong><?php echo $name; ?></strong></p>
            <?php
                } else {
                    echo "<p>No user data found!</p>";
                }
            }
            ?>
            <div class="running-time " id="runningTime"></div>

            <div>

                <button class="Btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    <div class="sign">
                        <ion-icon name="person-outline"></ion-icon>
                    </div>
                    <div class="text">Profile</div>
                </button>
                <!-- <button class="Btn" name="create">
                    <div class="sign">
                        <ion-icon name="create-outline"></ion-icon>
                    </div>
                    <div class="text">Create</div>
                </button> -->
                <button class="Btn" name="match">
                    <div class="sign">
                        <ion-icon name="paw-outline"></ion-icon>
                    </div>
                    <div class="text">Matchs</div>
                </button>

                <button class="Btn" name="home">
                    <div class="sign">
                        <ion-icon name="home-outline"></ion-icon>
                    </div>
                    <div class="text">Home</div>
                </button>
                <button class="Btn" name="Exit">
                    <div class="sign">
                        <ion-icon name="exit-outline"></ion-icon>
                    </div>
                    <div class="text">Logout</div>
                </button>
            </div>
        </header>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <form method="post">
                    <button type="button" name="balance_inquiry_balance" id="balance_inquiry_balance" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </form>
            </div>
            <div class="offcanvas-body">

                <?php
                $userDetailsQuery = "SELECT `name`, mail FROM admin_login WHERE status='1'";
                $userDetailsResult = mysqli_query($conn, $userDetailsQuery);

                // Check if user details were fetched successfully
                if ($userDetailsResult) {
                    $userDetails = mysqli_fetch_assoc($userDetailsResult);

                    // Display user details
                    if ($userDetails) {
                        $userName = $userDetails['name'];
                        $userEmail = $userDetails['mail'];

                        echo "<h3 style='color:#CEAF1D; font-weight:bold'>Welcome, $userName!</h3>";
                        echo "<table class='table'>";
                        echo "<tr><td><img style='width: 25px;  margin-right: 5px;' src='https://cdn-icons-png.flaticon.com/128/482/482138.png'>Email:</td><td>$userEmail</td></tr>";
                        echo "</table>";
                        echo "<p><img style='width: 30px;  margin-right: 5px;' src='https://cdn-icons-png.flaticon.com/128/837/837928.png'>Help And Support</p>";
                        echo "<p><img style='width: 30px;  margin-right: 5px;' src='https://cdn-icons-png.flaticon.com/128/13/13973.png'>How To Play</p>";
                        echo "<p><img style='width: 30px;  margin-right: 5px;' src='https://cdn-icons-png.flaticon.com/128/9422/9422642.png'>Refer And Win</p>";
                        echo "<p><img style='width: 30px;  margin-right: 5px;' src='https://cdn-icons-png.flaticon.com/128/5996/5996522.png'>More</p>";
                    }
                    echo "<button id='logout' class='btn btn-warning'>LOG OUT</button>";
                }
                ?>
                <script>
                    document.getElementById("logout").addEventListener("click", function(event) {
                        event.preventDefault();
                        window.location.href = "http://localhost/cricket/login.php"; // Replace with your target URL
                    });
                </script>
            </div>

        </div>
        <section>
            <div class="row ">
                <div class="col-3 box1">
                    <center>
                        <div class="row">
                            <div class="col-12">
                                <div class="h1">Select Match's</div>
                                <div class="row card2">
                                    <?php
                                    $currentDateTime = date('d-m-y H:i:s');
                                    // Fetch today exams
                                    $todayExams = mysqli_query($conn, "SELECT sno,`match`, team2, team1, data, time, status FROM matchs WHERE status='activate' and DATE(data) = CURDATE() ORDER BY data, time                                ");

                                    while ($todayTransaction = mysqli_fetch_assoc($todayExams)) {
                                        $startDateTime = $todayTransaction['data'] . ' ' . $todayTransaction['time'];
                                        $endDateTime = $todayTransaction['data'] . ' ' . $todayTransaction['time'];

                                        if ($currentDateTime > $endDateTime) {
                                            echo generateCard($todayTransaction, 'danger', 'Time Out');
                                        } else {
                                            echo generateCard($todayTransaction, 'success');
                                        }
                                    }
                                    // Fetch tomorrow exams
                                    $tomorrowExams = mysqli_query($conn, "SELECT sno,`match`, team2, team1,data, time, status 
                                    FROM matchs
                                           WHERE  status='activate' and DATE(data) = DATE_ADD(CURDATE(), INTERVAL 1 DAY) 
                                           ORDER BY data, time");

                                    while ($tomorrowTransaction = mysqli_fetch_assoc($tomorrowExams)) {
                                        $startDateTime = $tomorrowTransaction['data'] . ' ' . $tomorrowTransaction['time'];
                                        $endDateTime = $tomorrowTransaction['data'] . ' ' . $tomorrowTransaction['time'];

                                        if ($currentDateTime > $endDateTime) {
                                            echo generateCard($tomorrowTransaction, 'danger', 'Time Out');
                                        } else {
                                            echo generateCard($tomorrowTransaction, 'success');
                                        }
                                    }
                                    // Fetch upcoming exams
                                    $upcomingExams = mysqli_query($conn, "SELECT sno,`match`, team2, team1,data, time, status 
                                    FROM matchs
                                          WHERE  status='activate' and  DATE(data) > DATE_ADD(CURDATE(), INTERVAL 1 DAY) 
                                          ORDER BY data, time");

                                    while ($upcomingTransaction = mysqli_fetch_assoc($upcomingExams)) {
                                        echo generateCard($upcomingTransaction, 'light');
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </center>
                </div>
                <div class="col-9 box2">
                    <div class="row box123">
                        <div class="col-3" id="todo11">
                            <table id="todo" class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <h3 style='font-weight:bold;color:#FFB457'>Team A</h3>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="team" id="todo1">
                                </tbody>
                            </table>
                        </div>
                        <div class="col-3" id="in-progress22">
                            <table id="in-progress" class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <h3 style='font-weight:bold;color:#FFB457'>Team B</h3>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="team" id="in-progress2">
                                </tbody>
                            </table>
                        </div>
                        <div class="col-3" id="newTeam">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <h3 style='font-weight:bold;color:#FFB457'>MY Team 1</h3>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="team11">
                                </tbody>
                            </table>
                        </div>
                        <div class="col-3" id="newTeam1">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <h3 style='font-weight:bold;color:#FFB457'>MY Team 2</h3>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="team22">
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6"></div>
                        <form action="" method="post">
                            <div class="col-6 text-center" id="save">
                                <button class="btn btn-danger" type="submit" name="save" onclick="storeplayers()">Store the Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".nasa").click(function() {

            });
        });

        function handleSubmit(team1, team2, match) {
            var team1Id = team1;
            var team2Id = team2;
            var match = match;

            var dataToSend = {
                team1Id: team1Id,
                team2Id: team2Id,
                match: match
            };
            console.log(dataToSend);

            // Send AJAX request to fetch data
            $.ajax({
                url: 'setting_ajax.php',
                type: 'POST',
                data: dataToSend,
                dataType: 'json',
                success: function(response) {
                    console.log("AJAX Response:", response); // Check AJAX response

                    // Empty todo and in-progress containers
                    $('#todo tbody').empty();
                    $('#in-progress tbody').empty();
                    $('#team11').empty();
                    $('#team22 ').empty();

                    response['todo'].forEach(function(player) {
                        var playerName = $('<td>', {
                            text: player
                        });

                        var row = $('<tr>').append(playerName);
                        row.addClass("player1");
                        row.attr("draggable", "true");


                        $('#todo tbody').append(row);
                    });

                    response['in-progress'].forEach(function(player) {
                        var playerName = $('<td>', {
                            text: player
                        });

                        var row = $('<tr>').append(playerName);
                        row.addClass("player2")
                        row.attr("draggable", "true")
                        $('#in-progress tbody').append(row);
                    });
                    const players1 = document.querySelectorAll('.player1');
                    players1.forEach(player => {
                        player.addEventListener('dragstart', (e) => {
                            e.dataTransfer.setData('text/plain', player.innerText);
                            e.dataTransfer.setData('player', "player1");
                        });
                    });
                    const players2 = document.querySelectorAll('.player2');
                    players2.forEach(player => {
                        player.addEventListener('dragstart', (e) => {
                            e.dataTransfer.setData('text/plain', player.innerText);
                            e.dataTransfer.setData('player', "player2");

                        });
                    });
                },
                error: function(error) {
                    console.log("AJAX Error:", error);
                }
            });
        }
        document.getElementById('save').style.display = "none";

        const newTeam = document.getElementById('newTeam');

        newTeam.addEventListener('dragover', (e) => {

            e.preventDefault();

        });
        const newTeam1 = document.getElementById('newTeam1');

        newTeam1.addEventListener('dragover', (e) => {

            e.preventDefault();

        });
        const todo = document.getElementById("todo11");

        todo.addEventListener('dragover', (e) => {

            e.preventDefault();
        });

        const inProgress = document.getElementById("in-progress22");

        inProgress.addEventListener('dragover', (e) => {

            e.preventDefault();
        });


        newTeam.addEventListener('drop', (e) => {

            e.preventDefault();

            if (e.dataTransfer.getData('player') == "player1") {
                const team11Id = document.getElementById("team11");
                // Check if the new team already has 11 players
                if (team11Id.childElementCount >= 11) {
                    // Prevent adding more players if the limit is reached
                    return;
                }

                const playerName = e.dataTransfer.getData('text/plain');
                // Check if the player already exists in the new team
                const existingPlayers = Array.from(newTeam.children).map(player => player.innerText.trim());
                if (existingPlayers.includes(playerName.trim())) {
                    // If the player already exists, prevent adding it again
                    return;
                }
                var team11 = document.getElementById("team11");
                var team111 = document.createElement("tr");
                team11.append(team111);
                const selectedPlayer = document.createElement('td');
                selectedPlayer.innerText = playerName;
                selectedPlayer.classList.add('player1');
                selectedPlayer.draggable = true;
                selectedPlayer.addEventListener('dragstart', (event) => {
                    event.dataTransfer.setData('text/plain', selectedPlayer.innerText);
                    event.dataTransfer.setData('player', "player1");

                });
                team111.appendChild(selectedPlayer);
                let todo = document.getElementById("todo");
                // console.log(todo.querySelector('tbody'));
                for (var i = 0; i < todo.querySelector('tbody').querySelectorAll('tr').length; i++) {
                    let data = todo.querySelector('tbody').querySelectorAll('tr')[i].querySelector('td').textContent
                    // console.log(data);
                    if (data == playerName) {
                        // console.log(data);
                        todo.querySelector('tbody').querySelectorAll('tr')[i].remove()
                    }
                }
            }
            if (document.getElementById('team11').childElementCount >= 11 && document.getElementById('team22').childElementCount >= 11) {
                document.getElementById('save').style.display = "block";
            }

        });
        newTeam1.addEventListener('drop', (e) => {

            e.preventDefault();

            if (e.dataTransfer.getData('player') == "player2") {
                const team11Id = document.getElementById("team22");
                // Check if the new team already has 11 players
                if (team11Id.childElementCount >= 11) {
                    // Prevent adding more players if the limit is reached
                    return;
                }

                const playerName = e.dataTransfer.getData('text/plain');
                // Check if the player already exists in the new team
                const existingPlayers = Array.from(newTeam.children).map(player => player.innerText.trim());
                if (existingPlayers.includes(playerName.trim())) {
                    // If the player already exists, prevent adding it again
                    return;
                }
                var team11 = document.getElementById("team22");
                var team111 = document.createElement("tr");
                team11.append(team111);
                const selectedPlayer = document.createElement('td');
                selectedPlayer.innerText = playerName;
                selectedPlayer.classList.add('player2');
                selectedPlayer.draggable = true;
                selectedPlayer.addEventListener('dragstart', (event) => {
                    event.dataTransfer.setData('text/plain', selectedPlayer.innerText);
                    event.dataTransfer.setData('player', "player2");

                });
                team111.appendChild(selectedPlayer);
                let todo = document.getElementById("in-progress");
                // console.log(todo.querySelector('tbody'));
                for (var i = 0; i < todo.querySelector('tbody').querySelectorAll('tr').length; i++) {
                    let data = todo.querySelector('tbody').querySelectorAll('tr')[i].querySelector('td').textContent
                    // console.log(data);
                    if (data == playerName) {
                        // console.log(data);
                        todo.querySelector('tbody').querySelectorAll('tr')[i].remove()
                    }
                }

            }
            if (document.getElementById('team11').childElementCount >= 11 && document.getElementById('team22').childElementCount >= 11) {
                document.getElementById('save').style.display = "block";
            }

        });

        todo.addEventListener("drop", (e) => {
            e.preventDefault();
            const playerName = e.dataTransfer.getData("text/plain");
            const playerType = e.dataTransfer.getData("player");
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to Change!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    if (playerType == "player1") {

                        const newRow = document.createElement("tr");
                        const newPlayer = document.createElement("td");
                        newPlayer.innerText = playerName;
                        newRow.appendChild(newPlayer);
                        newRow.classList.add("player1");
                        newRow.setAttribute("draggable", "true");

                        newRow.addEventListener("dragstart", (event) => {
                            event.dataTransfer.setData("text/plain", newPlayer.innerText);
                            event.dataTransfer.setData("player", "player1");
                        });

                        todo.querySelector("#todo1").appendChild(newRow);
                        let newteam = document.getElementById("newTeam");
                        // console.log(todo.querySelector('tbody'));
                        for (
                            var i = 0; i < newteam.querySelector("tbody").querySelectorAll("tr").length; i++
                        ) {
                            let data = newteam
                                .querySelector("tbody")
                                .querySelectorAll("tr")[i].querySelector("td").textContent;
                            console.log(data);
                            if (data == playerName) {
                                // console.log(data);
                                newteam.querySelector("tbody").querySelectorAll("tr")[i].remove();
                            }
                        }
                    }
                }
            });
        });

        inProgress.addEventListener('drop', (e) => {
            e.preventDefault();
            const playerName = e.dataTransfer.getData('text/plain');
            const playerType = e.dataTransfer.getData('player');

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to Change!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    if (playerType == "player2") {

                        const newRow = document.createElement('tr');
                        const newPlayer = document.createElement('td');
                        newPlayer.innerText = playerName;
                        newRow.appendChild(newPlayer);
                        newRow.classList.add("player2");
                        newRow.setAttribute("draggable", "true");

                        newRow.addEventListener('dragstart', (event) => {
                            event.dataTransfer.setData('text/plain', newPlayer.innerText);
                            event.dataTransfer.setData('player', "player2");
                        });

                        inProgress.querySelector('#in-progress2').appendChild(newRow);
                        let newTeam1 = document.getElementById("newTeam1");
                        // console.log(todo.querySelector('tbody'));
                        for (var i = 0; i < newTeam1.querySelector('tbody').querySelectorAll('tr').length; i++) {
                            let data = newTeam1.querySelector('tbody').querySelectorAll('tr')[i].querySelector('td').textContent
                            console.log(data);
                            if (data == playerName) {
                                // console.log(data);
                                newTeam1.querySelector('tbody').querySelectorAll('tr')[i].remove()
                            }
                        }
                    }
                }
            });
        });
    </script>

    <script>
        function updateRunningTime() {
            var now = new Date();
            var date = now.toDateString();
            var time = now.toLocaleTimeString();
            document.getElementById('runningTime').innerHTML = date + ' ' + time;
        }
        setInterval(updateRunningTime, 1000);
        updateRunningTime();
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php
require_once "config.php";
session_start();
$userid = $_SESSION['id'];
if (!isset($userid) || empty($userid)) {
    header("Location: login.php");
    exit();
}
if (isset($_POST['match'])) {
    header("Location: user_match.php");
}
if (isset($_POST['Exit'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
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
                            <strong style='color:#CEAF1D'>" . strtoupper($transaction['team1']) . " VS  " . strtoupper($transaction['team2']) . "</strong><br>
                        </center>
                        <strong>Price pool: </strong>" .strtoupper($transaction['price_loop'])."<br>
                        <strong>Winners: </strong>" .strtoupper($transaction['winners'])."<br>

                        <strong>Date:</strong> $formattedDate<br>
                        <strong>Time:</strong> $formattedTime<br>
                        
                        <strong>Match Started Time:</strong> <span class='remaining-time'>$remainingTimeFormatted</span>
                    </p>
                </div>
            </div>
        </div>
        ";
}
// if ($transaction['winners'] > 1) {
//     $company_share = ($transaction['price_loop'] * 0.20);
//     $prize_amount = ($transaction['price_loop'] - $company_share) / $transaction['winners'];

//     echo '
//     <label class=\'card-text\' for=\'winner\'>Price Distribution:</label>
//     <select class=\'form-select\' id=\'winner\'>';
//     for ($i = 1; $i <= $transaction['winners']; $i++) {
//         echo '<option class=\'card-text\' value="' . $prize_amount . '">Winner ' . $i . ' Prize Amount: ₹' . $prize_amount . '/-</option>';
//     }

//     echo '</select>';
// }

function generateCard1($transaction)

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
                        <p class='card-title' style='font-size:2em' >" . strtoupper($transaction['match']) . "</p>
                    </center>
                    <p class='card-text'>
                        <center>
                            <strong style='color:#CEAF1D;font-size:1.5em'>" . strtoupper($transaction['team1']) . " VS  " . strtoupper($transaction['team2']) . "</strong><br>
                        </center>
                        <strong style='font-size:1.4em'>Price pool: " .strtoupper($transaction['price_loop'])."</strong><br>
                        <strong style='font-size:1.4em'>Entering Price: " .strtoupper($transaction['enter_price'])."</strong><br>
                        <strong>Winners: </strong>" .strtoupper($transaction['winners'])."<br>
                        <strong>Slots: </strong>" .strtoupper($transaction['enter_members'])."<br>
                        
                        
                        <strong>Date:</strong> $formattedDate<br>
                        <strong>Time:</strong> $formattedTime<br>
                        
                        <strong>Match Started Time:</strong> <span class='remaining-time'>$remainingTimeFormatted</span>
                        <img class='image' src='https://t3.ftcdn.net/jpg/01/45/93/50/240_F_145935017_P4o9VmY6ZCEEibYxN00e1vqxyPet1f9G.jpg'></img>';
                    </p>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>admin_page</title>
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
        }
        .running-time {
            /* float: right; */
            /* color: #0E1F5A; */
            color: #ccc;
            font-weight: bold;
            font-size: 20px;
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
            text-align: center;
        }
        .box1{
            overflow-x: auto;
            height: 550px;
        }
        .card{
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
        }

        .card-text {
            font-size: 1rem;
            color: #666;
        }
        .box2{
            height: 550px;
            overflow-x: auto;
        }
        .image {
            float: right;
            margin-top: -130px;
            width: 150px;
        }
        
    </style>
</head>

<body>
    <form action="" method="post">
    <header class="header">
            <?php
            $data = mysqli_query($conn, "SELECT name FROM user_login WHERE id='$userid'");

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
                $userDetailsQuery = "SELECT `name`, mail,balance FROM user_login WHERE status='1'";
                $userDetailsResult = mysqli_query($conn, $userDetailsQuery);

                // Check if user details were fetched successfully
                if ($userDetailsResult) {
                    $userDetails = mysqli_fetch_assoc($userDetailsResult);

                    // Display user details
                    if ($userDetails) {
                        $userName = $userDetails['name'];
                        $userEmail = $userDetails['mail'];
                        $balance = $userDetails['balance'];

                        echo "<h3 style='color:#CEAF1D; font-weight:bold'>Welcome, $userName!</h3>";
                        echo "<table class='table'>";
                        echo "<tr><td><img style='width: 25px;  margin-right: 5px;' src='https://cdn-icons-png.flaticon.com/128/482/482138.png'>Email:</td><td>$userEmail</td></tr>";
                        echo "<tr><td><img style='width: 20px;  margin-right: 5px;' src='https://cdn-icons-png.flaticon.com/128/493/493389.png'>My Balance:</td><td>₹$balance</td></tr>";
                        echo "<tr><td><img style='width: 20px;  margin-right: 5px;' src='https://cdn-icons-png.flaticon.com/128/12672/12672191.png'>Recently Played:</td><td>2</td></tr>";
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
            
            <div class="row">
                <div class="col-4 box1">
                    <div class="h1">UPCOMING MATCH's</div>
                    <div class="row col-12 card2">
                        <?php
                        $currentDateTime = date('d-m-y H:i:s');

                        // Fetch tomorrow exams
                        $tomorrowExams = mysqli_query($conn, "SELECT sno,`match`,price_loop,winners, team2, team1,data, time, status 
                                FROM matchs
                                           WHERE DATE(data) = DATE_ADD(CURDATE(), INTERVAL 1 DAY) 
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
                        $upcomingExams = mysqli_query($conn, "SELECT sno,`match`,price_loop,winners, team2, team1,data, time, status 
                                FROM matchs
                                          WHERE DATE(data) > DATE_ADD(CURDATE(), INTERVAL 1 DAY) 
                                          ORDER BY data, time");

                        while ($upcomingTransaction = mysqli_fetch_assoc($upcomingExams)) {
                            echo generateCard($upcomingTransaction, 'light');
                        }
                        ?>
                    </div>
                </div>
                <div class="col-8 box1">
                    <div class="h1">TODAY MATCH's</div>
                    <div class="row col-12 card2">
                        <?php
                        $currentDateTime = date('d-m-y H:i:s');

                        // Fetch today exams
                        $todayExams = mysqli_query($conn, "SELECT sno,`match`,price_loop,winners, team2, team1, data, time, status,enter_price,enter_members FROM matchs WHERE DATE(data) = CURDATE() ORDER BY data, time                                ");

                        while ($todayTransaction = mysqli_fetch_assoc($todayExams)) {
                            $startDateTime = $todayTransaction['data'] . ' ' . $todayTransaction['time'];
                            $endDateTime = $todayTransaction['data'] . ' ' . $todayTransaction['time'];

                            if ($currentDateTime > $endDateTime) {
                                echo generateCard1($todayTransaction, 'danger', 'Time Out');
                            } else {
                                echo generateCard1($todayTransaction, 'success');
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var cards = document.querySelectorAll('.card');

            cards.forEach(function(card) {
                var remainingTime = card.getAttribute('data-remaining-time');
                var cardColor = card.getAttribute('data-card-color');
                card.style.backgroundColor = cardColor;

                if (remainingTime > 0) {
                    setInterval(function() {
                        remainingTime--;
                        card.querySelector('.remaining-time').innerText = formatTime(remainingTime);
                    }, 1000);
                } else {
                    card.querySelector('.remaining-time').innerText = 'Time Over';
                    card.querySelectorAll('button').forEach(function(button) {
                        button.disabled = true;
                    });
                }
            });

            function formatTime(seconds) {
                var days = Math.floor(seconds / (3600 * 24));
                var hours = Math.floor((seconds % (3600 * 24)) / 3600);
                var minutes = Math.floor((seconds % 3600) / 60);

                var formattedTime = '';

                if (days > 0) {
                    formattedTime += days + (days === 1 ? ' day ' : ' days ');
                }

                if (hours > 0) {
                    formattedTime += hours + (hours === 1 ? ' hour ' : ' hours ');
                }

                if (minutes > 0) {
                    formattedTime += minutes + (minutes === 1 ? ' minute ' : ' minutes ');
                }

                return formattedTime.trim();
            }

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
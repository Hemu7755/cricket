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
if (isset($_POST['save'])) {
    $match = $_POST['Match'];
    $team1 = $_POST['team1'];
    $team2 = $_POST['team2'];
    $price = $_POST['price'];
    $enterprice = $_POST['enterprice'];
    $entermembers = $_POST['entermembers'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $qry = mysqli_query($conn, "INSERT INTO matchs (`match`, team1, team2,price_loop,enter_price, enter_members, data, time) VALUES ('$match', '$team1', '$team2','$price','$enterprice','$entermembers', '$date', '$time')") or die(mysqli_error($conn));
    if ($qry != "") {
        echo "";
    } else {
        echo "insert error";
    }
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

        .box1 {
            background-color: navy;
            color: #ffffff;
            border: 2px #CEAF1D;
            padding: 10px;
            margin: 100px;
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

            <div>

                <button class="Btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    <div class="sign">
                        <ion-icon name="person-outline"></ion-icon>
                    </div>
                    <div class="text">Profile</div>
                </button>
                <button class="Btn" name="create">
                    <div class="sign">
                        <ion-icon name="create-outline"></ion-icon>
                    </div>
                    <div class="text">Create</div>
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
            <form class="row box1 g-3" method="post">
                <div class="col-4 m-2 position-relative">
                    <label for="Match" class="form-label">MATCH</label>
                    <select id="Match" name="Match" class="form-select" onchange="loadTeams()">
                        <option disabled selected>Choose...</option>
                        <option value="ipl">IPL</option>
                        <option value="world_cup">WORLD CUP</option>
                    </select>
                </div>
                <div class="col-4 m-2 position-relative">
                    <label for="price" class="form-label">PRICE LOOP</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="enter the price loop">
                </div>
                <div class="col-4 m-2 position-relative">
                    <div class="input-group-text"><b>TEAM 1</b></div>
                    <select class="form-control" name="team1" id="team1" onchange="updateTeamOptions1('team1')">
                        <option value="">--Select Team--</option>
                    </select>
                </div>
                <div class="col-4 m-2 position-relative">
                    <div class="input-group-text"><b>TEAM 2</b></div>
                    <select class="form-control" name="team2" id="team2" onchange="updateTeamOptions2('team2')">
                        <option value="">--Select Team--</option>
                    </select>
                </div>
                <!-- <div class="col-6" style="text-align: center;">
                            <div class="input-group">
                                <div class="input-group-text"><b>Team 1</b></div>
                                <select class="form-control" name="team1" id="team1" onchange="updateTeamOptions1('team1')">
                                    <option value="">--Select Team--</option>
                                    <?php
                                    $query = "SELECT DISTINCT team FROM ipl";
                                    $result = mysqli_query($conn, $query);
                                    if (!$result) {
                                        die("Query failed: " . mysqli_error($conn));
                                    }
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $team = $row['team'];
                                    ?>
                                        <option value="<?= $team ?>"><?= $team ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div> -->

                <!-- <div class="col-6" style="text-align: center;">
                            <div class="input-group">
                                <div class="input-group-text"><b>Team 2</b></div>
                                <select class="form-control" name="team2" id="team2" onchange="updateTeamOptions2('team2')">
                                    <option value="">--Select-Team--</option>
                                    <?php
                                    mysqli_data_seek($result, 0);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $team = $row['team'];
                                    ?>
                                        <option value="<?= $team ?>"><?= $team ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div> -->
                
                <div class="col-4 m-2 position-relative">
                    <label for="enterprice" class="form-label">ENTER PRICE</label>
                    <input type="number" class="form-control" id="enterprice" name="enterprice" placeholder="enter the price">
                </div>
                <div class="col-4 m-2 position-relative">
                    <label for="enterprice" class="form-label">MEMBERS</label>
                    <select class="form-control" name="entermembers" id="entermembers">
                        <option value="" disabled selected>--Select members--</option>
                        <option value="50">-- 50 members- --</option>
                        <option value="100">-- 100 members --</option>
                    </select>
                </div>
                <div class="col-4 m-2 position-relative">
                    <label for="date" class="form-label">DATE</label>
                    <input type="date" class="form-control" id="date" name="date">
                </div>
                <div class="col-4 m-2 position-relative">
                    <label for="time" class="form-label">START TIME</label>
                    <input type="time" class="form-control" id="time" name="time">
                </div>
                <center>
                <div class="col-12 mt-3 mb-3">
                    <button type="submit" class="btn btn-danger" name="save" id="save">submit</button>
                </div>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#contestTableModal">
                    Show Contests Table
                </button>
                </center>
                <div class="modal fade" id="contestTableModal" tabindex="-1" aria-labelledby="contestTableModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title display-4" style="color: #000000;" id="contestTableModalLabel">Matchs</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-striped " name="contactstable" id="contactstable">
                                    <thead>
                                        <tr>
                                            <th>S.no</th>
                                            <th>Match</th>
                                            <th>Team 1</th>
                                            <th>Team 2</th>
                                            <th>PoolPrize</th>
                                            <th>Entering price</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $Getdata = mysqli_query($conn, "SELECT `match`, team1,team2,price_loop,enter_members,data,time FROM matchs WHERE status='activate'") or die(mysqli_error($conn));
                                        while ($Getvalue = mysqli_fetch_object($Getdata)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $Getvalue->match; ?></td>
                                                <td><?php echo $Getvalue->team1; ?></td>
                                                <td><?php echo $Getvalue->team2; ?></td>
                                                <td><?php echo $Getvalue->price_loop; ?></td>
                                                <td><?php echo $Getvalue->enter_members; ?></td>
                                                <td><?php echo $Getvalue->data; ?></td>
                                                <td><?php echo $Getvalue->time; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>

                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script>

        function validateDateTime() {
            var dateTimeValue = document.getElementById('data').value + 'T' + document.getElementById('time').value;
            var currentTime = new Date().toISOString().slice(0, 16);
            if (dateTimeValue < currentTime) {
                return false;
            }
            return true;
        }


        function loadTeams() {
            var selectedMatch = document.getElementById("Match").value;
            let fdata = {
                value1: selectedMatch
            };
            $.ajax({
                url: 'match_ajax.php',
                type: 'POST',
                data: fdata,
                dataType: 'json',
                success: function(response) {
                    console.log(response);

                    var select = $('#team1');
                    select.empty();
                    var defaultOption = $('<option>', {
                        value: '',
                        text: '---Select Teams---'
                    });
                    select.append(defaultOption);

                    response.forEach(function(item) {
                        var option = $('<option>', {
                            value: item.team1,
                            text: item.team1
                        });

                        select.append(option);
                    });

                    var select = $('#team2');
                    select.empty();
                    var defaultOption = $('<option>', {
                        value: '',
                        text: '---Select Teams---'
                    });
                    select.append(defaultOption);

                    response.forEach(function(item) {
                        var option = $('<option>', {
                            value: item.team2,
                            text: item.team2
                        });

                        select.append(option);
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function updateTeamOptions1(selectedTeamId) {
            var selectedTeam = document.getElementById(selectedTeamId).value;
            var team2Select = document.getElementById('team2');
            for (var i = 0; i < team2Select.options.length; i++) {
                if (team2Select.options[i].value === selectedTeam) {
                    team2Select.options[i].disabled = true;
                } else {
                    team2Select.options[i].disabled = false;
                }
            }
        }

        function updateTeamOptions2(selectedTeamId) {
            var selectedTeam = document.getElementById(selectedTeamId).value;
            var team1Select = document.getElementById('team1');
            for (var i = 0; i < team1Select.options.length; i++) {
                if (team1Select.options[i].value === selectedTeam) {
                    team1Select.options[i].disabled = true;
                } else {
                    team1Select.options[i].disabled = false;
                }
            }
        }
    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
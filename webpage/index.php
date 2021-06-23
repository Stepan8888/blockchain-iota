<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href='https://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <script src = "script.js"></script>
    <script src="https://embed.twitch.tv/embed/v1.js"></script>
    <title>IOTA Project</title>
    <link rel="stylesheet" href="css/style.css">

    <?php
        $servername = "localhost";
        $username = "root";
        $password = "X34G8gjNabFkcq";
        $dbname = "iotamp_db";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        }

        function getData($conn) {
            $sql = "SELECT energy_used FROM readings";
            $totalEnergy = 0;
                $result = $conn -> query($sql);
                $row = mysqli_fetch_array($result);
                if ($result->num_rows > 0) {
                // output data of each row
                $totalEnergy += $row["energy_used"];
                }
                echo $totalEnergy;
                $conn->close();
        }
    ?> 
</head>

<body>


    <header>
        <div id="trinityBlock" onmouseover="changeItem()" onclick="show('block')" onmouseout="rechangeItem()">
            <span id="fireFly">FireFly</span>
            <div id="trinityLogo"></div>
        </div>
        <div id="blockDiv">
            <span class="teamName" id="block">BLOCK</span>
        </div>

        <div id="timerDiv">
            <div>
                <span id="timer"><?php 
                getData($conn);
                ?></span>
                <span id="kph">Kph</span>
            </div>
        </div>

        <div id="priceDiv">
            <span id="price">0,004 FireFly/Kph</span>
        </div>

        <div id="headsDiv">
            <span class="teamName" id="heads">HEADS</span>
        </div>


    </header>

    <main>
        <div id="tstream">
            <script type="text/javascript">
                  new Twitch.Embed("tstream", {
                    width: "100%",
                    height: "100%",
                    channel: "iotamp",
                    autoplay: "true",
                    allowfullscreen: "true",
                    theme: "dark"
                  });
                </script>


        </div>
        <div id="graphs">
            <div id="graph1">

            </div>
            <div id="graph2">

            </div>
        </div>

    </main>
    <div id="links">
        <table>
            <tr>
                <th><div onclick="show3('block')">Connect with:</div></th>
                <th>Help:</th>
                <th>Powered by:</th>
            </tr>
            <tr>
                <td>
                    <a href="https://discord.com"><img class="logoLink" src="images/discord.png" alt="" /></a>
                    <a href="https://facebook.com"><img class="logoLink" src="images/facebook.png" alt="" /></a>
                    <a href="https://instagram.com"><img class="logoLink" src="images/instagram.png" alt="" /></a>
                    <a href="https://telegram.com"><img class="logoLink" src="images/telegram.png" alt="" /></a>
                </td>
                <td><div onclick="show2('block')"><a title="click">How does it work?</a></div></td>
                <td><a>NHL Stenden</a></td>
            </tr>
            <tr>
                <td></td>
                <td>About us</td>
                <td></td>

            </tr>
        </table>
    </div>
    <footer>
        <span id="date">© 2021</span>
    </footer>

    <div id="gray" onclick="show('none')"></div>
    <div id="gray2" onclick="show2('none')"></div>
    <div id="gray3" onclick="show3('none')"></div>
    <div id="popUp">
        <h2><b>Donate</b></h2>
        <img alt="donate QR code" src=images/qr_donate.png>
    </div>

    <div id="popUp2">
        <h2><b>How does it work?</b></h2>
        <h3>

            My money's in that office, right? If she start giving me some bullshit about it ain't there, and we got to go someplace else and get it, I'm gonna shoot you in the head then and there. Then I'm gonna shoot that bitch in the kneecaps, find out where my goddamn money is. She gonna tell me too. Hey, look at me when I'm talking to you, motherfucker. You listen: we go in there, and that nigga Winston or anybody else is in there, you the first motherfucker to get shot. You understand?
        </h3>
    </div>

    <div id="transactPopUp">
        <h2><b>Incoming transaction</b></h2>
        <div id="transaction">+1m </div>
    </div>




</body>

</html>
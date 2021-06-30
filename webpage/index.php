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
    require "functions/connect.php";

    function getData($conn) {
        $sql = "SELECT ROUND(SUM(energy_used), 2) AS Total FROM readings";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            if ($result->num_rows > 0) {
            // output data of each row
            echo $row["Total"];
            }
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

<!--        <div id="priceDiv">-->
<!--            <span id="price">0,004 FireFly/Kph</span>-->
<!--        </div>        -->
        <?php
        require "functions/connect.php";
        $sql="SELECT iota_usd_price FROM conversions
            ORDER BY id DESC
            LIMIT 1;";
        $resultIotaVal = $conn -> query($sql);
        $counter = 0;
        while($row=$resultIotaVal->fetch_assoc()){
            ?>
            <div id="priceDiv">
                <span id="price" title=""><?php echo $row["iota_usd_price"]?> Iota/KPH</span>
            </div>
<?php
        }
?>
        <div id="headsDiv">
            <span class="teamName" id="heads">HEADS</span>
        </div>


    </header>

    <main>
    <?php
    require "functions/connect.php";

    $sql = "SELECT twitch FROM sensors";
    $result = $conn -> query($sql);
    $counter = 0;
    if($result->num_rows >0) {
        while($row = $result->fetch_assoc()) {
        ?>   
        <div class = "tstream" id="tstream<?php echo $counter;?>">
           <iframe width="100%" height="100%" src="<?php echo $row['twitch']?>?autoplay=true" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    <?php
         }
    }
    ?>
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
                <td><div id="click" onclick="show2('block')">How does it work?</div></td>
                <td><a href="https://www.reddit.com/r/Stenden/">NHL Stenden</a></td>
            </tr>
            <tr>
                <td></td>
                <td><a href="https://i.pinimg.com/originals/55/10/54/551054340cdd3a9ef4452ec51b513085.jpg">About us</a></td>
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
        <?php
        require "functions/connect.php";
        // Create connection
        $sql ="SELECT wallet_address, id FROM sensors";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            
             while($row = $result  -> fetch_assoc()) {
                
                
                echo '<span id="qrText">
              <p>Sensor №' . $row["id"].'</p>
              <p>' . $row["wallet_address"] . '</p>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . $row["wallet_address"] . '">
                </span>';
                
                //$counter++;
                //echo '<img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . $row["wallet_address"] . '">';
            }
        }
        $conn -> close();
        ?>
    </div>

    <div id="popUp2">
        <h2><b>How does it work?</b></h2>
        <h3>
            Its really simple dont be shy :<br><br>
            You can make a donation by clicking the Firefly logo in the top-left of the page. It will bring up the popUp window with QR codes. By scanning the QR code you can make a donation in IOTAs. Alternatively, you can make a transaction by entering the wallet adress manually. When transaction gets processed you will see the amount of kwH (which depends on the current kwH/IOTA conversion rate) deposited on the sensor on the live video feed. Enjoy, and thanks for your donations!           
        </h3>
    </div>

    <div id="transactPopUp">
        <h2><b>Incoming transaction</b></h2>
        <div id="transaction">+1m </div>
    </div>




</body>

</html>
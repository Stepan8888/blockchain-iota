// var done=false;
var test = 0;
var testSelect = 0;

const ttn = require("ttn");
// const connectionDb = require('./connection.js');
const {ClientBuilder} = require('@iota/client');
const CoinGecko = require('coingecko-api');


const appID = "iotamp";
const accessKey = "ttn-account-v2.ul6ObOOpCplayGGoggQBrvQjh7B30UpX7Vbw_bsJ0uY";
var nrOfTimesRun = 0;
var lastRecordedBalance = 0;
var runTime = 0;
var kwhToSend=0;
var incomingBalanceGlobal=0;

function sendDataToTTN(kwh) {
    try {
        nrOfTimesRun++;
        console.log("Send data method started");
        console.log("Number of times run " + nrOfTimesRun);
      ttn.data(appID, accessKey)
            .then(function (client) {
                console.log(client);
                console.log("before client on");
                client.on("uplink", function (devID, payload) {
                    console.log("Received uplink from ", devID)
                    // console.log(payload)
                    // if (incomingBalanceGlobal > lastRecordedBalance) {

                        // console.log("last recorded balance " + lastRecordedBalance);
                        // console.log("new balance "+ incomingBalanceGlobal);
                       client.send("new-adri-device", convertDecimalToHex(kwh));
                    client.off("close");
                        // kwhToSend=0;
                        // lastRecordedBalance=incomingBalanceGlobal;
                    // }

                })
            })
            .catch(function (error) {
                console.error("Error", error)
                process.exit(1)
            })
    } catch (exception_var) {
        console.log("" + exception_var);
    }
}


function convertDecimalToHex(decimal) {


    let hexadecimal;
    // console.log("hexadecimal working "+decimal);
    const size = 8;
// console.log("Value received "+decimal);
    if (decimal >= 0) {
        hexadecimal = decimal.toString(16);
        while ((hexadecimal.length % size) !== 0) {
            hexadecimal = "" + 0 + hexadecimal;
        }
        return hexadecimal;
    } else {
        hexadecimal = Math.abs(decimal).toString(16);
        while ((hexadecimal.length % size) !== 0) {
            hexadecimal = "" + 0 + hexadecimal;
        }
        let output = '';
        for (i = 0; i < hexadecimal.length; i++) {
            output += (0x0F - parseInt(hexadecimal[i], 16)).toString(16);
        }
        output = (0x01 + parseInt(output, 16)).toString(16);
        return output;
    }
}

async function run() {

    var iotaValue = 0;
    await getIotaValue().then(function (elem) {
        iotaValue = elem;
    }).catch((err) => setImmediate(() => {
        throw err;
    }));

    // console.log(iotaValue);


    // client will connect to testnet by default
    const client = new ClientBuilder()
        .node('https://chrysalis-nodes.iota.org')
        .build();


    const incomingBalanceJson = await client.getAddressBalance('iota1qz4qx5xrl59wnnvswxk4mjvhjkdk25yveft3us2hgxd5tn2l6gz4vnwld2d');

    var incomingBalance = Number(incomingBalanceJson.balance.toString());
    incomingBalanceGlobal=incomingBalance;

    if (runTime == 0) {
        // lastRecordedBalance = incomingBalance
        runTime++;
        console.log("nr of times runed " + runTime);
    } else {
        // console.log("incoming balance " + incomingBalance);
        // console.log("current balance " + lastRecordedBalance);
        // incomingBalance=incomingBalance+10;

        if (incomingBalance > lastRecordedBalance) {

            console.log("new balance "+incomingBalance);
            console.log("last recorder balance "+lastRecordedBalance);
            //We check how many Iotas has been added to our wallet
            var amountOfIotasReceived = incomingBalance.balance - lastRecordedBalance;

            //We convert it to kwh
            var kwhConv = ((amountOfIotasReceived / 10000) * iotaValue) / 13.19;
            var roundedKwh = Math.round(kwhConv);
            kwhToSend=roundedKwh;

            await sendDataToTTN(roundedKwh);
            // //We assign new balance to old one
            lastRecordedBalance = incomingBalance;
            console.log("Balance after converting power " + lastRecordedBalance);
        }
    }


    test++;

}

async function getIotaValue() {

    //2. Initiate the CoinGecko API Client
    const CoinGeckoClient = new CoinGecko();

    //3. Make calls
    return new Promise(function (resolve) {
        async function cos() {
            let dataObt = await CoinGeckoClient.simple.price({
                ids: ['iota'],
                vs_currencies: ['usd'],
            });
            // console.log(dataObt);
            var keys = Object.keys(dataObt.data);
            var subkeys = Object.keys(dataObt.data[keys[0]]);
            var currentIotaValue = dataObt.data[keys[0]][subkeys[0]];
            // console.log(currentIotaValue);
            resolve(currentIotaValue);
        }

        cos();
    });

}


var call_print_data = () => new Promise((resolve, reject) => {
    var count = 0;
    var interval = setInterval(async () => {
        var res = await run();
        // var sendData=await sendDataToTTN();
        count += 1;
        console.log(count);

    }, 5000); // 10 sec interval
});


async function mainTest() {
    process.stderr.write("--Start--")
    var data = await call_print_data(); // The main function will wait 5 minutes here
    // console.log(data)
}

mainTest();






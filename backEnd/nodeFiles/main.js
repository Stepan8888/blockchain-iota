
// var done=false;
var test = 0;
var testSelect = 0;

const ttn = require("ttn");

const appID = "iotamp";
const accessKey = "ttn-account-v2.ul6ObOOpCplayGGoggQBrvQjh7B30UpX7Vbw_bsJ0uY";

async function run() {

    var iotaValue = 0;
    await getIotaValue().then(function (elem) {
        iotaValue = elem;
    }).catch((err) => setImmediate(() => {
        throw err;
    }));
    function sendDataToTTN(kwh) {
        try{
            console.log("Send data method started");
            ttn.data(appID, accessKey)
                .then(function (client) {
                    console.log("then do smth");
                    client.on("uplink", function (devID, payload) {
                        console.log("Received uplink from ", devID)
                        console.log(payload)

                        client.send("new-adri-device", convertDecimalToHex(kwh))
                    }).catch(function (error){
                        console.error("Error", error)

                    })
                })
                .catch(function (error) {
                    console.error("Error", error)
                    process.exit(1)
                })
        }catch(exception_var){
            console.log(""+exception_var);
        }

    }

    function convertDecimalToHex(decimal) {


        let hexadecimal;
        console.log("hexadecimal working "+decimal);
        const size = 8;
        console.log("Value received "+decimal);
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

    // console.log(iotaValue);

    const connectionDb = require('./connection.js');
    const { ClientBuilder } = require('@iota/client');


    // client will connect to testnet by default
    const client = new ClientBuilder()
        .node('https://chrysalis-nodes.iota.org')
        .build();

    const outputs = await client.getAddressOutputs('iota1qz4qx5xrl59wnnvswxk4mjvhjkdk25yveft3us2hgxd5tn2l6gz4vnwld2d');

    // console.log(outputs);

    for (var i = 0; i < outputs.length; i++) {

        const output = await client.getOutput(outputs[i]);
        var transactionId = output.transactionId;
        var iotaAmount = output.amount;
        var kwhConv = ((iotaAmount / 10000) * iotaValue) / 13.19;
        var roundedKwh=Math.round(kwhConv);
        // console.log(kwhConv);
        // console.log(output);


        // console.log(transactionId);
        connectionDb.selectTransactions(transactionId).then(function (rows) {
            if (rows.length == 0) {
                connectionDb.insertTransaction(transactionId, iotaValue, iotaAmount, roundedKwh);
                sendDataToTTN(roundedKwh);
            }
            testSelect++;
            // console.log(rows);
        }).catch((err) => setImmediate(() => {
            throw err;
        }));

    }

    test++;
    // console.log(test);
    // console.log("Select run " + test++);
    done = true;
    // https://chrysalis-nodes.iota.org
}

async function getIotaValue() {
    const CoinGecko = require('coingecko-api');

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
        count += 1;

        // if (count === 1) { // if it has been run 5 times, we resolve the promise
        //     clearInterval(interval);
        //     resolve(res); // result of promise
        // }
    }, 10000); // 10 sec interval
});


async function main() {
    process.stderr.write("--Start--")
    var data = await call_print_data(); // The main function will wait 5 minutes here
    // console.log(data)
}
main();
// run();



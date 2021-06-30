const {data} = require("ttn");


const appID = "iotamp";
const accessKey = "ttn-account-v2.bafaMl5TmV5rcphbIuVcsDCV3uGDsfy5R2beWQTRx4s";

// discover handler and open mqtt connection
const main = async function () {
    const client = await data(appID, accessKey)
    function conn() {
        return new Promise(resolve => {
                client.on("connect", function () {
                    console.log("Connection established");
                })
                resolve();
        });
    }
    function send() {
        return new Promise(resolve => {
            setTimeout(() => {
                client.send("new-adri-device", convertDecimalToHex(10));
                resolve();
            }, 5000);
        });
    }
    function close() {
        return new Promise(resolve => {
            client.close(true, function () {
                console.log("Conn closed");
                resolve();
            });
        });
    }
    conn().then(send).then(close);
}
main().catch(function (err) {
    console.error(err)
    process.exit(1)
})
    

function convertDecimalToHex(decimal) {
    let hexadecimal;
    const size = 8;

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
        for (let i = 0; i < hexadecimal.length; i++) {
            output += (0x0F - parseInt(hexadecimal[i], 16)).toString(16);
        }
        output = (0x01 + parseInt(output, 16)).toString(16);
        return output;
    }
}
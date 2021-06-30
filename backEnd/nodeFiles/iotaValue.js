
const CoinGecko = require('coingecko-api');
const connectionDb = require('./connection.js');





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


async function insertIotaValue(){
    var iotaValue = 0;
    await getIotaValue().then(function (elem) {
        iotaValue = elem;
    }).catch((err) => setImmediate(() => {
        throw err;
    }));

    var currentKwhToIotaVal = (iotaValue) / 13.19;

    await connectionDb.updateIotaValue(currentKwhToIotaVal);

}
var run_update_iota_value = () => new Promise((resolve, reject) => {
    var count = 0;
    var interval = setInterval(async () => {
        var insert = await insertIotaValue();
        count += 1;
        console.log(count);

    }, 7500000); // 125 min interval / 7500 sec interval
});

async function runFile() {
    process.stderr.write("--Start-- \n")
    var iotaVal=await run_update_iota_value();
}

runFile();
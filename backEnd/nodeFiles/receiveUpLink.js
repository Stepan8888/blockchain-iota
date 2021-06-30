const mysql = require('mysql');
const ttn = require("ttn");
const appID = "iotamp";
const accessKey = "ttn-account-v2.bafaMl5TmV5rcphbIuVcsDCV3uGDsfy5R2beWQTRx4s";

const con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "iotamp_db"
});

function receiveUpLink() {
    ttn.data(appID, accessKey)
        .then(function (client) {
            client.on("uplink", function (devID, payload) {
                let energyStored = payload.payload_fields["energyStored"];
                let energyUsed = payload.payload_fields["energyUsed"];
                let date = new Date().toLocaleString().replace(",", "").replace(/:.. /, " ");
                insertSensorInformation(energyStored, energyUsed, date);
            })
        })
        .catch(function (error) {
            console.error("Error", error)
            process.exit(1)
        })
}

function insertSensorInformation(energyStored, energyUsed, date) {
    (async () => {
        const sensorId = await getSensorId();
        const sql = "INSERT INTO readings (sensor_id, energy_purchases, energy_used, update_date) VALUES (?, ?, ?, ?)";
        con.query(sql, [sensorId, energyStored, energyUsed, date], function (err, result) {
            if (err) throw err;
            console.log("Number of records inserted: " + result.affectedRows);
        });
    })();
}

function getSensorId() {
    return new Promise(function (resolve, reject) {
        con.query("SELECT id FROM sensors WHERE sensor_name=?", ["new-adri-device"], function (err, result) {
            if (err) {
                reject(err);
            } else {
                resolve(result[0].id);
            }
        });
    });
}

receiveUpLink();

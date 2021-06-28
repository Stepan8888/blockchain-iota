const { request } = require('https');
const mysql = require('mysql');
const ttn = require("ttn");

const appID = "iotamp";
const accessKey = "ttn-account-v2.ul6ObOOpCplayGGoggQBrvQjh7B30UpX7Vbw_bsJ0uY";

const con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "X34G8gjNabFkcq",
    database: "iotamp_db"
});
// npm install --save ttn
const connectToDb = function connectToDatabase() {
    con.connect(function (err) {
        if (err) throw err;
        console.log("connected!");
    });
}
function sendDataToTTN(kwh) {
    ttn.data(appID, accessKey)
        .then(function (client) {
            client.on("uplink", function (devID, payload) {
                console.log("Received uplink from ", devID)
                console.log(payload)

                client.send("new-adri-device", convertDecimalToHex(kwh))
            })
        })
        .catch(function (error) {
            console.error("Error", error)
            process.exit(1)
        })
}

function convertDecimalToHex(decimal) {
    let hexadecimal;
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

function login(form) {
    var user = form.username.value;
    var pass = form.password.value;
    var sql_query = `SELECT * FROM users WHERE user_name ='${user}' AND password ='${pass}'`;
    connectToDb.query(sql_query, function (err, result) {
        if (err) throw err;
    });

}

const selectTransactions = function findTransaction(transactonId) {
    return new Promise(function (resolve, reject) {
        // The Promise constructor should catch any errors thrown on
        // this tick. Alternately, try/catch and reject(err) on catch.

        var query_str =
            `SELECT crypto_name FROM conversions WHERE crypto_name='${transactonId}'`;

        // var query_var = [name];

        con.query(query_str, function (err, rows, fields) {
            // Call reject on error states,
            // call resolve with results
            if (err) {
                return reject(err);
            }
            console.log(rows);
            resolve(rows);
        });
    });
}
// getLastRecord().then(function(rows) {
//     // now you have your rows, you can see if there are <20 of them
//     console.log(rows);
// }).catch((err) => setImmediate(() => { throw err; }));


// getEmployeeNames = function selectTransactions(outputId, callback) {
//     return new Promise(function (resolve, reject) {
//             con.query(
//                     `SELECT crypto_name FROM conversions`,
//                 function (err, rows) {
//                     if (rows === undefined) {
//                         reject(new Error("Error rows is undefined"));
//                     } else {
//                         resolve(rows);
//                     }
//                 }
//             )
//         }
//     )
// }
// getEmployeeNames()
//     .then(function (results) {
//         return render;
//     })
//     .catch(function (err) {
//         console.log("Promise rejection error: " + err);
//     })
// render = function (results) {
//     for (var i in results) console.log(results[i])
// }


// selectTransactions("3db5bd50759db2cd15515fbeeb955c4c1eeb38111f738d5fe7eed664ec53ccbf", function (a) {
//     console.log(a);
//     return a;
// })

const insertTransaction = function instTransaction(transactionId,iotaValue,iotaAmount,kwh) {
    // console.log(transactionId);
    // let id = transactionId;
    // console.log(id);
    //
    // var sql = "INSERT INTO conversions (crypto_name, rate_to_euro,last_updated) VALUES (?, 'Highway 37',null)";
    // con.query(sql, [id], function (err, result) {
    //     if (err) throw err;
    //     console.log("1 record inserted");
    // });

    return new Promise(function (resolve, reject) {
        var query_str =
            "INSERT INTO conversions (crypto_name, iota_usd_price,iota_amount,kwh,last_updated) VALUES (?, ?,?,?,null)";

        var query_var = [transactionId,iotaValue,iotaAmount,kwh];
        console.log("Data inserted!!!!!!!!!!!!!!!!!!!!!!");
        sendDataToTTN(kwh);

        con.query(query_str, query_var, function (err, rows, fields) {
            // Call reject on error states,
            // call resolve with results
            if (err) {
                return reject(err);
            }
            resolve(rows);
        });
    });
}
const endConnection = function endConnection() {
    con.end()
};

module.exports = {
    con: con,
    connectToDb: connectToDb,
    selectTransactions: selectTransactions,
    insertTransaction: insertTransaction,
    endConnection: endConnection,
    // deleteFromDb: deleteFromDb,
    // getReadingFromDb: getReadingFromDb,
}

// function selectQuery(outputId, callback) {
//     outputId = "iota1qz4qx5xrl59wnnvswxk4mjvhjkdk25yveft3us2hgxd5tn2l6gz4vnwld2d";
//     con.query(`SELECT crypto_name FROM conversions WHERE crypto_name='${outputId}'`, function (err, result, fields) {
//         // console.log("chjik");
//         if (err) callback(err);
//         // console.log(result);
//         var numRows = result.length;
//         console.log(numRows);
//         // return numRows;
//         // callback(numRows);
//         // for(var i=0;i<result.length;i++){
//         //     if (result[i].crypto_name == outputId) {
//         //         // console.log(result[i]);
//         //         // break;
//         //         return true;
//         //     }
//         // }
//         // result.forEach((row) => {
//         //     if (row.crypto_name == outputId) {
//         //         // return true;
//         //     }
//         // });
//         // console.log(result);
//         // console.log(fields);
//         // console.log(fields);
//     });
//     // return false;
// }

// const deleteFromDb = function deleteFromSensorsTable(lora_key) {
//     var sql_query = `DELETE FROM sensors WHERE lora_key="${lora_key}"`;
//     connectToDb.query(sql_query, function (err, result) {
//         if (err) throw err;
//         return "Deleted: " + result.rows;
//     });
// };
//
// const getReadingFromDb = function getReading(sensor_id) {
//     var sql_query = `SELECT energy_used FROM readings WHERE sensor_id="${sensor_id}"`;
//     connectToDb.query(sql_query, function (err, result) {
//         if (err) throw err;
//         return result.fields;
//     });
// }
//
// function getId() {
//     var id;
//     const query = "SELECT id FROM sensors";
//     connectToDb.query(query, [id], function (err, result) {
//         if (err) throw err;
//         var text = document.getElementsByClassName('card-title');
//         text.innerHTML = id;
//     }
// }
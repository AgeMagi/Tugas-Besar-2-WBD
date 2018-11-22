const express = require('express');
const mysql = require ('mysql');

//Create connection
const db = mysql.createConnection({
	host		: '127.0.0.1',
	user		: 'root',
	password	: '',
	database	: 'webservice_bank' 

});

// //Connect
// db.connect((err)=>{
// 	if(err){
// 		throw err;
// 	}
// 	console.log('MySql Connected...');
// });

const bank = express();

db.connect(function(err) {
	if (err) throw err;
	var sql = "INSERT INTO nasabah (nama, nomor_kartu,saldo) VALUES ('Yasya', '10','1000')";
	db.query(sql, function (err, result) {
	  if (err) throw err;
	  console.log("1 record inserted into nasabah, ID: " + result.insertId);
	});
  });

// //Create DB
// bank.get('/createdb',(req,res)=>{
// 	let sql = 'CREATE DATABASE tiral_db';
// 	db.query(sql,(err,result)=>{
// 		if(err) throw err;
// 		console.log(result);
// 		res.send('database created..');
// 	});
// });

bank.listen('5000',()=> {
	console.log('Server started on port 5000');
});
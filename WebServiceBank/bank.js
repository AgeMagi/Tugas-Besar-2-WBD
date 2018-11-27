const express = require('express');
const mysql = require ('mysql');
const bodyParser = require ('body-parser');

//Create connection
const db = mysql.createConnection({
	host		: '127.0.0.1',
	user		: 'root',
	password	: '',
	database	: 'webservice_bank' 
});

const app = express();

app.use(bodyParser.urlencoded({extended:false }));
app.use(bodyParser.json());


app.get('/insertdb',(req,res) => {
	let sql = "INSERT INTO nasabah (nama, nomor_kartu,saldo) VALUES ('Yasya', '9','1000')";
	let query = db.query(sql, function (err, result) {
	  if (err) throw err;
	  console.log(result);
	  res.send("1 record inserted into nasabah, ID: " + result.insertId);
	});
  });

app.get('/bank',(req,res)=>{
	const all = "SELECT * FROM nasabah";
	db.query(all,(err,rows,fields)=>{
		console.log("Fetched successfully");
		res.json(rows);
	});
	
});

app.get('/bank/:nomor_kartu',(req,res)=>{
	console.log("Fetching user with id:" + req.params.nomor_kartu);

	const nokartu = req.params.nomor_kartu;
	const queryselect = "SELECT * FROM nasabah WHERE nomor_kartu=?";
	db.query(queryselect,[nokartu],(err,rows,fields)=>{
		if (err){
			console.log("Failed to query for users: "+err)
			res.sendStatus(500);
			return;
			//throw err
		}

		const nasabah = rows.map((row)=> {
			return {nama: row.nama, nomorKartu: row.nomor_kartu, saldo: row.saldo};
		});

		console.log("Fetched successfully");
		res.json(rows)});
});

app.post('/validation',(req,res)=>{

	const noKartu = req.body.nomor_kartu;

	const queryselect = "SELECT * FROM nasabah WHERE nomor_kartu=?";
	db.query(queryselect,[noKartu],(err,rows,fields)=>{
		if (err){
			console.log("Failed to query for users: "+err)
			res.sendStatus(500);
			return;
			//throw err
		};

		if (rows.length==0){
			res.send(JSON.stringify({nomor_kartu: "invalid"}));
		}else{
			res.send(JSON.stringify({nomor_kartu: "valid"}));
		}
	});
});

app.listen('5000',()=> {
	console.log('Server started on port 5000');
});
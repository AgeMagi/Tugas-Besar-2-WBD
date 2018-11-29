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

app.use(express.urlencoded({extended:false}));
app.use(express.json());
app.use(function(req, res, next) {
	res.header('Access-Control-Allow-Origin', '*');
	res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
	next();
})

app.get('/insertdb',(req,res) => {
	let sql = "INSERT INTO customer (nama, card_number,saldo) VALUES ('Yasya', '9','1000')";
	let query = db.query(sql, function (err, result) {
	  if (err) throw err;
	  console.log(result);
	  res.send("1 record inserted into customer, ID: " + result.insertId);
	});
  });

app.get('/bank',(req,res)=>{
	const all = "SELECT * FROM customer";
	db.query(all,(err,rows,fields)=>{
		console.log("Fetched successfully");
		res.json(rows);
	});
	
});

app.get('/bank/:card_number',(req,res)=>{
	console.log("Fetching user with id:" + req.params.card_number);

	const nokartu = req.params.card_number;
	const queryselect = "SELECT * FROM customer WHERE card_number=?";
	db.query(queryselect,[nokartu],(err,rows,fields)=>{
		if (err){
			console.log("Failed to query for users: "+err)
			res.sendStatus(500);
			return;
			//throw err
		}

		const customer = rows.map((row)=> {
			return {nama: row.nama, nomorKartu: row.card_number, saldo: row.saldo};
		});

		console.log("Fetched successfully");
		res.json(rows)});
});

app.post('/validation',(req,res)=>{
	if (!req.body) return res.sendStatus(400);
	const noKartu = req.body.card_number;
	console.log(req.body);
	console.log(noKartu);
	const queryselect = "SELECT * FROM customer WHERE card_number=?";
	db.query(queryselect,[noKartu],(err,rows,fields)=>{
		if (err){
			console.log("Failed to query for users: "+err)
			res.sendStatus(500);
			return;
			//throw err
		};
		
		if (rows.length==0){
			res.send(JSON.stringify({card_number: 0}));
		}else{
			res.send(JSON.stringify({card_number: req.body.card_number}));
		}
	});
});


app.listen('8000',()=> {
	console.log('Server started on port 8000');
});
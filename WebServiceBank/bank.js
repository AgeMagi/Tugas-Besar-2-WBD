const express = require('express');
const mysql = require ('mysql');
const bodyParser = require ('body-parser');
var OTP = require('otp.js');

//Create connection
const db = mysql.createConnection({
	host		: '127.0.0.1',
	user		: 'root',
	password	: '06071998',
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
	let sql = "INSERT INTO customer(name, card_number,balance) VALUES ('Yasya', '9','1000')";
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

app.get('/token', (req, res) => {
	const querySelect = "SELECT * FROM key_generator";
	db.query(querySelect, [], (err, rows) => {
		if (err) {
			res.send({
				'message': 'failed to generate token',
				'error': err,
				'status': -1,
			})
		} else{
			var HOTP = OTP.hotp;
			var secret_key = rows[0].secret_key;
			var counter = rows[0].counter;
			var token = HOTP.gen({string: secret_key}, {
				counter: {int: counter},
				codeDigits: 8,
				algorithm: 'sha1',
			});
			res.send({
				'message': 'success to generate token',
				'error': null,
				data: {
					'token': token,
				},
				'status': 0,
			})
		}	
		
	})
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

app.post('/transaction', (req, res) => {
	if (!req.body) {
		return res.sendStatus(400);
	} else {
		const token = req.body.token;
		console.log(token);
		const querySelect = "SELECT * FROM key_generator";
		db.query(querySelect, [], (err, rows) => {
			if (err) {
				res.send({
					'message': 'failed to get token',
					'error': err,
					'status': -1,
				})
			} else {
				var HOTP = OTP.hotp;
				var secret_key = rows[0].secret_key;
				var counter = rows[0].counter;

				var verified = HOTP.verify(token, {string: secret_key}, {
					counter: {int: counter},
					algorithm: 'sha1',
				})
				if (verified) {
					const nextCounter = counter + 1;
					const updateCounterQuery = "UPDATE key_generator SET counter=? WHERE secret_key=?";
					db.query(updateCounterQuery, [nextCounter, secret_key], (err, rows) => {
						if (err) {
							res.send({
								'message': 'failed to update counter',
								'error': err,
								'status': -1,
							})
						} else {
							const sender_card_number = req.body.sender_card_number;
							const receiver_card_number = '7371130607980003';
							const amount = parseInt(req.body.amount);
							const now = new Date().getTime();
							let getUserQuery = 'SELECT * FROM customer where card_number=?';
							db.query(getUserQuery, [sender_card_number], (err, rows, fields) => {
								if (err) {
									res.send({
										'message': 'failed to transfer',
										'error': err,
										'status': -1,
									})
								} else {
									const balance = rows[0].balance;
									if (balance < amount) {
										res.send({
											'message': 'Don\'t have money',
											'error': err,
											'status': -1,
										}) 
									} else {
										let insertTransactionQuery = 'INSERT INTO transaction(sender_card_number, receiver_card_number, amount, transaction_time) VALUES(?, ?, ?, ?)'; 
										db.query(insertTransactionQuery, [sender_card_number, receiver_card_number, amount, now], (err, result) => {
											if (err) {
												res.send({
													'message': 'failed to insert transaction',
													'error': err,
													'status': -1,
												})
											} else {
												let nowBalance = balance - amount;
												const transactionId = result.insertId;
												let updateBalanceQuery = 'UPDATE customer SET balance=? WHERE card_number=?';
												db.query(updateBalanceQuery, [nowBalance, sender_card_number], (err, result) => {
													if (err) {
														res.send({
															'message': 'failed to update balance sender',
															'error': err,
															'status': -1,
														})
													} else {
														getUserQuery = 'SELECT * FROM customer where card_number=?';
														db.query(getUserQuery, [receiver_card_number], (err, rows) => {
															if (err) {
																res.send({
																	'message': 'failed to get data receiver',
																	'error': err,
																	'status': -1,
																})
															} else {
																nowBalance = rows[0].balance + amount;
																updateBalanceQuery = 'UPDATE customer SET balance=? WHERE card_number=?';
																db.query(updateBalanceQuery, [nowBalance, receiver_card_number], (err, result) => {
																	if (err) {
																		res.send({
																			'message': 'failed to update balance receiver',
																			'error': err,
																			'status': -1,
																		})
																	} else {
																		res.send({
																			'message': 'success transfer',
																			'error': err,
																			'status': 0,
																			'data': {
																				'transaction_id': transactionId,
																			}
																		})
																	}
																})
															}																		
														})								
													}
												})
											}
										});
									}
								}
							})
						}
					})
				} else {
					const nextCounter = counter + 1;
					const updateCounterQuery = "UPDATE key_generator SET counter=? WHERE secret_key=?";
					db.query(updateCounterQuery, [nextCounter, secret_key], (err, rows) => {
						if (err) {
							res.send({
								'message': 'failed to update counter',
								'error': err,
								'status': -1,
							})
						} else {
							res.send({
								'message': 'Token salah',
								'error': err,
								'status': -1,
							})
						}
					})
				}
			}
		});
	}
})


app.listen('8000',()=> {
	console.log('Server started on port 8000');
});
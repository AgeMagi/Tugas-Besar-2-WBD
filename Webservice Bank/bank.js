const express = require('express');
const mysql = require ('mysql');

//Create connection
cost db = mysql.createConnection();


const bank = express();

bank.listen('5000',()=> {
	console.log('Server started on port 5000');
});
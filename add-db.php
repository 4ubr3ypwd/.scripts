<?php

/**
 * Adds a database to my local MySQL.
 */

$servername = 'localhost';
$username = 'root';
$password = ''; // Isn't this your password? LOL

// Create connection
$conn = new mysqli( $servername, $username, $password );

// Check connection
if ($conn->connect_error) {
	die( 'Connection failed: ' . $conn->connect_error );
}

// Create database
$sql = "CREATE DATABASE `{$argv[1]}`";

if ( $conn->query($sql) === TRUE ) {
	echo 'Database created successfully';
} else {
	echo 'Error creating database: ' . $conn->error;
}

$conn->close();

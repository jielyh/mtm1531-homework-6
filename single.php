<?php

require_once 'includes/filter-wrapper.php';


//creating variable called id, grabbing id from query string in the url
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);


//if ID is empty then send back to index
if (empty($id)) {
	header('Location: index.php');
	exit;
}

// Only connect to the database if there is an ID, becuse this is after the above if-statement
// Without an ID there is no point connecting to the database

//
require_once 'includes/db.php';

// ->prepare() allows us to execute SQL with user input
$sql = $db->prepare('
	SELECT id, movie_title, release_date, director
	FROM movies
	WHERE id = :id 
');

// ->bindValue() lets us fill in placeholders in our prepared statement
// :id is a placeholder for us to SECURELY put information from the user

//making sure that people cannot stick a variable in there
$sql->bindValue(':id', $id, PDO::PARAM_INT);

// Performs the SQL query on the database
$sql->execute();

// Gets the results from the SQL query and stores them in a variable
// ->fetch() gets a single result
// ->fetchAll() gets all the possible results

$results = $sql->fetch();

// Redirect the user back to the homepage if there are no database results
// No results will happen if they change the ?id=4 to include an ID that doesn't exist
if (empty($results)) {
	header('Location: index.php');
	exit; // Stop the PHP compiler right here and immediately redirect the user
}

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $results['movie_title']; ?> &middot; Movies</title>
</head>
<body>
	
	<h1><?php echo $results['movie_title']; ?></h1>
	<p>Release Date: <?php echo $results['release_date']; ?></p>
	<p>Director: <?php echo $results['director']; ?></p>
</body>
</html>

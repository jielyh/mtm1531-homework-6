<?php

require_once 'includes/filter-wrapper.php';

//creating variable id that holds the id from the query string (url)
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// if theres no id in the query then it brings u back to index
if (empty($id)) {
	header('Location: index.php');
	exit;
}

// if there is id, then run database
require_once 'includes/db.php';

// prepare to delete movie from database, if the id exsists (ex 1 = 1)
$sql = $db->prepare('
	DELETE FROM movies
	WHERE id = :id
	LIMIT 1
');

// making sure that its id its expecting
$sql->bindValue(':id', $id, PDO::PARAM_INT);

$sql->execute();

//after delete go back to index
header('Location: index.php');
exit;

<?php

// Include the necessary files and functions
require_once("./classes/connect_pdo_emp.php");
require_once("./classes/utils.php");
$pdoConnect = new connect_pdo();
$db = $pdoConnect->connectToDB();
require_once("./models/common_db.php");

// Get the request parameters
$tid = isset($_REQUEST['tid']) ?($_REQUEST['tid']) : 0;
$offset = isset($_REQUEST['offset']) ? $_REQUEST['offset'] : 0;
$limit = 8;

// Get the next set of posts based on the updated offset
$next_posts = post_content($db, $tid, $offset, $limit);

// Return the next posts as JSON response
header('Content-Type: application/json');
echo json_encode($next_posts);

?>
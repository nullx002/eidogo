<?php

require("db.php");
require("json.php");

mysql_connect(DB_HOST, DB_USER, DB_PASS);
mysql_select_db("eidogo");

$id = (int)$_REQUEST['id'];
if (!$id) {
	$id = 1; // show first tree by default
}

$tree_query = mysql_query("select * from kjd where parent = '$id'");
$trees = array();
if (!$tree_query) {
	echo "Error loading game data.";
} else {
	while ($tree = mysql_fetch_array($tree_query, MYSQL_ASSOC)) {
		$tree['nodes'] = unserialize($tree['nodes']);
		$tree['trees'] = array();
		$trees[] = $tree;
	}
	$json = new Services_JSON();
    echo $json->encode(array(
		"id"	=> $id,
		"nodes"	=> array(),
		"trees"	=> $trees,
	));
}

?>
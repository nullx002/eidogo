<?php

require("sgf.php");
require("db.php");

// Change these as appropriate:
mysql_connect(DB_HOST, DB_USER, DB_PASS);
mysql_select_db("eidogo");
$sgf_file = "../sgf/kjd.sgf";

function insert($tree, $id) {
	$result = mysql_query(
		"insert into kjd (parent, nodes, lt, rt) values (" .
		"'$id', " .
		"'" . mysql_real_escape_string(serialize($tree['nodes'])) . "', " .
		"'" . $tree['lt'] . "', " .
		"'" . $tree['rt'] . "'" .
		")"
	);
	if (!$result) {
		die("Problem! " . mysql_error());
	}
	$insert_id = mysql_insert_id();
	for ($i = 0; $i < count($tree['trees']); $i++) {
		insert($tree['trees'][$i], $insert_id);
	}
}

$sgf = new SGF(file_get_contents($sgf_file));

// modified pre-order tree transversal -- we don't use
// this yet, but we could
function mptt(&$tree, $lt) {
	$rt = $lt + 1;
	
	for ($i = 0; $i < count($tree['trees']); $i++) {
		$rt = mptt($tree['trees'][$i], $rt);
	}
	
	$tree['lt'] = $lt;
	$tree['rt'] = $rt;
	
	return $rt + 1;
}

mptt($sgf->tree, 1);

insert($sgf->tree, 0);

?>
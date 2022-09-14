<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include('../../app/Controllers/Post.php');
$titlos = str_replace("__", "%20", $_GET["titlos"]);
$keimeno = str_replace("__", "%20", $_GET["keimeno"]);

$new_art = postArticle($titlos,$keimeno);
$create_vote_table = curl_init();

curl_setopt_array($create_vote_table, array(
	CURLOPT_URL => 'http://apiproject.stage3.econtentsys.gr/test/vendor/sql.php?id=3&aid='.$new_art["id"],
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'GET',
));
curl_exec($create_vote_table);

curl_close($create_vote_table);

?>

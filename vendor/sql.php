<?php


$vid = $_GET['id'];
$aid =  $_GET['aid'];

if($_GET['id']) {

    setVotes($aid,$vid);

};

function getVotes($aid) {

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    $gettable = "SELECT `vote` FROM `votes` WHERE `article_id`=" . $aid;
    $votes =  $conn->query($gettable);

    $votes_table = array();
    $vote0 = mysqli_fetch_row($votes);
    $vote1 = $vote0['0'];
    return $vote1;
};



function setVotes($a,$v) {
    $conn = new mysqli('localhost', 'apiproject', 'apiproject#12', 'apiproject_votes');
    if ($v == 3) {
        $sql = "INSERT INTO `votes` (`article_id`, `vote`) VALUES ('".$a."', '0');";
    } else if ($v == 2) {
        $sql = "UPDATE `votes` SET `vote`=  `vote`-'1' WHERE `article_id`=" . $a;
    } else if ($v == 1) {
        $sql = "UPDATE `votes` SET `vote`=  `vote`+'1' WHERE `article_id`=" . $a;
    }

    $conn->query($sql);


};


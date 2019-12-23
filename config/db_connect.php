<?php

//connect to database
$conn = mysqli_connect('localhost', 'rydia', 'remake', 'the_net_ninja_tutorial');

//check connectin
if(!$conn) {
	echo 'connection error: ' . mysqli_connect_error();
}

?>
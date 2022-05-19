<?php

class ConnectNow{
	public function connect(){
		$link = new PDO("mysql:host=localhost:3306;dbname=cit111", "root", "");
		$link -> exec("set names utf8");
		return $link;

        if ($con) {
            echo 'connected';
          } else {
            echo 'not connected';
          }
	}

	// public function connectAuth(){
	// 	$link = new PDO("mysql:host=localhost;dbname=oop", "root", "");
	// 	$link -> exec("set names utf8");
	// 	return $link;
	// }
}

?>
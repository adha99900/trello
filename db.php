<?php
	session_start();
	$db=new mysqli('127.0.0.1','root','','trello');
	$db->query("set names utf8");
	
	function get_data($result){
		$data=[];
		while($i=$result->fetch_assoc()){
			$data[]=$i;
		}
		return $data;
	}
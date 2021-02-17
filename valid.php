<?php
session_start();
	if (!isset($_SESSION['admin_id'])){
		header('location:index.php');
	}
require_once 'connect.php';    

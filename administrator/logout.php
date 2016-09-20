<?php
session_start();
require_once("konekcija.php");
if (!isset($_SESSION['pbd_mc_un'])) { header("Location: index.php"); die(); }
destroy_session_and_data();
header("Location: index.php"); die();
?>
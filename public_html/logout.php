<?php
session_start();
require("../includes/functions.inc.php");

session_destroy();
header("Location: ".BASE_URL."index.php");

die();
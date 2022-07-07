<?php
session_start();
require 'regcontroller.php';
session_destroy();
setcookie("user", "", time()-3600);
header("Location: LoginPdo.php");

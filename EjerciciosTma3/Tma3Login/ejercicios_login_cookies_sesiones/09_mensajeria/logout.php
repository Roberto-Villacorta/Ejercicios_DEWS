<?php
require 'common.php';
unset($_SESSION['activo']);
header('Location: login.php');
exit;

<?php
session_start();
session_destroy();
header("Location: pages/login_form.php");
exit();
?>
<?php
session_start();
session_destroy();
header("Location: ../html/inicial.html");
exit();
?>
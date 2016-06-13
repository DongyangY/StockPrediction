<?php include_once 'backend/session.php' ?>

<?php

if(isset($_SESSION['usr'])) echo "<script>window.location.replace('trade.php');</script>";
else echo "<script>window.location.replace('login.php');</script>";

?>
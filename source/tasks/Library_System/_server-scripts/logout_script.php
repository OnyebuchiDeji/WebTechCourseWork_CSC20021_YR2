
<?php
    session_start();
    session_destroy();
    header("Location: ../_client-scripts/login_page.php");
    exit();
?>
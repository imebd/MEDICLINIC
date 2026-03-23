<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function checkAccess($allowed_roles) {
    if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], $allowed_roles)) {
        header("Location: /MEDICLINIC/dashboard/index.php?error=access_denied");
        exit();
    }
}
?>
<?php
/** NexusTech admin — gate every admin page except login.php. */
require_once __DIR__ . '/../config.php';

if (!admin_is_logged_in()) {
    header('Location: login.php');
    exit;
}

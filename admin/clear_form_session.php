<?php
session_start();
unset($_SESSION['form_data']);
unset($_SESSION['validation_errors']);
echo json_encode(['status' => 'success']);
?>
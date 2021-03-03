<?php
declare(strict_types=1);

namespace app;

use services\PasswordGenerator;

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once "services/PasswordGenerator.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!($length = filter_input(INPUT_POST, 'length', FILTER_VALIDATE_INT))) {
        $length = 0;
    }

    $types = $_POST['types'] ?? [];
    try {
        $passwordGenerator = new PasswordGenerator($length, $types);
        $password = $passwordGenerator->generate();
    } catch (\Exception $e) {
        $error = $e->getMessage();
    }
}

require_once "views/form.php";

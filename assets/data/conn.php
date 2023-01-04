<?php

$host = 'localhost';
$db = 'lyrex_quick_panel';
$user = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=".$host.";dbname=".$db, $user, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo ("Bağlantı İşlemi Başarısız!" . $e->getMessage());
}

?>
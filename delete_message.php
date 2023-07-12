<?php
require 'dbconnect.php';

// POSTデータを取得
$id = $_POST['id'];

// メッセージを削除
$query = "DELETE FROM messages WHERE id = :id";
$statement = $pdo->prepare($query);
$statement->execute([
    'id' => $id
]);

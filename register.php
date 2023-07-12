<?php
session_start();

require 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $email, $password]);
    
    // 登録成功時
    $_SESSION['username'] = $username; // $username はログインしたユーザーのユーザー名

    // リダイレクトする
    header("Location: main.php");
    exit();
}
?>

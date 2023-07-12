<!DOCTYPE html>
<html>
<head>
    <title>山散歩でデジタル掲示板</title>
    <style>
        /* CSSスタイルをここに追加 */
    </style>
</head>
<body>
    <h1>山散歩でデジタル掲示板</h1>

    <h1>アカウント登録</h1>
    <form id="registerForm" action="register.php" method="post">
        <label for="username">ユーザー名:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="email">メール:</label><br>
        <input type="email" id="email" name="email"><br>
        <label for="password">パスワード:</label><br>
        <input type="password" id="password" name="password"><br>
        <input type="submit" value="登録">
    </form>
    <h1>ログイン</h1>
    <form action="login.php" method="post">
        <label for="email">メール:</label><br>
        <input type="email" id="email" name="email"><br>
        <label for="password">パスワード:</label><br>
        <input type="password" id="password" name="password"><br>
        <input type="submit" value="ログイン">
    </form>
    <script src="/php4_yoshii_53/main.js"></script>
</body>
</html>

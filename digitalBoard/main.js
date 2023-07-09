document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var username = document.getElementById('username').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    fetch('register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'username': username,
            'email': email,
            'password': password,
        }),
    })
    .then(response => response.text())
    .then(data => {
        // レスポンスを処理（例: 成功メッセージを表示、ログインページにリダイレクト等）
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});

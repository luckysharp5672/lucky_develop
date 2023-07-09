<?php
session_start();

require 'dbconnect.php';

// メッセージを取得
$query = "SELECT * FROM messages";
$statement = $pdo->prepare($query);
$statement->execute();
$messages = $statement->fetchAll(PDO::FETCH_ASSOC);

// ログインしているかをチェックし、username を取得
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>山散歩でのデジタル掲示板</title>
    <style>
            .message {
                border: 1px solid #ccc;
                padding: 10px;
                margin-bottom: 10px;
            }
    </style>
    <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=loadMapScenario&key=ApUslpO8ghJ6mpe35ApW427eo72OmGGHg9ETniAK37AnLv7g6GzjaiEkrMB1cowL' async defer></script>

</head>
<body>
    <h1>さんぽデジタル掲示板</h1>
    <div id="currentUsername" style="display: none;"><?php echo $username; ?></div>
    <button id="getLocation">現在位置の取得</button>
    <div id="location">位置：未取得</div>
    <div id="myMap" style="position:relative;width:600px;height:400px;"></div>
    <form id="messageForm">
        <label for="boardTitle">新しい掲示板のタイトル:</label><br>
        <textarea id="boardTitle" name="boardTitle"></textarea><br>
        <button type="button" id="postButton">掲示板作成</button>
    </form>

    <div id="messages">
        <?php foreach ($messages as $message) { ?>
            <div class="message">
                <p>ユーザー名: <?php echo $message['username']; ?></p>
                <p>メッセージ: <span class="boardTitle"><?php echo $message['boardTitle']; ?></span></p>
                <p>緯度: <span class="latitude"><?php echo $message['latitude']; ?></span></p>
                <p>経度: <span class="longitude"><?php echo $message['longitude']; ?></span></p>
                <p>
                    <?php $boardId = $message['id']; ?>
                    <a href="board.php?id=<?php echo $boardId; ?>">掲示板を開く</a>
                    <!-- 編集と削除ボタンを追加 -->
                    <a href="edit_form.php?id=<?php echo $boardId; ?>" target="_blank" class="editButton" data-id="<?php echo $boardId; ?>">編集</a>
                    <button class="deleteButton" data-id="<?php echo $boardId; ?>">削除</button>

                </p>
            </div>
        <?php } ?>
    </div>

    <button id="search">近くのメッセージを検索</button>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/php4_yoshii_53/map.js"></script>
    
    <!-- 掲示板の編集、削除のために追加 -->
    <script>
    $(document).on("click", ".editButton", function () {
    console.log("Edit button clicked."); // この行を追加
    var messageId = $(this).data("id"); // メッセージIDを取得
    var boardTitle = $(this).closest(".message").find(".boardTitle").text(); // メッセージの内容を取得
    var newBoardTitle = prompt("新しいメッセージを入力してください", boardTitle); // 新しいメッセージをユーザに入力させる

    // ユーザが新しいメッセージを入力した場合、サーバに更新を依頼する
    if (newBoardTitle !== null) {
        $.ajax({
        url: "edit_message.php", // メッセージを編集するPHPスクリプトのURL
        type: "POST",
        data: {
            id: messageId,
            boardTitle: newBoardTitle,
        },
        success: function () {
            location.reload(); // ページをリロードして更新を反映する
        },
        });
    }
    });

    document.querySelectorAll(".deleteButton").forEach(function (deleteButton) {
    deleteButton.addEventListener("click", function () {
        var id = this.getAttribute("data-id");

        // ユーザに確認を取る
        if (!confirm("本当に削除しますか？")) {
        return;
        }

        // レコードのIDをサーバにPOSTする
        fetch("delete_message.php", {
        method: "POST",
        body: new URLSearchParams("id=" + id),
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        })
        .then(function (response) {
            if (!response.ok) {
            throw new Error("HTTP error " + response.status);
            }

            // レコードが削除されたら、ページをリロードする
            location.reload();
        })
        .catch(function (error) {
            console.error("Error:", error);
        });
    });
    });
    </script>
</body>
</html>


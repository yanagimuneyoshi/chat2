<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
  <title>Responsive Chat</title>
</head>

<body>
  <div id="container">
    <!-- サイドバー -->
    <aside>
      <header>
        <input type="text" placeholder="Search">
      </header>
      <ul id="friend-list">
        <!-- マイページ -->
        <li>
          <img src="https://via.placeholder.com/50" alt="User">
          <div>
            <h1>{{ auth()->user()->name }}</h1>
            <h5>マイページ</h5>
          </div>
        </li>
      </ul>
    </aside>

    <!-- メインチャット -->
    <main>
      <header>
        <img src="https://via.placeholder.com/50" alt="Chat User">
        <div>
          <h2>Chat with John Doe</h2>
          <h3>1902 messages</h3>
        </div>
      </header>
      <ul id="chat" style="height: 400px; overflow-y: scroll;">
        <!-- メッセージがここに表示される -->
      </ul>
      <footer>
        <form id="messageForm">
          <textarea id="message-input" name="content" placeholder="Type your message"></textarea>
          <button type="button" id="send-button">Send</button>
        </form>
      </footer>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
  <script>
    // Pusher設定
    const pusher = new Pusher("{{ env('MIX_PUSHER_APP_KEY') }}", {
      cluster: "{{ env('MIX_PUSHER_APP_CLUSTER') }}",
      encrypted: true,
    });

    // Pusherチャンネル購読
    const channel = pusher.subscribe("chat");

    channel.bind("message.sent", function(data) {

      // 自分のメッセージかどうかを確認
      if (data.message.user_id === currentUserId) {
        return; // 自分のメッセージの場合は何もしない
      }

      displayMessage(data.message);
    });

    // メッセージを表示する関数
    // メッセージを表示する関数
    function displayMessage(message) {
      const chatContainer = document.getElementById("chat");
      const messageElement = document.createElement("li");
      // 自分のメッセージか相手のメッセージかでクラスを分ける

      messageElement.innerHTML = `
        <div class="message">
            <p>${message.content}</p>
            <span>${new Date().toLocaleTimeString()}</span>
        </div>
    `;
      chatContainer.appendChild(messageElement);
      chatContainer.scrollTop = chatContainer.scrollHeight; // 自動スクロール
    }

    // メッセージ送信処理
    document.getElementById("send-button").addEventListener("click", function() {
      const messageInput = document.getElementById("message-input");
      const messageContent = messageInput.value;

      if (messageContent.trim() === "") return;

      // サーバーにメッセージを送信
      axios.post("/messages", {
        content: messageContent,
      }).then(response => {
        displayMessage(response.data); // 自分のメッセージを即時表示
        messageInput.value = ""; // 入力欄をクリア
      }).catch(error => {
        console.error("メッセージ送信エラー:", error);
      });
    });
  </script>
</body>

</html>
// import Echo from "laravel-echo";
// import Pusher from "pusher-js";

// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.PUSHER_APP_KEY,
//     cluster: process.env.PUSHER_APP_CLUSTER,
//     forceTLS: true,
// });

// // メッセージをリッスン
// window.Echo.channel('chat')
//     .listen('.message.sent', (data) => {
//         console.log('New message:', data.message);
//     });

// function displayMessage(message) {
//     const chatContainer = document.getElementById('chat-messages');
//     const messageElement = document.createElement('div');
//     messageElement.textContent = `${message.user_id}: ${message.content}`;
//     chatContainer.appendChild(messageElement);
// }


// document.getElementById('send-button').addEventListener('click', function () {
//     const messageInput = document.getElementById('message-input');
//     const messageContent = messageInput.value;

//     // サーバーにメッセージを送信
//     axios.post('/messages', {
//         content: messageContent,
//     }).then(response => {
//         displayMessage(response.data); // 自分のメッセージを即時表示
//         messageInput.value = ''; // 入力欄をクリア
//     }).catch(error => {
//         console.error('メッセージ送信エラー:', error);
//     });
// });

// function displayMessage(message) {
//     const chatContainer = document.getElementById('chat-messages');
//     const messageElement = document.createElement('div');
//     messageElement.textContent = `${message.user_id}: ${message.content}`;
//     chatContainer.appendChild(messageElement);
// }

// // ボタンクリックイベント
// // document.getElementById('send-button').addEventListener('click', async () => {
// //     const textarea = document.querySelector('textarea');
// //     const message = textarea.value.trim();

// //     if (message) {
// //         try {
// //             const response = await fetch('/api/messages', {
// //                 method: 'POST',
// //                 headers: {
// //                     'Content-Type': 'application/json',
// //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
// //                 },
// //                 body: JSON.stringify({
// //                     content: message,
// //                     chat_id: 1,
// //                 }),
// //             });

// //             if (response.ok) {
// //                 const newMessage = await response.json();

// //                 const chat = document.getElementById('chat');
// //                 const newMessageElement = document.createElement('li');
// //                 newMessageElement.className = 'me';
// //                 newMessageElement.innerHTML = `
// //                     <div class="message">
// //                         <p>${newMessage.content}</p>
// //                         <span>${new Date(newMessage.created_at).toLocaleTimeString()}</span>
// //                     </div>
// //                 `;
// //                 chat.appendChild(newMessageElement);

// //                 textarea.value = '';
// //             } else {
// //                 console.error('Failed to send message', response.status);
// //             }
// //         } catch (error) {
// //             console.error('Error sending message:', error);
// //         }
// //     }
// // });

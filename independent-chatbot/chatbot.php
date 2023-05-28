<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Chatbot Chatting Page</title>
    <style>
       
       .chatbot-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 300px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 9999;
  }
  
  .chatbot-header {
    padding: 10px;
    background-color: #f5f5f5;
    border-bottom: 1px solid #ccc;
    text-align: center;
  }
  
  .chatbot-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: bold;
  }
  
  .chatbot-body {
    max-height: 250px;
    overflow-y: auto;
    padding: 10px;
  }
  
  .message {
    margin-bottom: 10px;
    padding: 8px;
    border-radius: 4px;
  }
  
  .user-message {
    background-color: #f5f5f5;
    text-align: right;
  }
  
  .chatbot-message {
    background-color: #eaf2fd;
    text-align: left;
  }
  
  .chat-input-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
    border-top: 1px solid #ccc;
  }
  
  .chat-input {
    flex: 1;
    padding: 5px;
    border: none;
    border-radius: 4px;
    outline: none;
  }
  
  .send-button {
    padding: 6px 12px;
    background-color: #4caf50;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  .send-button:hover {
    background-color: #45a049;
  }
  

    </style>
</head>

<body>
    <div class="chatbot-container">
        <div class="chatbot-header">
            <h3>Chatbot</h3>
        </div>
        <div class="chatbot-body">
            <!-- Chat messages will be displayed here -->
        </div>
        <div class="chat-input-container">
            <input type="text" id="chat-input" class="chat-input" placeholder="Type your message..." />
            <button id="send-button" class="send-button">Send</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Function to add a new message to the chat
            function addMessage(sender, content) {
                var chatContainer = $(".chatbot-body");
                var senderClass = sender === "user" ? "user-message" : "chatbot-message";

                chatContainer.append('<div class="message ' + senderClass + '">' + content + '</div>');

                // Scroll to the bottom of the chat container
                chatContainer.scrollTop(chatContainer.prop("scrollHeight"));
            }

            // Handle send button click or Enter key press
            function handleSendMessage() {
                var messageInput = $("#chat-input");
                var message = messageInput.val().trim();

                if (message !== "") {
                    addMessage("user", message);
                    messageInput.val("");
                    getChatbotResponse(message);
                }
            }

            // Get chatbot response from the API
            function getChatbotResponse(message) {
                var apiKey = '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'; // Replace with your actual OpenAI API key
                var endpoint = 'https://api.openai.com/v1/chat/completions';
                var model = 'gpt-3.5-turbo';

                // Prepare the data payload
                var data = {
                    'messages': [
                        { 'role': 'system', 'content': 'You are a helpful assistant.' },
                        { 'role': 'user', 'content': message }
                    ],
                    'model': model
                };

                // Prepare the headers
                var headers = {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + apiKey
                };

                // Make a POST request to the API
                $.post({
                    url: endpoint,
                    headers: headers,
                    data: JSON.stringify(data),
                    success: function (response) {
                        var chatbotResponse = response.choices[0].message.content;
                        addMessage("chatbot", chatbotResponse);
                    }
                });
            }

            // Bind send button click event
            $("#send-button").click(handleSendMessage);

            // Bind Enter key press event
            $("#chat-input").keypress(function (event) {
                if (event.which === 13) {
                    handleSendMessage();
                }
            });
        });
    </script>
</body>

</html>
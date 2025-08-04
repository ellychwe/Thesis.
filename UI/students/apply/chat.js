// === Toggle Chat Box ===
const messageIcon = document.getElementById('messages'); // topbar icon
const chatContainer = document.getElementById('chat-container');
const closeChat = document.getElementById('closeChat');

messageIcon.addEventListener('click', () => {
    if (!chatContainer.classList.contains('show')) {
        chatContainer.style.display = 'flex';
        setTimeout(() => chatContainer.classList.add('show'), 10); // show with animation
    } else {
        chatContainer.classList.remove('show');
        setTimeout(() => chatContainer.style.display = 'none', 300); // hide after animation
    }
});

closeChat.addEventListener('click', () => {
    chatContainer.classList.remove('show');
    setTimeout(() => chatContainer.style.display = 'none', 300);
});

const sendBtn = document.getElementById('sendBtn');
const messageInput = document.getElementById('messageInput');
const chatMessages = document.getElementById('chat-messages');

// Dummy username for now (can be dynamic later)
const username = "You";

// Send message
sendBtn.addEventListener('click', () => {
    const message = messageInput.value.trim();
    if (message) {
        socket.emit('chat message', { username, text: message });
        addMessageBubble(username, message, true);
        messageInput.value = '';
    }
});


// Function to create a chat bubble
function addMessageBubble(sender, text, isOwnMessage) {
    const bubble = document.createElement('div');
    bubble.classList.add('chat-bubble');
    bubble.style.maxWidth = '70%';
    bubble.style.margin = '5px';
    bubble.style.padding = '10px';
    bubble.style.borderRadius = '12px';
    bubble.style.color = '#fff';
    bubble.style.wordWrap = 'break-word';

    if (isOwnMessage) {
        bubble.style.backgroundColor = '#1877f2'; // Blue for own messages
        bubble.style.alignSelf = 'flex-end';
    } else {
        bubble.style.backgroundColor = '#e4e6eb'; // Gray for others
        bubble.style.color = '#000';
        bubble.style.alignSelf = 'flex-start';
    }

    bubble.innerHTML = `<strong>${sender}:</strong> ${text}`;
    chatMessages.appendChild(bubble);

    // Auto-scroll to the latest message
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

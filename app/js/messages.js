document.addEventListener('DOMContentLoaded', () => {
    const bCont = document.getElementById('contacts');
    const chatLog = document.querySelector('.chatlog');
    const form = document.getElementById('messageForm');
    const replyInput = document.getElementById('replyinput');
    let activeContact = null;

    bCont.addEventListener('click', (event) => {
        if (event.target && event.target.classList.contains('real_contact')) {
            document.querySelectorAll('.real_contact').forEach(el => el.classList.remove('active'));
            event.target.classList.add('active');
    
            activeContact = event.target.id;
            replyInput.value = activeContact;
            document.getElementById('chat-header').textContent = 'Chat with ' + event.target.textContent;
            fetchMessages(activeContact);
        }
    });

    form.addEventListener('submit', e => {
        e.preventDefault();
        const msg = document.getElementById('input_message').value;
        const data = new URLSearchParams();
        data.append('input_message', msg);
        data.append('replyinput', activeContact);

        fetch('php/post_message.php', {
            method: 'POST',
            body: data
        }).then(() => {
            form.reset();
            fetchMessages(activeContact);
        }).catch(err => {
            console.error('Fetch failed:', err);
        });
    });

    function fetchMessages(contactId) {
        fetch(`php/get_messages.php?contact_id=${contactId}`)
            .then(res => res.json())
            .then(messages => {
                chatLog.innerHTML = '<h2>Chat History</h2>';
                messages.forEach(msg => {
                    const div = document.createElement('div');
                    div.className = msg.sending_userId == currentUserId ? 'sentmessage' : 'receivedmessage';
                    div.textContent = msg.textmessage;
                    chatLog.appendChild(div);
                });
            });
    }
});
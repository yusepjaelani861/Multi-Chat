const axios = require('axios');

const form = document.querySelector('chat');
const message = document.querySelector('text');
const message_el = document.querySelector('messages');
const message_form = document.querySelector('message-form');

message_form.addEventListener('submit', function(e) {
    e.preventDefault();

    let has_errors = false;

    if (message.value == ""){
        alert("Please enter a message");
        has_errors = true;
    }

    if(has_errors){
        return;
    }

    const options = {
        method: 'POST',
        url: '/send-message',
        data: {
            text: message.value
        }
    }
    axios(options);
    
});

windows.Echo.channel('chat')
    .listen('.message', (e) => {
        message_el.innerHTML += '<div class="flex mb-2"><div class="rounded py-2 px-3" style="background-color: #F2F2F2"><p class="text-sm text-purple">Customer {{ $chat_id }}</p><p class="text-sm mt-1">' + e.message + '</p><p class="text-right text-xs text-grey-dark mt-1">12:45 pm</p></div></div>';
    })


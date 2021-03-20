const form = document.querySelector(".typing-area"),
incoming_id = form.querySelector(".incoming_id").value,
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e)=>{
    e.preventDefault();
}

inputField.focus();
inputField.onkeyup = ()=>{
    if(inputField.value != ""){
        sendBtn.classList.add("active");
    }else{
        sendBtn.classList.remove("active");
    }
}

sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              inputField.value = "";
              scrollToBottom();
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}

let out_messages = {};
let in_messages = {};
let messages = {};
chatBox.innerText = "";

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = JSON.parse(xhr.response);
            const partner_updated_at = new Date(data.partner_updated_at);
            const currentTime = new Date();
            const diffTime = Math.abs(currentTime - partner_updated_at);
            const diffSeconds = Math.ceil(diffTime / (1000 ));
            if(data.partner_status === "Offline now" || data.partner_status === undefined || diffSeconds > 60) {
                sendBtn.disabled = true;
                inputField.disabled = true;
                inputField.value = "Your partner has gone.";
            }
              console.log(messages);
            messages = {};
            chatBox.innerHTML ='';
            for (const property in data.messages) {
                console.log("not in");
                const message = data.messages[property];
                if(message.direction === 'in'){
                    console.log(message.direction);
                    chatBox.innerHTML += `<div class="chat incoming"><div class="details"><p>${message.message}</p></div></div>`;
                }
                if(message.direction === 'out'){
                    console.log(message.direction);
                    chatBox.innerHTML += `<div class="chat outgoing"><div class="details"><p>${message.message}</p></div></div>`;
                }

            }


            if(!chatBox.classList.contains("active")){
                scrollToBottom();
              }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id="+incoming_id);
}, 1000);

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
  }
  
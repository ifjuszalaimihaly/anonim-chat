
const handle = () => {
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "php/users.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
      if(xhr.status === 200){
        let data = xhr.response;
        if(data.includes("user_id")){
          location.href = "chat.php?" + data;
        }
      }
    }
  }
  xhr.send();
}

setInterval(handle, 1000);
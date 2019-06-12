function register2(username, password){
    event.preventDefault();
    axios.post('http://localhost:1443/proiectTW/api/user/create.php', {
        username: username.value,
        password: password.value
      })
      .then(function (response) {
        console.log(response.data.message,"data msg");
        if(response.data.message=="UserExists"){
            alert("User already exists!")
        }else{
            
            alert("User created successfully, please log inss!")
        }
      })
      .catch(function (error) {
        console.log(error);
        alert("Error at creating user!")
      });
    console.log(username.value,'username');
    console.log(password.value,'pass')
    
    
            // if(div.value==="" || div2.value===""){
            //     form.appendChild(document.createTextNode("Please Complete all fields!"));
            //     return false;
            // }

               
               
}
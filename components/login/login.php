<html>
<head>
    <style type = "text/css">
    html{
  margin: auto;
}

body{
    margin-top: 18%;
    background: #c0dfd0;
    
  }
  
  h1{
    color: #fff;
    font-family: Arial;
    text-align: center;
  }
  
  .form{
    background: #edeff1;
    margin: 0px auto;
    padding-top: 25px;
    padding-bottom: 25px;
    border-radius: 12px;
    width: 425px;
    height: auto;
    
    
  }
  
  #register{
    margin-bottom: 15px;
  }
  input[type="text"]{
     display: block;
    width: 305px;
    height: 35px; 
    margin: 15px auto;
    background: #fff;
    border: 0px;
    padding: 5px;
    font-size: 16px;
     border: 2px solid #fff;
    transition: all 0.3s ease;
    border-radius: 5px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
  }
  
  input[type="text"]:focus{
    border: 2px solid #c0dfd9;
  }
  
  input[type="submit"]{
    display: block;
    background: #3b3a36;
    width: 314px;
    padding: 10px;
    cursor: pointer;
    color: #fff;
    border: 0px;
    margin: auto;
    border-radius: 5px;
    font-size: 18px;
    transition: all 0.2s ease;
    margin-bottom: 5px;
   
  }
  
  input[type="submit"]:hover{
    background: #c0dfd9;
    
  }
  
  a{
    text-align: center;
    font-family: Arial;
    color: gray;
    display: block;
    margin: 15px auto;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 12px;
  }
  
  input[type="login"]{
    display: block;
    background: #3b3a36;
    width: 314px;
    padding: 10px;
    cursor: pointer;
    color: #fff;
    border: 0px;
    margin: auto;
    border-radius: 5px;
    font-size: 18px;
    transition: all 0.2s ease;
    text-align: center
  }

  input[type="login"]:hover{
    background: #c0dfd9;
  }
  a:hover{
    color: #1abc9d;
  }
</style>
       

<script src="login.js"></script>
<script src="./../../node_modules/axios/dist/axios.js"></script>

</head>
<body>
       
              <div id="loginForm" class="form">
                    <form action="./../../main.php" method="POST">
                 <input  id="username" name="username" type="text" placeholder="Enter your username" />
                <input  id="password" name="password" type="text" placeholder="Password" />
                 <input  id="loginLogin" name="login" type="submit" value="Login" />
                <!-- <a href="">Lost your password?</a>       -->
                <a href="http://localhost:1443/proiectTW/components/register/register.php"><input  type="login" id="goToLogin" name="goToLogin" value="Go to Register Page" /></a>
                    </form>
</div>
          

</body>
</html>
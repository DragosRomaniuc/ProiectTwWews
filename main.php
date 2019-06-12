<?php
 session_start();
//Database Configuration File
// include('includes/config.php');
//error_reporting(0);
// if(isset($_POST['login']))
//   {
 
//     // Getting username/ email and password
//     $uname=$_POST['username'];
//     $password=$_POST['password'];
//     // Fetch data from database on the basis of username/email and password
// $sql =mysqli_query($con,"SELECT AdminUserName,AdminEmailId,AdminPassword FROM tbladmin WHERE (AdminUserName='$uname' || AdminEmailId='$uname')");
//  $num=mysqli_fetch_array($sql);
// if($num>0)
// {
// $hashpassword=$num['AdminPassword']; // Hashed password fething from database
// //verifying Password
// if (password_verify($password, $hashpassword)) {
// $_SESSION['login']=$_POST['username'];
//     echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
//   } else {
// echo "<script>alert('Wrong Password');</script>";
 
//   }
// }
// //if username or email not found in database
// else{
// echo "<script>alert('User not registered with us');</script>";
//   }
 
// }
include_once './config/Database.php';
include_once './models/Chosencategories.php';
    $database = new Database();
    $db = $database->connect();
    $found=false;
if(isset($_POST['username'])){
  $data_username = $_POST['username'];
  $data_password = $_POST['password'];

  $query = 'SELECT * from users';
  $stmt = $db->prepare($query);
  $stmt->execute();
  $num = $stmt->rowCount();
  if($num > 0) {
    $users_arr = array();
    // $users_arr['data'] = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
      if($username == $data_username && password_verify($data_password, $password)){
        // echo $password;
       $found = true;
       $_SESSION["username"]=$username;
      // echo "Gasit";
      }
      if($found==false){
        // echo $password;
        session_unset();
      }
        }
   
  }

 
}

if(!empty($_SESSION['username'])){
  $_SESSION['usercategories'] = array();
  $chosencategory = new Chosencategories($db);
  $chosencategory->username = $_SESSION['username'] ;
  $result = $chosencategory->read_single();
  $num = $result->rowCount();
  if($num > 0) {
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $_SESSION['usercategories'][] = $category;
    }
  //  print_r($_SESSION['usercategories']);
  }else{
    // echo json_encode(
    //     array('message' => "Error OR 0 items")
    //   );
  }
        // echo "Welcome, ".$_SESSION["username"];
        // print_r($_SESSION['usercategories']);
        
  }
  else{

      echo "Invalid username/password.";
      echo "<script type='text/javascript'> document.location = '/proiectTW/components/login/login.php'; </script>";
  }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta http-equiv="refresh" content="3" > -->
    <title>
       YW wews
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-control" content="no-cache">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script type="text/javascript" src="http://livejs.com/live.js"></script>
    <script src="main.js"></script>
    <script type="text/javascript">var chosenCategories = <?php echo json_encode($_SESSION['usercategories']); ?>;</script>
    <script type="text/javascript">var currentUsername = <?php echo json_encode($_SESSION['username']); ?>;</script>
    <script type="text/javascript">var currentNewsList=[]</script>
    <script type="text/javascript">var currentTopics; fetch("http://localhost:3000/getUserTopics",{
                                method: "POST", // *GET, POST, PUT, DELETE, etc.
                                headers: {
                                    "Content-Type": "application/json",
                                },
                          
                                body: JSON.stringify({name: currentUsername})
                            })
                    .then(response => response.json())
                    .then(res=>{
                      currentTopics = res; console.log(res);
                      var leftColumnCategories = document.getElementById("leftcolumn");
                      Object.keys(res).forEach(function(key) {
                      var val = res[key];
                      let div = document.createElement("div");
                                          div.className="normalTab";
                                          let a = document.createElement("a");
                                          a.innerHTML=key;
                                          
                                          div.appendChild(a);




                                          let content = document.getElementById("content");
                                          a.onclick=()=>{
                                            content.innerHTML = '';
                      let mainList = document.createElement('ul');
                      let entries = res.articles;
                      let category = localStorage.getItem("categoryChosen");
                         let h3 = document.createElement("h3");
                         h3.appendChild(document.createTextNode((`Your ${key} saved news!`)));
                         h3.style="text-align: center"
                         let div2 = document.getElementById("content");
                         div2.append(h3);

                         console.log(val)

                         for(var i=0; i<val.length; i++){
                        var listItem = document.createElement('li');
                        listItem.style="text-align: center; border: 1px solid black; margin-top: 10px; padding: 3%; height: 150px;"
                        var title = (i+1)+" . "+val[i].title;
                        title.style="color: #C0DFD9; font-weight: 800;"
                        var contentSnippet = val[i].content;
                        var contentSnippetText = document.createTextNode(contentSnippet);
                        var link = document.createElement('a');
            link.setAttribute('href', val[i].url);
            link.setAttribute('target','_blank');
            var text = document.createTextNode(title);
            link.appendChild(text);
            link.style="color: black; font-weight: 800;"
            listItem.appendChild(link);
            var desc = document.createElement('p');
            desc.appendChild(contentSnippetText);
            var x = document.createElement("IMG");
  // x.setAttribute("src",val[i].urlToImage);
  // x.setAttribute("width", "304");
  // x.setAttribute("height", "228");
  // x.setAttribute("alt", val[i].author);
  // listItem.appendChild(x);
            // add description to list item
            listItem.appendChild(desc);
                      
            // adding list item to main list
            mainList.appendChild(listItem);
                      }
                      console.log(mainList)
                      content.appendChild(mainList);

                                          }
                    
                                          leftColumnCategories.appendChild(div);

                    });
                      
                      
                      
                    let changeTheme = document.getElementById("changeTheme");
                    let content = document.getElementById("content");
                    let leftcolumn = document.getElementById("leftcolumn");
                 
                    changeTheme.onclick=()=>{
                     
                      // console.log(content.className,leftcolumn.className)
                      switch(content.className) {
                        case "content":
                          content.className="content2";
                          leftcolumn.className="leftcolumn2"
                          window.reload();
                        case "content2":
                          content.className="content3";
                          leftcolumn.className="leftcolumn3"
                          window.reload();
                        case "content3":
                          content.className="content";
                          leftcolumn.className="leftcolumn";
                          window.reload();
                        default:
                          content.className="content"
  
                      }
                    }
                    });</script>
</head>
<body onload="apeleaza()">        
        <div id="wrapper">
            <div id="navigationwrap">
            <div id="navigation">
                    <img src="utils/wewslogo.png" width="19.3%" height="40px" >
                    
                           
                        <div>
                            <a href="components\login\login.php"><input type="submit" value="Login" /></a>
                            <a href="components\register\register.php"><input type="submit" value="Register" /></a>
                        </div>    
                           
        
            </div>
            </div>
            <div id="leftcolumnwrap">
               
            <div class="leftcolumn" id="leftcolumn">
                
                    <h4 >Main Categories</h4>
                  <script type="text/javascript">
                     var categories = ["Politics","Sport","Fashion","World","Business","Technology","Lifestyle","Science","Countries"]
                    
                    var leftColumnCategories = document.getElementById("leftcolumn");
                    for(let i=0 ;i<categories.length;i++){
                      let div = document.createElement("div");
                      div.className="normalTab";
                      div.id="normalTab";
                      let a = document.createElement("a");
                      // a.href=`${categories[i]}.html`;
                      var categoryChosen;
                      a.onclick = () =>{
                        localStorage.setItem("categoryChosen",categories[i]);
                        //ReRender;







                        


                        // a.onclick = () =>{
                        // localStorage.setItem("categoryChosen",chosenCategories[i]);
                        // window.location.reload();
                        let myDate = new Date().toLocaleString().split("/");

                       console.log(chosenCategories[i])
                       let url = "https://newsapi.org/v2/everything?q="+categories[i]+"&from="+`${myDate[2]}-${myDate[1]}-${myDate[0]}`+"&sortBy=publishedAt&apiKey=e398102c8e4c427785f47baec13e7c9e";
                      fetch(url,{
                                method: "GET", // *GET, POST, PUT, DELETE, etc.
                                mode: "cors", // no-cors, cors, *same-origin
                                cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
                                credentials: "same-origin", // include, *same-origin, omit
                                headers: {
                                    "Authorization": "sBBqsGXiYgF0Db5OV5tAwwn-goPbGlRiLBOzb4JEYUeYV7ReNffphH229qzYYKROn2pHZrSf1gT2PUujH1YaQA",
                                },
                            })
                    .then(response => response.json())
                    .then(res=>{
                      loading=false;
                      yolo=res;
                      let content = document.getElementById("content");
                      content.innerHTML = '';
                      let mainList = document.createElement('ul');
                      let entries = res.articles;
                      let category = localStorage.getItem("categoryChosen");
                         let h3 = document.createElement("h3");
                         h3.appendChild(document.createTextNode((`Latest ${category} news!`)));
                         h3.style="text-align: center"
                         let div = document.getElementById("content");
                         div.append(h3);

                         let a = document.createElement("a");
                      var categoryChosen;
                      a.onclick = () =>{
                        fetch("http://localhost:1443/proiectTW/api/chosencategories/create.php", {
                                method: "POST", // *GET, POST, PUT, DELETE, etc.
                                mode: "cors", // no-cors, cors, *same-origin
                                cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
                                credentials: "same-origin", // include, *same-origin, omit
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                redirect: "follow", // manual, *follow, error
                                referrer: "no-referrer", // no-referrer, *client
                                body: JSON.stringify({username: currentUsername, category: category}), // body data type must match "Content-Type" header
                            })
                            .then(response => response.json())
                            .then(res=>{
                              window.location.reload();
                            })
                            .catch(err=>console.log(err)); // parses JSON response into native Javascript objects 
                        // window.location.reload();
                      }
                      a.innerHTML=`Add ${category} to favorite`;
                      
                      mainList.appendChild(a);


                      a = document.createElement("a");
                      a.onclick = () =>{
                        fetch("http://localhost:1443/proiectTW/api/chosencategories/delete.php", {
                                method: "POST", // *GET, POST, PUT, DELETE, etc.
                                mode: "cors", // no-cors, cors, *same-origin
                                cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
                                credentials: "same-origin", // include, *same-origin, omit
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                redirect: "follow", // manual, *follow, error
                                referrer: "no-referrer", // no-referrer, *client
                                body: JSON.stringify({username: currentUsername, category: category}), // body data type must match "Content-Type" header
                            })
                            .then(response => response.json())
                            .then(res=>console.log(res))
                            .catch(err=>console.log(err)); // parses JSON response into native Javascript objects 
                        window.location.reload();
                      }
                      a.innerHTML=`Remove ${category} from favourite`;
                      
                      mainList.appendChild(a);

                      for(var i=0; i<entries.length; i++){
                        var listItem = document.createElement('li');
                        listItem.style="text-align: center; border: 1px solid black; margin-top: 10px; padding: 3%; height: 150px;"
                        var title = (i+1)+" . "+entries[i].title;
                        title.style="color: #C0DFD9; font-weight: 800;"
                        var contentSnippet = entries[i].content;
                        var contentSnippetText = document.createTextNode(contentSnippet);
                        var link = document.createElement('a');
            link.setAttribute('href', entries[i].url);
            link.setAttribute('target','_blank');
            var text = document.createTextNode(title);
            link.appendChild(text);
            link.style="color: black; font-weight: 800;"
            listItem.appendChild(link);
            var desc = document.createElement('p');
            desc.appendChild(contentSnippetText);
            var x = document.createElement("IMG");
  x.setAttribute("src",entries[i].urlToImage);
  x.setAttribute("width", "304");
  x.setAttribute("height", "228");
  x.setAttribute("alt", entries[i].author);
  listItem.appendChild(x);
            // add description to list item
            listItem.appendChild(desc);
                      
            // adding list item to main list
            mainList.appendChild(listItem);
                      }
                      console.log(mainList)
                      content.appendChild(mainList);
                      console.log(res)
                    }); 
                        
                      


















































                        // window.location.reload();
                      }
                      a.innerHTML=categories[i];
                      div.appendChild(a);
                    leftColumnCategories.appendChild(div);


                     


                    }   


                    
                  // alert(strUser);
                    </script>
                    
                    <h4 id="favoriteCategories">Your favorite categories</h4>    

                    <script> 
                    for(let i=0 ;i<chosenCategories.length;i++){
                      let div = document.createElement("div");
                      div.className="normalTab";
                      div.id="normalTab";
                      let a = document.createElement("a");
                      // a.href=`${categories[i]}.html`;
                      a.onclick = () =>{
                        localStorage.setItem("categoryChosen",chosenCategories[i]);
                        // window.location.reload();
                        let myDate = new Date().toLocaleString().split("/");

                       console.log(chosenCategories[i])
                       let url = "https://newsapi.org/v2/everything?q="+chosenCategories[i]+"&from="+`${myDate[2]}-${myDate[1]}-${myDate[0]}`+"&sortBy=publishedAt&apiKey=e398102c8e4c427785f47baec13e7c9e";
                      fetch(url,{
                                method: "GET", // *GET, POST, PUT, DELETE, etc.
                                mode: "cors", // no-cors, cors, *same-origin
                                cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
                                credentials: "same-origin", // include, *same-origin, omit
                                headers: {
                                    "Authorization": "sBBqsGXiYgF0Db5OV5tAwwn-goPbGlRiLBOzb4JEYUeYV7ReNffphH229qzYYKROn2pHZrSf1gT2PUujH1YaQA",
                                },
                            })
                    .then(response => response.json())
                    .then(res=>{
                      loading=false;
                      yolo=res;
                      let content = document.getElementById("content");
                      content.innerHTML = '';
                      let mainList = document.createElement('ul');
                      let entries = res.articles;

                      for(var i=0; i<entries.length; i++){
                        var listItem = document.createElement('li');
                        listItem.style="text-align: center; border: 1px solid black; margin-top: 10px; padding: 3%; height: 150px;"
                        var title = (i+1)+" . "+entries[i].title;
                        title.style="color: #C0DFD9; font-weight: 800;"
                        var contentSnippet = entries[i].content;
                        var contentSnippetText = document.createTextNode(contentSnippet);
                        var link = document.createElement('a');
            link.setAttribute('href', entries[i].url);
            link.setAttribute('target','_blank');
            var text = document.createTextNode(title);
            link.appendChild(text);
            link.style="color: black; font-weight: 800;"
            listItem.appendChild(link);
            var desc = document.createElement('p');
            desc.appendChild(contentSnippetText);
            var x = document.createElement("IMG");
  x.setAttribute("src",entries[i].urlToImage);
  x.setAttribute("width", "304");
  x.setAttribute("height", "228");
  x.setAttribute("alt", entries[i].author);
  listItem.appendChild(x);
            // add description to list item
            listItem.appendChild(desc);
                      
            // adding list item to main list
            mainList.appendChild(listItem);
                      }
                      console.log(mainList)
                      content.appendChild(mainList);

                      // let myDiv = document.createElement("div");
                      // myDiv.appendChild(document.createTextNode((`Latest ${category} news!`)));
                      // myDiv.style="text-align: center; border: 1px solid black; margin-top: 10px; padding: 3%;"
                        //  let div = document.getElementById("content");
                        //  div.append(h3);


                      // res.map(it=>{

                      //   myDiv.insertAdjacentHTML('beforeend',it.structuredText);
                      //   div.append(myDiv)
                      // })
                      // currentNewsList = res;
                        // window.location.reload();
                      // window.location.reload();
                      console.log(res)
                      // loadingText.appendChild(document.createTextNode((`DONE!`)));
                    }); 
                        //ReRender;
                        // window.location.reload();
                      }
                      a.innerHTML=chosenCategories[i];
                      div.appendChild(a);
                    leftColumnCategories.appendChild(div);


                    }   
                    </script>
                    <?php echo '<script type="text/javascript">' ;
                        echo 'console.log("ASDASD")';

                    
                    
                    
                    echo '</script>' 
                    ?> 
                    <hr/>
                   
             
              
                                      <h4 >Options</h4>
                    <div id="changeTheme" class="normalTab">CHANGE THEME</div>
                    <hr/>
                    <h4  id="favoriteCategories" >Your chosen topics</h4> 
              
            </div>
            
            </div >
            <div id="contentwrap">
               
               
               
                <div class="content" id="content">
                    <script type="text/javascript">
                         let category = localStorage.getItem("categoryChosen");
                         let h3 = document.createElement("h3");
                         h3.appendChild(document.createTextNode((`Latest ${category} news!`)));
                         h3.style="text-align: center"
                         let div = document.getElementById("content");
                         div.append(h3);
                        

                         let a = document.createElement("a");
                      var categoryChosen;
                      a.onclick = () =>{
                        fetch("http://localhost:1443/proiectTW/api/chosencategories/create.php", {
                                method: "POST", // *GET, POST, PUT, DELETE, etc.
                                mode: "cors", // no-cors, cors, *same-origin
                                cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
                                credentials: "same-origin", // include, *same-origin, omit
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                redirect: "follow", // manual, *follow, error
                                referrer: "no-referrer", // no-referrer, *client
                                body: JSON.stringify({username: currentUsername, category: category}), // body data type must match "Content-Type" header
                            })
                            .then(response => response.json())
                            .then(res=>console.log(res))
                            .catch(err=>console.log(err)); // parses JSON response into native Javascript objects 
                        window.location.reload();
                      }
                      a.innerHTML=`Add ${category} to favorite`;
                      
                      div.appendChild(a);


                      a = document.createElement("a");
                      a.onclick = () =>{
                        fetch("http://localhost:1443/proiectTW/api/chosencategories/delete.php", {
                                method: "POST", // *GET, POST, PUT, DELETE, etc.
                                mode: "cors", // no-cors, cors, *same-origin
                                cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
                                credentials: "same-origin", // include, *same-origin, omit
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                redirect: "follow", // manual, *follow, error
                                referrer: "no-referrer", // no-referrer, *client
                                body: JSON.stringify({username: currentUsername, category: category}), // body data type must match "Content-Type" header
                            })
                            .then(response => response.json())
                            .then(res=>console.log(res))
                            .catch(err=>console.log(err)); // parses JSON response into native Javascript objects 
                        window.location.reload();
                      }
                      a.innerHTML=`Remove ${category} from favourite`;
                      
                      div.appendChild(a);
                      
                         // de adaugat inca un for cu lista de stiri dupa apelarea API-ului.
                       
                    
                        //  window.location.reload();
                    </script>
                

                  <h3 id="loadingh3"> <h3>
                   
                
                </div>
            </div>
            <div>
                      <label for="searchText"> Advanced Search - Content:</label>
                       <input id="searchText" type="text" name="text"></input>
                       
                       <label for="typeSelect"> Where:</label>
                       <select id="typeSelect"> 
                          <option value="text">Text</option>
                          <option value="title">Title</option>
                          <option value="WebsiteName">WebsiteName</option>
                       </select>

                       <label for="languageSelect"> Language:</label>
                       <select id="languageSelect"> 
                          <option value="EN">English</option>
                          <option value="FR">French</option>
                          <option value="DE">German</option>
                          <option value="ES">Spanish</option>
                          <option value="IT">Italian</option>
                          <option value="RO">Romanian</option>
                          <option value="RO">Russian</option>
                       </select>


                       //en es de fr it ru ro
                  </div>
                  <button id="myButton"> Get news</button>
                  <button id="showNews"> Save this topic</button>
                  <script>
                      var yolo;
                    let headers = {Authorization: "sBBqsGXiYgF0Db5OV5tAwwn-goPbGlRiLBOzb4JEYUeYV7ReNffphH229qzYYKROn2pHZrSf1gT2PUujH1YaQA"}
                    var myButton = document.getElementById("myButton");
                    myButton.onclick = () =>{
                      var loadingText = document.getElementById("loadingh3");
                      // loadingText.appendChild(document.createTextNode((`Loading ${category} news!`)));
                      var loading = true;
                      var toSearch = document.getElementById("searchText").value;
                      var where = document.getElementById("typeSelect").value;
                      var language = document.getElementById("languageSelect").value;
                      let content = document.getElementById("content");
                      content.innerHTML = 'Searching through many news... Please wait.';
                      
                      console.log(where,toSearch);
                      if(where=="WebsiteName"){
                        where="website.domainName";
                      }
                      let url = "https://api.newsriver.io/v2/search?query=language%3A"+language+"%20AND%20"+where+"%3A"+toSearch+"&limit=7";
                      localStorage.setItem("loading",'true');
                      fetch(url,{
                                method: "GET", // *GET, POST, PUT, DELETE, etc.
                                mode: "cors", // no-cors, cors, *same-origin
                                cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
                                credentials: "same-origin", // include, *same-origin, omit
                                headers: {
                                    "Authorization": "sBBqsGXiYgF0Db5OV5tAwwn-goPbGlRiLBOzb4JEYUeYV7ReNffphH229qzYYKROn2pHZrSf1gT2PUujH1YaQA",
                                },
                            })
                    .then(response => response.json())
                    .then(res=>{
                      loading=false;
                      yolo=res;
                      

                      let content = document.getElementById("content");
                      content.innerHTML = '';
                      let mainList = document.createElement('ul');


                              for(var i=0; i<res.length; i++){
                                var listItem = document.createElement('li');
                                listItem.style="text-align: center; border: 1px solid black; margin-top: 10px; padding: 3%; height: 150px;"
                                var title = (i+1)+" . "+res[i].title;
                                title.style="color: #C0DFD9; font-weight: 800;"
                                var contentSnippet = res[i].text;
                                var contentSnippetText = document.createTextNode(contentSnippet);
                                var link = document.createElement('a');
                    link.setAttribute('href', res[i].url);
                    link.setAttribute('target','_blank');
                    var text = document.createTextNode(title);
                    link.appendChild(text);
                    link.style="color: black; font-weight: 800;"
                    listItem.appendChild(link);
                    var desc = document.createElement('p');
                    desc.appendChild(contentSnippetText);
          //           var x = document.createElement("IMG");
          // x.setAttribute("src",res[i].urlToImage);
          // x.setAttribute("width", "304");
          // x.setAttribute("height", "228");
          // x.setAttribute("alt", res[i].author);
          // listItem.appendChild(x);
                    // add description to list item
                    listItem.appendChild(desc);
                              
                    // adding list item to main list
                    mainList.appendChild(listItem);
                              }
                              console.log(mainList)
                              content.appendChild(mainList);










                          localStorage.setItem("loading",'false');        

                      
                      // window.location.reload();
                      // console.log(currentNewsList)
                      console.log(res)
                      // loadingText.appendChild(document.createTextNode((`DONE!`)));
                    }); // parses JSON response into native Javascript objects 
                    
                    
                    
                        //ReRender;
                        // window.location.reload();
                      }
                      var myButton2 = document.getElementById("showNews");
                      myButton2.onclick = () =>{
                        var toSearch = document.getElementById("searchText").value;
                      var where = document.getElementById("typeSelect").value;
                      var language = document.getElementById("languageSelect").value;
                      let categoryToSend=`${toSearch}-${language}-${where}`
                      
                      yolo.map(res=>{
                        let toSend = {
                          name: currentUsername,
                        category: categoryToSend,
                        author: res.website ? res.website.name : "Anonim",
                        content: res.text,
                        title : res.title,
                        url: res.url,
                        urlToImage: 'NoImg',
                        description: res.text
                        };
                    console.log(toSend)
                    fetch("http://localhost:3000/setUserNews", {
                                method: "POST", // *GET, POST, PUT, DELETE, etc.
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                body: JSON.stringify(toSend), // body data type must match "Content-Type" header
                            })
                            .then(response => response.json())
                            .then(res=>{
                              console.log(res);
                              window.location.reload();
                            })
                            .catch(err=>console.log(err));

                      })
                      // yolo.map(res=>{
                      //   fetch("http://localhost:3000/setUserNews", {
                      //           method: "POST", // *GET, POST, PUT, DELETE, etc.
                      //           mode: "cors", // no-cors, cors, *same-origin
                      //           cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
                      //           credentials: "same-origin", // include, *same-origin, omit
                      //           headers: {
                      //               "Content-Type": "application/json",
                      //           },
                      //           redirect: "follow", // manual, *follow, error
                      //           referrer: "no-referrer", // no-referrer, *client
                      //           body: JSON.stringify({name: currentUsername, category: categoryToSend}), // body data type must match "Content-Type" header
                      //       })
                      //       .then(response => response.json())
                      //       .then(res=>{
                      //         window.location.reload();
                      //       })
                      //       .catch(err=>console.log(err));
                      // })
                      // let toSend = {
                      //   name: currentUsername,
                      //   category: categoryToSend,
                      //   author: 
                      // }
                        // parses JSON response into native Javascript objects 
                        console.log(yolo,categoryToSend)
                        
                      }

                     
                    </script>
            <div id="footerwrap">
            <div id="footer">
                    <a href="https://github.com/DragosRomaniuc/ProiectTwWews"  ><img src="utils/github.png" width="40px" height="40px"></a>
            </div>
            </div>
        </div>
    </body>

</html>
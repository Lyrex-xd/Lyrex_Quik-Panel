<?php

if(isset($_GET['q'])) {
  $search_value = $_GET['q'];
  $mini_search = strtolower($search_value);
  if($mini_search == "udemy") {
    header("Location: https://www.udemy.com/home/my-courses/learning/");
  }else if ($mini_search == "github") {
    header("Location: https://github.com/");
  }else if ($mini_search == "repo" || $mini_search == "repository" || $mini_search == "depo") {
    header("Location: https://github.com/Lyrex-xd?tab=repositories");
  }else if ($mini_search == "youtube") {
    header("Location: https://www.youtube.com/");
  }else if ($mini_search == "disney" || $mini_search == "disney plus" || $mini_search == "disney+") {
    header("Location: https://www.disneyplus.com/tr-tr/home");
  }else if (substr($mini_search, 0, 3) == "yt:") {
    header("Location: https://www.youtube.com/results?search_query=". substr($_GET['q'], 3));
  }
  else {
    header("Location: https://www.google.com/search?q=".$_GET['q']);
  }
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lyrex Quick Panel</title>
    <link rel="stylesheet" href="./assets/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/style.css">
    <link rel='stylesheet prefetch' href='https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>
    <link rel="stylesheet" href="./assets/lib/mdi/css/materialdesignicons.min.css">
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
</head>
<body>
  <div class="localhost_box" id="localhost_box">
    <div class="closenav" id="local_nav">
    <button class="localhost_button hidden" id="back_arrow" onclick="back()"><i class="mdi mdi-arrow-left"></i></button>
    <button class="localhost_button openlogo" onclick="openlocal()"><i class="mdi mdi-webpack"></i></button>
    <button class="localhost_button hidden" id="reload_icon" onclick="reload()"><i class="mdi mdi-reload"></i></button>
    <button class="localhost_button hidden" id="openweb" onclick="open_web()"><i class="mdi mdi-search-web"></i></button>
    </div><br>
    <iframe src="http://localhost/" frameborder="0" class="closeframe" id="local_iframe"></iframe>
  </div>
<!--  Header Content  -->
<div class='veenir-google-header'>
  <div class='veenir-google-header-content'>
    <a href="https://accounts.google.com/b/0/AddMailService" class='veenir-google-content'>Gmail</a>  
    <div href="https://www.google.com.tr/imghp?hl=tr&tab=ri&ogbl" class='veenir-google-content'>Images</div>
  </div>
</div>
<!-- End of Header -->
  
<!--  Search Area  -->
  <div class='veenir-google-s'>
  <div class='veenir-google-search-container'>
    <div class='veenir-google-image'>
      <img class='google-img' alt="Google Picture" src="./lyrex-logo.png"/>
    </div>
    <form action="#" method="get">
    <div class='veenir-google-search-textbox'>
      <span class='ion-android-search search-icon'></span>
      <input type='text' name="q" placeholder='Serach' class='azarblah'>
    </div>
  </div>
  </div>
<!--  End of search area  -->
  
<!--Abel  I don't know what is this tabs lol   -->
  <div class='dont-know-veenir-googe'>
    <input type="submit" class='dont-know-items-veenir-google' value="Google Search">
  </div>
</form>

  <div class="circle_button_menu not_select">

    <div class="circle_button">
      <img src="" alt="" id="circle_button_image">
      <h2 id="circle_button_title"></h2>
    </div>

  </div>

  <p class="versions">Lyrex Quik Panel v1.1</p>

  <script src="./assets/script/main.js"></script>
</body>
</html>
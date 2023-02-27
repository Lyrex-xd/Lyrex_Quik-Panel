<?php

include('./assets/data/bg-config.php');
require_once('./assets/data/conn.php');
require_once('./assets/data/main_class.php');
$json = file_get_contents("./assets/data/bg-data.json"); // dosyayı oku
$data = json_decode($json, true); // JSON verilerini PHP dizisine dönüştür
$main = new Main();

$fav_web_table = $conn->prepare('SELECT * FROM fav_web');
$fav_web_table->execute();

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

if(isset($_POST['url'])) {
  if(!empty('url')){
    $url = $_POST['url'];
    if(isset($_POST['name'])) {
      $name = $_POST['name'];
      $site_name = mb_convert_case($_POST['name'], MB_CASE_TITLE, "UTF-8");
      $icon_src = $main->get_script($url);
      $add_fav_url = $conn->prepare("INSERT INTO fav_web SET href=:href , icon_src=:icon_src , icon_commit=:icon_commit , title=:title");
      $add_fav_url->execute(array(
        "href" => $url,
        "icon_src" => $icon_src,
        "icon_commit" => $site_name,
        "title" => $site_name
      ));
      header("Refresh: 0.3; url=http://localhost/Lyrex_Quik_Panel/?xD");
    }else{
      // sonra yapcaz
    }
  }else{
    header('Location: .?error=01');
  }
}

if(isset($_GET['del'])) {
  $fav_sil = $conn->prepare("DELETE FROM fav_web WHERE id=:web_id");
  $fav_sil->execute(
    array(
      "web_id" => $_GET['del']
    )
  );
  header("Refresh: 0.3; url=http://localhost/Lyrex_Quik_Panel/?xD");
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
    <link rel="shortcut icon" href="./assets/Image/icon/favicon.ico" type="image/x-icon">
</head>
<body>
  <iframe class="bg_frame" src="<?php echo $data['active-bg-source'] ?>" frameborder="0"></iframe>

  <div class="bg_selector_content" id="bg_selector_content">
    <div class="bg_selector_from">
      <h1>Arka Plan</h1>
      <form action="#" method="post">
        <div>
          <?php
          foreach($data["packs"] as $packs){
          ?>
          <div class="bg_selector_img_content">
            <div class="bg_selector_img_content_box">
              <iframe src="./assets/bg-packs/<?php echo $packs["folder-name"] ?>/<?php echo $packs["main-file"] ?>" frameborder="0"> </iframe>
              <div class="bg_selector_img_content_bottom">
                <div>
                <p class="bg_selector_img_paragraph"><?php echo $packs["name"] ?></p>
                <span><?php echo $packs["created"] ?></span>
                </div>
                <input type="radio" class="bg_selector_radio_input" name="bg" value="<?php echo $packs["folder-name"] ?>" id="bg">
              </div>
            </div>
          </div>
          <?php
          }
          if(count($data["packs"]) == 0) {
            echo "Arka plan bulunamadı!";
          }
          ?>
        </div>
        <input type="submit" value="Uygula" class="btn btn-primary">
      </form>
    </div>
  </div>

  <div class="add_web_site_content"  id="add_web_site_content">
    <div class=" register_web_site">
      <form action="#" method="post" id="myForm">
        <div class="mb-3">
        <h1>Yeni Site Ekle</h1>
        </div>
        <div class="mb-3">
        <label for="name">Ad:</label><br>
        <input type="text" name="name" id="name" placeholder="Doldurmak Zorunda Değilsin">
        </div>
        <div class="mb-3">
        <label for="url">URL:</label><br>
        <input type="text" name="url" id="url" placeholder="https://">
        </div>
        <div class="mb3">
          <input type="submit" value="Ekle" class="btn btn-primary">
        </div>
      </form>
    </div>
  </div>

  <div class="localhost_box" id="localhost_box">
    <div class="closenav" id="local_nav">
    <button class="localhost_button hidden" title="Back Arrow" id="back_arrow" onclick="back()"><i class="mdi mdi-arrow-left"></i></button>
    <button class="localhost_button openlogo" title="Localhost" onclick="openlocal()"><i class="mdi mdi-webpack"></i></button>
    <button class="localhost_button hidden" title="Refresh" id="reload_icon" onclick="reload()"><i class="mdi mdi-reload"></i></button>
    
    <div class="localhost_button hidden url_bar_div" id="url_bar_div">
      <form method="get">
        <div><button onclick="open_web()" class="localhost_button hidden" title="Open In New Web Page" id="openweb"><img src="./assets/Image/icon/open_in_new_window.png" alt=""></button>
        <input type="text" onchange="yonlendir()" class="url_bar_input" id="url_bar_input"></div>
      </form>  
    </div>
    
    </div><br>
    <iframe onload="load_page()" src="http://localhost/local.php" frameborder="0" class="closeframe" id="local_iframe">
    </iframe>
  </div>
<!--  Header Content  -->
<div class='veenir-google-header'>
  <div class='veenir-google-header-content'>
    <a href="https://chat.openai.com/chat" target="_blank" class='veenir-google-content'><img class="browser_logo" src="./assets/Image/Logo/cheat-gpt.png" title="Cheat GPT" alt="Cheat GPT Logo"></a>
    <a href="https://www.google.com" target="_blank" class='veenir-google-content'><img class="browser_logo" src="./assets/Image/Logo/Google_logo.png" title="Google" alt="Google Logo"></a>  
    <a href="https://www.you.com" target="_blank" class='veenir-google-content'><img class="browser_logo" src="./assets/Image/Logo/You_logo.png" title="You Browser" alt="You Logo"></a>
    <a onclick="open_bg_change()" class='veenir-google-content'><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="browser_logo"><title>Arka Plan Değiştir</title><path d="M22.7 14.3L21.7 15.3L19.7 13.3L20.7 12.3C20.8 12.2 20.9 12.1 21.1 12.1C21.2 12.1 21.4 12.2 21.5 12.3L22.8 13.6C22.9 13.8 22.9 14.1 22.7 14.3M13 19.9V22H15.1L21.2 15.9L19.2 13.9L13 19.9M11.21 15.83L9.25 13.47L6.5 17H13.12L15.66 14.55L13.96 12.29L11.21 15.83M11 19.9V19.05L11.05 19H5V5H19V11.31L21 9.38V5C21 3.9 20.11 3 19 3H5C3.9 3 3 3.9 3 5V19C3 20.11 3.9 21 5 21H11V19.9Z" /></svg></a>
  </div>
</div>
<!-- End of Header -->
  
<!--  Search Area  -->
  <div class='veenir-google-s'>
  <div class='veenir-google-search-container'>
    <div class='veenir-google-image'>
      <img class='google-img' alt="Google Picture" src="./assets/Image/logo/lyrex-logo-quik-panel.png"/>
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

  <div class="container mt-5 circle_button_menu not_select">
    <div class="row d-flex justify-content-center">
      <?php
      foreach($fav_web_table as $web_site) {
      ?>
      <div class="col-sm-4 circle_button" onmouseenter="goster(<?php echo($web_site['id']) ?>)" onmouseleave="gizle(<?php echo($web_site['id']) ?>)">
        <div class="delete_fav"><a id="close_button-<?php echo ($web_site['id']) ?>" href="?del=<?php echo ($web_site['id']); ?>">x</a></div>
        <a href="<?php echo($web_site['href']); ?>" target="_blank">
          <img src="<?php echo($web_site['icon_src']); ?>" alt="<?php echo($web_site['icon_commit']); ?>" id="circle_button_image">
          <h2 id="circle_button_title"><?php echo($web_site['title']); ?></h2>
        </a>
      </div>
    <?php
      }
    ?>
    <div class="col-sm-4 circle_button" id="new_web_button">
        <a onclick="new_web_page_open()" target="_blank">
          <img src="./assets/Image/icon/add_icon.png" class="add_icon" alt="add_icon" id="circle_button_image">
          <h2 id="circle_button_title">Yeni Ekle</h2>
        </a>
      </div>
    </div>
  </div>

  <p class="versions">Lyrex Quik Panel v1.1</p>

  <script src="./assets/script/main.js"></script>
</body>
</html>
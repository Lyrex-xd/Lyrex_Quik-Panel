<?php

class Main {

  public function getir($baslangic, $son, $cekilmek_istenen)
  {
  @preg_match_all('/' . preg_quote($baslangic, '/') .
  '(.*?)'. preg_quote($son, '/').'/i', $cekilmek_istenen, $m);
  return @$m[1];
  }

    public function get_script(string $url) {
      $check_web_site = substr($url,0 , 7);
      if ($check_web_site == "https:/" || $check_web_site == "http://") {
        if (($data = @file_get_contents($url)) === false) {
          return "./assets/Image/icon/not_found.png";
        } else {
          $icon_url_array = $this->getir('rel="icon"','>',$data);
          if(count($icon_url_array) == 0) {
            $icon_url_array = $this->getir('rel="shortcut icon"','>',$data);
          }else if(count($icon_url_array) == 0) {
            $icon_url_array = $this->getir('rel="apple-touch-icon"','>',$data);
          }else if(count($icon_url_array) == 0) {
            $icon_url_array = $this->getir('meta content="','" itemprop="image"', $data);
          }else {
            return "./assets/Image/icon/not_found.png";
          }

        $icon_url = $this->getir('href="', '"', $icon_url_array[0]);
        return $icon_url[0];
        }
      }else {
        // girilen bir web adresi değilse bu olasılık dönecek
        return "./assets/Image/icon/not_found.png";
      }
    }
}

?>
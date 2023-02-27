<?php

// Info.json dosyalarının bulunduğu klasörü belirleyin
$dir = "./assets/bg-packs/";

// Info.json dosyalarındaki verileri depolamak için boş bir dizi oluşturun
$info_data = array();

// Klasördeki tüm dosyaları döngüye alın
foreach(glob($dir.'*', GLOB_ONLYDIR) as $folder) {
    // Info.json dosyasını belirleyin
    $info_file = $folder.'/info.json';
    // Dosya varsa
    if(file_exists($info_file)) {
        // Dosyayı okuyun ve JSON formatına dönüştürün
        $json_data = file_get_contents($info_file);
        $info = json_decode($json_data, true);
        // Diziye verileri ekleyin
        $info_data[] = array(
            "name" => $info["name"],
            "folder-name" => $info["folder-name"],
            "version" => $info["version"],
            "created" => $info["created"],
            "main-file" => $info["main-file"],
            "folder" => $folder
        );
    }
}

// Bg-data.json dosyasını okuyun ve JSON formatına dönüştürün
$json_data = file_get_contents("./assets/data/bg-data.json");
$data = json_decode($json_data, true);

// Silinmiş klasörleri tutmak için bir dizi oluşturun
$deleted_folders = array();

// Packs dizisindeki her paket için döngü
foreach ($data["packs"] as $key => $value) {
    $found = false;
    // Her paket için isim kontrolü yapın
    foreach ($info_data as $info) {
        if ($value["name"] == $info["name"]) {
            // Eşleşme varsa found değişkenini true olarak ayarlayın
            $found = true;
            // Silinmiş klasörleri silmek için listeden çıkarın
            $key = array_search($info["folder"], $deleted_folders);
            if ($key !== false) {
                unset($deleted_folders[$key]);
            }
            break;
        }
    }
    // Eşleşme yoksa, packs dizisinden veriyi silin
    if (!$found) {
        unset($data["packs"][$key]);
    }
}

// Yeni paketleri packs dizisine ekleyin ve klasörü oluşturun
foreach ($info_data as $info) {
    $found = false;
    // Her paket için isim kontrolü yapın
    foreach ($data["packs"] as $value) {
        if ($value["name"] == $info["name"]) {
            // Eşleşme varsa found değişkenini true olarak ayarlayın
            $found = true;
            break;
        }
    }
    // Eşleşme yoksa, packs dizisine verileri ekleyin ve klasörü oluşturun
    if (!$found) {
        $data["packs"][] = array(
            "name" => $info["name"],
            "folder-name" => $info["folder-name"],
            "version" => $info["version"],
            "created" => $info["created"],
            "main-file" => $info["main-file"]
        );

        // Klasör yoksa, packs dizisinden veriyi silin
        if (!is_dir($info["folder"])) {
            unset($data["packs"][$key]);
            // Silinmiş klasörleri tutmak için listeye ekleyin
            $deleted_folders[] = $info["folder"];
        }
    }
}

// Silinmiş klasörlerden her biri için packs dizisindeki verileri silin
foreach ($deleted_folders as $deleted_folder) {
    foreach ($data["packs"] as $key => $value) {
        if ($value["folder"] == $deleted_folder) {
            unset($data["packs"][$key]);
            break;
        }
    }
}

// Bg-data.json dosyasına güncellenmiş verileri yazın
$json_data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
file_put_contents("./assets/data/bg-data.json", $json_data);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bg = $_POST['bg'];
    $bg_source = './assets/data/bg-data.json';

    $bg_path = './assets/bg-packs/' . $bg . '/';
    $bg_path = mb_convert_encoding($bg_path, 'UTF-8');

    $data = json_decode(file_get_contents($bg_source), true);
    $data['active-bg-source'] = $bg_path;
    file_put_contents($bg_source, json_encode($data));
}

?>
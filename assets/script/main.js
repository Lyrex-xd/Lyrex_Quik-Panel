// Local penceresinin başta açık mı olmmalı kapalı mı olmalı onu belirliyor.
let kontrol = false;
// Local host penceresi elementlerinin tanımlaması
let local_window = document.getElementById("localhost_box");
let local_iframe = document.getElementById("local_iframe");
let local_nav = document.getElementById("local_nav");
let back_arrow = document.getElementById("back_arrow");
let reload_icon = document.getElementById("reload_icon");
let openweb = document.getElementById("openweb");
let url_bar = document.getElementById("url_bar_div");
let url_bar_input = document.getElementById('url_bar_input'); 

// local menünün düzgün bir şekilde açılması için gerekli ayarlamaları yapar
function openlocal() {
    if (kontrol == false) {
        local_window.setAttribute("class","localhost_box openlocal");
        local_iframe.setAttribute("class","openframe");
        local_nav.setAttribute("class","opennav");
        setTimeout(() => {  
            reload_icon.style.display= "contents";
            back_arrow.style.display= "contents";
            openweb.style.display= "contents";
            url_bar.style.display = "contents";
        }, 1000);

        url_bar_input.value = local_iframe.contentWindow.location.href;

        console.log("Açıldı");
        kontrol = true;
    }else if(kontrol == true){
        local_window.setAttribute("class","localhost_box closelocal");
        local_iframe.setAttribute("class","closeframe");
        local_nav.setAttribute("class","closenav");
        local_nav.setAttribute("class","openweb");
        reload_icon.style.display= "none";
        back_arrow.style.display= "none";
        openweb.style.display= "none";
        url_bar.style.display = "none";
        console.log("Kapandı");
        kontrol = false;
    }
}

// ekran yüklendiği zaman yapılacaklar bir işlem var ise burada yapılır.
function load_page() {
    console.log("Yüklendi");
}

function yonlendir() {
    console.log("değiştirildi")
    local_iframe.src = document.getElementById('url_bar_input');
    
}

function back() {
    local_iframe.contentWindow.history.back();
}

function reload() {
    local_iframe.contentWindow.location.reload();
}

function open_web() {
    window.open(local_iframe.contentWindow.location.href, "_blank");
}

function new_web_page_open() {
    add_web_site_content.setAttribute('class','block add_web_site_content')
}

function goster(id) {
    document.getElementById('close_button-'+ id).style.display = "block";
}

function gizle(id) {
    document.getElementById('close_button-'+ id).style.display = "none";
}
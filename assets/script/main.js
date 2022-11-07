let kontrol = false;
let local_window = document.getElementById("localhost_box");
let local_iframe = document.getElementById("local_iframe");
let local_nav = document.getElementById("local_nav");
let back_arrow = document.getElementById("back_arrow");
let reload_icon = document.getElementById("reload_icon");
let openweb = document.getElementById("openweb");

function openlocal() {
    if (kontrol == false) {
        local_window.setAttribute("class","localhost_box openlocal");
        local_iframe.setAttribute("class","openframe");
        local_nav.setAttribute("class","opennav");
        setTimeout(() => {  back_arrow.style.display= "contents"; }, 1000);
        setTimeout(() => {  reload_icon.style.display= "contents"; }, 1000);
        setTimeout(() => {  openweb.style.display= "contents"; }, 1000);
        console.log("Açıldı");
        kontrol = true;
    }else if(kontrol == true){
        local_window.setAttribute("class","localhost_box closelocal");
        local_iframe.setAttribute("class","closeframe")
        local_nav.setAttribute("class","closenav");
        local_nav.setAttribute("class","openweb");
        back_arrow.style.display= "none";
        reload_icon.style.display= "none";
        openweb.style.display= "none";
        console.log("Kapandı");
        kontrol = false
    }
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
function location_confirm(txt, url) {
    ret = confirm(txt);
    if(ret) {
        window.location.href=url;
    }
}
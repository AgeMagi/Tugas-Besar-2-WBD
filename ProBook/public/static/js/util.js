function doAjax(url, method, data, successCallback,failCallback) {
    let req = new XMLHttpRequest();
    req.open(method, url, true);
    req.setRequestHeader("Content-Type", "application/json");
    req.onload = function(){
        if (this.status==200){
            successCallback(JSON.parse(req.responseText));
        } else {
            console.log(req.responseText);
            failCallback(JSON.parse(req.responseText));
        }
    };
    let payload = data;
    req.send(JSON.stringify(payload));
}
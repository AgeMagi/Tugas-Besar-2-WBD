function doAjax(url, method, data, successCallback,failCallback) {
    let req = new XMLHttpRequest();
    req.open(method, url, true);
    req.setRequestHeader("Content-Type", "application/json");
    req.onload = function(){
        console.log(this);
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

function fetchDataPost(url,postData, fun){
    let headers = {'Content-Type':'application/json'};
    console.log(JSON.stringify(postData));
    let fetchData = {
        method: 'POST',
        body: JSON.stringify(postData),
        headers: headers
    };

    fetch(url, fetchData)
    .then((resp)=> resp.json())
    .then(function(data){
        console.log('inidata', data)
        fun(data)
    })

    
    .catch(function(error){
        console.log(error)
    });
}
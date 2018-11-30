doOrder();
function doOrder() {
    let book_id = document.getElementById("book_id").value;
    let user_id = document.getElementById("user_id").value;

    let orderModal = document.getElementById("submit-order");
    let inputModal = document.getElementById("token-order");

    let orderBtn = document.getElementById("submit-button");
    let tokenBtn = document.getElementById("submit-token-button");
    let closeOrder = document.getElementsByClassName("close")[0];
    let closeInput = document.getElementsByClassName("close")[1];

    tokenBtn.onclick = function() {
        let ordered_count = document.getElementById("banyak-jumlah").value;

        var d = new Date();
        let current_date = d.getFullYear() + "-" + d.getMonth() + "-" + d.getDate() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
        let token = document.getElementById("token").value;

        let orderPayload = {
            "user_id": user_id,
            "book_id": book_id,
            "ordered_count": ordered_count,
            "date": current_date,
            "token": token,
        }

        doAjax('/api/order/', "POST", orderPayload, function(response){
            console.log(response);
            // if (response.data.order_status.status !== 0) {
            //     document.getElementById("checklist").src = "/static/img/wrong.png";
            //     document.getElementById("berhasil").innerHTML = "Transaksi gagal dilakukan";
            //     document.getElementById("no-transaksi").innerHTML = response.data.order_status.message;
            //     inputModal.style.display = "none";
            //     orderModal.style.display = "block";
            //     close.onclick = function(){
            //         orderModal.style.display = "none";
            //     }
            // } else {
            //     document.getElementById("no-transaksi").innerHTML = "No. Transaksi: " + response.data.order.order_book_id;
            //     inputModal.style.display = "none";
            //     orderModal.style.display = "block";
            //     close.onclick = function(){
            //         orderModal.style.display = "none";
            //     }
            // }            
        });
    }

    orderBtn.onclick = function(){
        doAjax('http://localhost:8000/token', "GET", null, function(response) {
            console.log(response.status);
            if (response.status == 0) {
                alert("Token Kamu: " + response.data.token);
                inputModal.style.display = "block";
                closeInput.onclick = function() {
                    inputModal.style.display = "none";
                }
            } else {
                alert(response.message);
            }
        })

        window.onclick = function(event){
            if (event.target == orderModal) {
                orderModal.style.display = "none";
            }
        }
    }
}


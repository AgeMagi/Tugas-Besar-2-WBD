doOrder();
function doOrder() {
    let book_id = document.getElementById("book_id").value;
    let user_id = document.getElementById("user_id").value;

    let orderModal = document.getElementById("submit-order");
    let orderBtn = document.getElementById("submit-button");
    let close = document.getElementsByClassName("close")[0];

    orderBtn.onclick = function(){
        let item_count = document.getElementById("banyak-jumlah").value;

        var d = new Date();
        let current_date = d.getFullYear() + "-" + d.getMonth() + "-" + d.getDate() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();

        let orderPayload = {
            "userid": user_id,
            "bookid": book_id,
            "itemcount": item_count,
            "date": current_date,
        }
        
        doAjax('/api/order/', "POST", orderPayload, function(response){
            document.getElementById("no-transaksi").innerHTML =response.data.order_book_id;
            orderModal.style.display = "block";
            close.onclick = function(){
                orderModal.style.display = "none";
            }
        });
        window.onclick = function(event){
            if (event.target == orderModal) {
                orderModal.style.display = "none";
            }
        }
    }
}


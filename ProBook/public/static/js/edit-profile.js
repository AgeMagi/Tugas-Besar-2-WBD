let nameInput = document.getElementById('edit_name');
let addressInput = document.getElementById('edit_address');
let phoneInput = document.getElementById('edit_phone');
let saveButton = document.getElementById('save_button');
let cardNumberInput = document.getElementById('edit_card_number');
let checkIcon = document.getElementById('card_number_check');

let isNameValid = false;
let isAddressValid = false;
let isPhoneValid = false;
let isCardValid = false;

const errorStyle = "1pt solid red";

function enableValidateName(){
    nameInput.addEventListener("focusout", function(){
        const nameValue = nameInput.value;
        if (nameValue.length>0 && nameValue.length<=20){
            nameInput.style.border = "";
            isNameValid = true;
        } else {
            nameInput.style.border = errorStyle;
            isNameValid = false;
        }
    });
}

function enableValidateAddress(){
    addressInput.addEventListener("focusout", function(){
        const addressValue = addressInput.value;
        if (addressValue.length>0){
            isAddressValid = true;
            addressInput.style.border = "";
        } else {
            isAddressValid = false;
            addressInput.style.border = errorStyle;
        }
    });
}

function enableValidatePhone(){
    phoneInput.addEventListener("focusout", function(){
        const phoneValue = phoneInput.value;
        if (phoneValue.length>=9 && phoneValue.length<=12){
            isPhoneValid = true;
            phoneInput.style.border = "";
        } else {
            isPhoneValid = false;
            phoneInput.style.border = errorStyle;
        }
    });
}

function enableValidateCardNumber(){
    cardNumberInput.addEventListener("focusout", function(){
        const cardNumberValue = cardNumberInput.value;
        if (cardNumberValue.length>0){
            
            cardNumberInput.style.border = "";
            
            let url= 'http://localhost:8000/validation';
            let postData = {"card_number":cardNumberValue};

            let fun = function(data){
                console.log(data);
            
                if (data['card_number']!=0){
                    checkIcon.innerHTML= '✓';
                    console.log(postData);
                    isCardNumberValid = true;
                }else{
                    checkIcon.innerHTML= '✗';
                }
            };
            fetchDataPost(url,postData,fun);    

            
        } else {
            isCardNumberValid = false;
            cardNumberInput.style.border = errorStyle;
        }
    });
}

function enableValidateUsername(){
    username.addEventListener("focusout", function(){
        const usernameValue = username.value;
        const validateUsernameURL = '/api/user/validateUsername/?username='+username.value;
        doAjax(validateUsernameURL, "GET", null, function(response){
            console.log(response);
            if ((usernameValue.length<=20 && usernameValue.length>0) && !response.data){
                isUsernameValid = true;
                username.style.border = "";
                usernameCheck.style.display = "inline";
            }else {
                isUsernameValid = false;
                username.style.border = errorStyle;
                usernameCheck.style.display = "none";
            }
        })
    });
}

function validateForm(){
    enableValidateName();
    enableValidateAddress();
    enableValidatePhone();
    enableValidateCardNumber()
}

window.onload = function(){
    validateForm();
    saveButton.addEventListener('click', function(e) {
        if (nameInput.value === '' || addressInput.value=== '' || phoneInput.value === ''||cardNumberInput.value == '') {
            e.preventDefault();
            alert("Data cannot be empty!")
        }
    })
}



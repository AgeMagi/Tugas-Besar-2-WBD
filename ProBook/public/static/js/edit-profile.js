let nameInput = document.getElementById('edit_name');
let addressInput = document.getElementById('edit_address');
let phoneInput = document.getElementById('edit_phone');
let saveButton = document.getElementById('save_button');

let isNameValid = false;
let isAddressValid = false;
let isPhoneValid = false;

const errorStyle = "1pt solid red";

function enableValidateName(){
    nameInput.addEventListener("focusout", function(){
        const nameValue = nameInput.value;
        if (nameValue.length>0){
            nameInput.style.border = "";
            isNameValid = true;
        } else {
            name.style.border = errorStyle;
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

function validateForm(){
    enableValidateName();
    enableValidateAddress();
    enableValidatePhone();
}

window.onload = function(){
    validateForm();
    saveButton.addEventListener('click', function(e) {
        if (nameInput.value === '' || address.value=== '' || phoneInput.value === '') {
            e.preventDefault();
            alert("Data cannot be empty!")
        }
    })
}



const name = document.getElementById('name_form');
const username = document.getElementById('username_form');
const usernameCheck = document.getElementById('username_check');
const email = document.getElementById('email_form');
const emailCheck = document.getElementById('email_check');
const password = document.getElementById('password_form');
const confirmPassword = document.getElementById('confirm_password_form');
const address = document.getElementById('address_form');
const phone = document.getElementById('phone_form');
const cardNumber = document.getElementById('card_form');
let checkIcon = document.getElementById('card_check');

let isNameValid = false;
let isEmailValid = false;
let isUsernameValid = false;
let isPasswordValid = false;
let isConfirmPasswordValid = false;
let isAddressValid = false;
let isPhoneValid = false;
let isCardValid = false;

const errorStyle = "1pt solid red";

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

function enableValidateEmail(){
    const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    email.addEventListener("focusout", function(){
        const emailValue = email.value;
        const validateEmailURL = '/api/user/validateEmail/?email='+email.value;
        doAjax(validateEmailURL, "GET", null, function(response){
            if (emailValue.length>0 && !response.data && emailRegex.test(email.value) ){
                isEmailValid = true;
                email.style.border = "";
                emailCheck.style.display = "inline";
            }else {
                isEmailValid = false;
                email.style.border = errorStyle;
                emailCheck.style.display = "none";
            }
        })
    });
}
function enableValidateName(){
    name.addEventListener("focusout", function(){
        const nameValue = name.value;
        if (nameValue.length>0){
            name.style.border = "";
            isNameValid = true;
        } else {
            name.style.border = errorStyle;
            isNameValid = false;
        }
    });
}

function enableValidatePassword(){
    password.addEventListener("focusout", function(){
        const passwordValue = password.value;
        if (passwordValue.length>0){
            password.style.border = "";
            isPasswordValid = true;
        } else {
            password.style.border = errorStyle;
            isPasswordValid = false;
        }
    });
}

function enableValidateConfirmPassword(){
    confirmPassword.addEventListener("focusout", function(){
        const confirmPasswordValue = confirmPassword.value;
        if (confirmPasswordValue.length>0 && confirmPasswordValue == password.value){
            isConfirmPasswordValid = true;
            confirmPassword.style.border = "";
        } else {
            isConfirmPasswordValid = false;
            confirmPassword.style.border = errorStyle;
        }
    });
}

function enableValidateAddress(){
    address.addEventListener("focusout", function(){
        const addressValue = address.value;
        if (addressValue.length>0){
            isAddressValid = true;
            address.style.border = "";
        } else {
            isAddressValid = false;
            address.style.border = errorStyle;
        }
    });
}

function enableValidatePhone(){
    phone.addEventListener("focusout", function(){
        const phoneValue = phone.value;
        if (phoneValue.length>=9 && phoneValue.length<=12){
            isPhoneValid = true;
            phone.style.border = "";
        } else {
            isPhoneValid = false;
            phone.style.border = errorStyle;
        }
    });
}
 
function enableValidateCardNumber(){

    cardNumber.addEventListener("focusout", function(){
        const cardNumberValue = cardNumber.value;
        if (cardNumberValue.length>0){   
            cardNumber.style.border = "";
            
            let url= 'http://localhost:8000/validation';
            let postData = {"card_number":cardNumberValue};

            let fun = function(data){
                console.log(data);
                if (data['card_number']!=0){
                    checkIcon.innerHTML= '✓';
                    isCardValid = true;
                    cardNumber.style.border = "";
                    checkIcon.style.display = "inline";
                }else{
                    checkIcon.innerHTML= '✗';
                    isCardValid = false;
                    cardNumber.style.border = errorStyle;
                    checkIcon.style.display = "none";
                    checkIcon.style.display = "inline";
                }
            };
            fetchDataPost(url,postData,fun);    

            
        } else {
            isCardNumberValid = false;
            cardNumber.style.border = errorStyle;
        }
    });
}

function validateForm(){
    enableValidateName();
    enableValidateUsername();
    enableValidateEmail();
    enableValidatePassword();
    enableValidateConfirmPassword();
    enableValidateAddress();
    enableValidatePhone();
    enableValidateCardNumber();
}

const doRegister = function(e){

    console.log(isNameValid);
    if (!(isNameValid && isEmailValid && isPasswordValid && isUsernameValid && isConfirmPasswordValid && isAddressValid && isPhoneValid && isCardValid)){
        e.preventDefault();
        alert("Please fill in the form with the correct details!");
    }
};

window.onload = function(){
    validateForm();
    let registerButton = document.getElementById("register_button");
    registerButton.onclick = doRegister;
}
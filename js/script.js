const passwordInput = document.getElementById('password');
const passwordInfo = document.getElementById('password-info');

passwordInput.addEventListener('mouseover', () => {
    passwordInfo.style.display = 'block';
});

passwordInput.addEventListener('mouseout', () => {
    passwordInfo.style.display = 'none';
});



const password1 = document.querySelector(".password")
const password2 = document.querySelector(".passwordControl")
const control = document.querySelector(".error_password_text")
const submitButton = document.getElementById("submit")
const submitButton_wrong = document.getElementById("submit_wrong")
password1.addEventListener("input", () => {
    const password1Value = password1.value
    const password2Value = password2.value
    if (password1Value !== "") {
        if (password1Value === password2Value) {
            control.textContent = "Hesla se shodují"
            control.classList.remove("invalid")
            control.classList.add("valid")
            submitButton.style.display = 'inline-block';
            submitButton_wrong.style.display = "none";
        } else {
            control.textContent = "Zadaná hesla se neshodují"
            control.classList.remove("valid")
            control.classList.add("invalid")
            submitButton.style.display = 'none';
            submitButton_wrong.style.display = "inline-block";
        }
    }
    if (password1Value === "" || password2Value === "") {
        control.textContent = ""
    }

})
password2.addEventListener("input", () => {
    const password1Value = password1.value
    const password2Value = password2.value
    if (password1Value !== "") {
        if (password1Value === password2Value) {
            control.textContent = "Hesla se shodují"
            control.classList.remove("invalid")
            control.classList.add("valid")
            submitButton.style.display = 'inline-block';
            submitButton_wrong.style.display = "none"
        } else {
            control.textContent = "Zadaná hesla se neshodují"
            control.classList.remove("valid")
            control.classList.add("invalid")
            submitButton.style.display = 'none';
            submitButton_wrong.style.display = "inline-block";
        }

    }
    if (password1Value === "" || password2Value === "") {
        control.textContent = ""
    }
})


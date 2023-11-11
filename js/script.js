const password1 = document.querySelector(".password")
const password2 = document.querySelector(".passwordControl")
const control = document.querySelector(".error_password_text")

password1.addEventListener("input", () => {
    const password1Value = password1.value
    const password2Value = password2.value
    if (password1Value !== "") {
        if (password1Value === password2Value) {
            control.textContent = "Hesla se shodují"
            control.classList.remove("invalid")
            control.classList.add("valid")
        } else {
            control.textContent = "Zadaná hesla se neshodují"
            control.classList.remove("valid")
            control.classList.add("invalid")
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
        } else {
            control.textContent = "Zadaná hesla se neshodují"
            control.classList.remove("valid")
            control.classList.add("invalid")
        }

    }
    if (password1Value === "" || password2Value === "") {
        control.textContent = ""
    }
})



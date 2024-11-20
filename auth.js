const loginText = document.querySelector(".title-text .login");
const loginForm = document.querySelector("form.login");
const signupForm = document.querySelector("form.signup");
const loginBtn = document.querySelector("label.login");
const signupBtn = document.querySelector("label.signup");
const signupLink = document.querySelector("form .signup-link a");

signupBtn.onclick = () => {
    document.querySelector(".form-inner").style.marginLeft = "-100%";
    loginText.style.marginLeft = "-100%";
};

loginBtn.onclick = () => {
    document.querySelector(".form-inner").style.marginLeft = "0%";
    loginText.style.marginLeft = "0%";
};

signupLink.onclick = (e) => {
    e.preventDefault();
    signupBtn.click();
};

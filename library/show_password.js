let showPasswords = document.getElementById("showPassword");

function showPassword() {
    let password = document.getElementById("clientPassword");

    if (password.type === "password") {
      password.type = "text";
      showPasswords.innerHTML = "Hide Password";
    } else {
      password.type = "password";
      showPasswords.innerHTML = "Show Password";
    }
  }

showPasswords.addEventListener("click", () => showPassword())
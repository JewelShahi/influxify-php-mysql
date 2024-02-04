const togglePassword = () => {
  const passwordInput = document.getElementById("passwordInput");
  const toggleButton = document.getElementById("toggle");

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    toggleButton.className = "toggle-pass fas fa-eye-slash";
  } else {
    passwordInput.type = "password";
    toggleButton.className = "toggle-pass fas fa-eye";
  }
};

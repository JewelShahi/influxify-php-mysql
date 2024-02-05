const togglePassword = (toggleButton) => {
  // Find the associated password input
  const passwordInput = toggleButton.previousElementSibling;

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    toggleButton.classList.remove("fa-eye");
    toggleButton.classList.add("fa-eye-slash");
  } else {
    passwordInput.type = "password";
    toggleButton.classList.remove("fa-eye-slash");
    toggleButton.classList.add("fa-eye");
  }
};
const handleFileInputChange = (event) => {
  const filenameSpan = event.target.nextElementSibling; // Get the next sibling span element
  if (event.target.files && event.target.files[0]) {
    filenameSpan.textContent = event.target.files[0].name;
  } else {
    filenameSpan.textContent = "";
  }
};

// Get all file input elements with class name 'file-input'
const fileInputs = document.querySelectorAll(".file-input");

// Attach event listener to each file input element
fileInputs.forEach((input) => {
  input.addEventListener("change", handleFileInputChange);
});

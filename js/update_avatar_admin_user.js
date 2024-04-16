// Define the function to handle radio button click
const handleRadioButtonClick = (option) => {
  console.log("Selected option:", option);
};

// Define behavior for the radio button when clicked and hover
document.addEventListener("DOMContentLoaded", () => {
  const avatarInputs = document.querySelectorAll(
    ".avatar-form .image-container .input-hidden"
  );
  const avatarContainers = document.querySelectorAll(
    ".avatar-form .image-container label"
  );
  const updateAvatarButton = document.querySelector(
    '.avatar-form button[name="update_avatar"]'
  );

  // Function to update brightness
  const updateBrightness = (index) => {
    avatarContainers.forEach((container, idx) => {
      const avatarContainer = container.querySelector(".avatar-container");
      if (idx === index) {
        avatarContainer.style.filter = "brightness(45%)";
      } else {
        avatarContainer.style.filter = "brightness(100%)";
      }
    });
  };

  // Add event listeners to radio buttons
  avatarInputs.forEach((input, index) => {
    input.addEventListener("change", () => {
      updateBrightness(index);

      // Check if any radio button is checked
      const checkedRadio = document.querySelector(
        ".avatar-form .image-container .input-hidden:checked"
      );
      if (!checkedRadio) {
        updateAvatarButton.disabled = true;
        updateAvatarButton.classList.add("disabled");
      } else {
        updateAvatarButton.disabled = false;
        updateAvatarButton.classList.remove("disabled");
      }
    });
  });

  // Add event listeners to handle hover
  avatarContainers.forEach((container, index) => {
    container.addEventListener("mouseenter", () => {
      container.querySelector(".avatar-container").style.filter =
        "brightness(65%)";
    });

    container.addEventListener("mouseleave", () => {
      // If no radio button is checked, reset brightness to 100%
      const checkedIndex = Array.from(avatarInputs).findIndex(
        (input) => input.checked
      );
      if (checkedIndex === -1) {
        updateBrightness(-1);
      } else {
        updateBrightness(checkedIndex);
      }
    });
  });

  // Disable the button initially if no radio button is selected
  if (
    !document.querySelector(
      ".avatar-form .image-container .input-hidden:checked"
    )
  ) {
    updateAvatarButton.disabled = true;
    updateAvatarButton.classList.add("disabled");
  } else {
    updateAvatarButton.disabled = false;
    updateAvatarButton.classList.remove("disabled");
  }
});

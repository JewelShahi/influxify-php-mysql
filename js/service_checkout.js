// Function to toggle address fields based on delivery option
const toggleAddressFields = () => {
  const deliveryOption = document.getElementById("deliveryOption");
  const addressFields = document.getElementById("addressFields");
  const addressInputs = addressFields.querySelectorAll("input, select");

  if (deliveryOption.value === "yes") {
    addressFields.style.display = "block";
    // Update total price with delivery cost
    updateTotalPrice(true);
    // Make address fields required
    addressInputs.forEach((input) => (input.required = true));
  } else {
    addressFields.style.display = "none";
    // Update total price without delivery cost
    updateTotalPrice(false);
    // Remove required attribute from address fields
    addressInputs.forEach((input) => (input.required = false));
  }
};

// Function to update total price based on delivery option
const updateTotalPrice = (hasDelivery) => {
  const grandTotalSpan = document.querySelector(".grand-total span");
  // Retrieve the price from the form
  const priceInput = document.querySelector('input[name="price"]');
  const servicePrice = parseFloat(priceInput.value);
  const deliveryCost = 9.99;

  const totalPrice = hasDelivery ? servicePrice + deliveryCost : servicePrice;
  grandTotalSpan.textContent = "$" + totalPrice.toFixed(2);
};

// Call the function on page load to set the initial state
window.onload = toggleAddressFields;

// Attach the function to the change event of the delivery option select
const deliveryOption = document.getElementById("deliveryOption");
deliveryOption.addEventListener("change", toggleAddressFields);

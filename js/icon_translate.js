/**********************
 * Hover over button icon animation
 */
let shopBtn = document.getElementById("shop-now-btn");

shopBtn.addEventListener("mouseover", () => {
  let iconElement = shopBtn.querySelector("i");
  iconElement.style.transform = "translateX(15px)";
});

shopBtn.addEventListener("mouseout", () => {
  let iconElement = shopBtn.querySelector("i");
  iconElement.style.transform = "translateX(0)";
});
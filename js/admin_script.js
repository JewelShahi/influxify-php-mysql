let navbar = document.querySelector(".header .flex .navbar");
let profile = document.querySelector(".header .flex .profile");

document.querySelector("#menu-btn-admin").onclick = () => {
  navbar.classList.toggle("active");
  profile.classList.remove("active");
};

document.querySelector("#admin-btn").onclick = () => {
  profile.classList.toggle("active");
  navbar.classList.remove("active");
};

let mainImage = document.querySelector(
  ".update-product .image-container .main-image img"
);
let subImages = document.querySelectorAll(
  ".update-product .image-container .sub-image img"
);

subImages.forEach((images) => {
  images.onclick = () => {
    src = images.getAttribute("src");
    mainImage.src = src;
  };
});

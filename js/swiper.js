/****** Swiper Display product *******/
let homeSwiper = new Swiper(".home-slider", {
  loop: true,
  effect: "slide",
  speed: 400,
  spaceBetween: 20,
  autoplay: {
    delay: 5000,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  keyboard: {
    enabled: true,
    onlyInViewport: false,
  },
});

const nextBtn = document.querySelector(".swiper-button-next");
nextBtn.style.color = "white";
nextBtn.style.fontWeight = "bold";

nextBtn.addEventListener("mouseover", () => {
  nextBtn.style.color = "rgba(256, 256, 256, 0.6)";
});

nextBtn.addEventListener("mouseout", () => {
  nextBtn.style.color = "white";
});

const prevBtn = document.querySelector(".swiper-button-prev");
prevBtn.style.color = "white";
prevBtn.style.fontWeight = "bold";

prevBtn.addEventListener("mouseover", () => {
  prevBtn.style.color = "rgba(256, 256, 256, 0.6)";
});

prevBtn.addEventListener("mouseout", () => {
  prevBtn.style.color = "white";
});
/************************************/

/****** Brand Swiper *******/
let brandSwiper = new Swiper(".brand-slider", {
  loop: true,
  spaceBetween: 20,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    0: {
      slidesPerView: 2,
    },
    650: {
      slidesPerView: 3,
    },
    768: {
      slidesPerView: 4,
    },
  },
});

const nextBtnBrand = document.getElementById("brand-next");
nextBtnBrand.style.color = "white";
nextBtnBrand.style.fontWeight = "bold";

nextBtnBrand.addEventListener("mouseover", () => {
  nextBtnBrand.style.color = "rgba(256, 256, 256, 0.6)";
});

nextBtnBrand.addEventListener("mouseout", () => {
  nextBtnBrand.style.color = "white";
});

const prevBtnBrand = document.getElementById("brand-prev");
prevBtnBrand.style.color = "white";
prevBtnBrand.style.fontWeight = "bold";

prevBtnBrand.addEventListener("mouseover", () => {
  prevBtnBrand.style.color = "rgba(256, 256, 256, 0.6)";
});

prevBtnBrand.addEventListener("mouseout", () => {
  prevBtnBrand.style.color = "white";
});

/************ Product Swiper *****************/
let productsSwiper = new Swiper(".products-slider", {
  loop: true,
  spaceBetween: 20,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    550: {
      slidesPerView: 2,
    },
    768: {
      slidesPerView: 2,
    },
    1024: {
      slidesPerView: 3,
    },
  },
});
/************************************/

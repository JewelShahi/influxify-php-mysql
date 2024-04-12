/****** Swiper Display product *******/
let homeSwiper = new Swiper(".home-slider", {
  loop: false, // Enable infinite loop
  effect: "slide", // Slide effect
  speed: 600, // Slide animation speed
  spaceBetween: 500, // Space between slides (optional)
  autoplay: {
    delay: 5000, // Autoplay delay (optional)
  },
  pagination: {
    el: ".swiper-pagination", // Pagination element selector (optional)
    clickable: true, // Enable pagination clicking (optional)
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  keyboard: {
    enabled: true, // Keyboard navigation enabled
    onlyInViewport: false, // Allow keyboard navigation outside viewport
  },
  // Ensure smooth looping with any number of slides
  loopAdditionalSlides: 1, // Add one extra blank slide
});

// Style and hover effects for navigation buttons (optional)
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
  loop: false, // Enable infinite loop
  effect: "slide", // Slide effect
  speed: 600, // Slide animation speed
  spaceBetween: 20, // Space between slides (optional)
  pagination: {
    el: ".swiper-pagination", // Pagination element selector (optional)
    clickable: true, // Enable pagination clicking (optional)
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  keyboard: {
    enabled: true, // Keyboard navigation enabled
    onlyInViewport: false, // Allow keyboard navigation outside viewport
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    450: {
      slidesPerView: 2,
    },
    700: {
      slidesPerView: 3,
    },
    950: {
      slidesPerView: 4,
    },
    1024: {
      slidesPerView: 5,
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
const productsSwiper = new Swiper(".products-slider", {
  loop: false,
  spaceBetween: 20,
  autoplay: {
    delay: 3000, // Autoplay delay (optional)
  },
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

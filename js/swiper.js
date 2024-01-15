/****** Swiper Display product *******/
let homeSwiper = new Swiper(".home-slider", {
  loop: true,
  effect: "slide",
  speed: 400,
  spaceBetween: 20,
  autoplay: {
    delay: 7000,
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
let categorySwiper = new Swiper(".category-slider", {
  loop: true,
  spaceBetween: 20,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
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
    1024: {
      slidesPerView: 5,
    },
  },
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

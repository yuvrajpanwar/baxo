(function () {
  "use strict";
  window.addEventListener("load", function () {
    document.querySelector("body").classList.add("loaded");
  });
  document.addEventListener("DOMContentLoaded", function (event) {
    var modal = document.getElementById("newsletter-popup");
    setTimeout(function () {
      var modalInstance = new bootstrap.Modal(modal, {});
      modalInstance.show();
    }, 5000);
  });
  window.onload = function () {
    const getHeaderId = document.getElementById("navbar");
    if (getHeaderId) {
      window.addEventListener("scroll", (event) => {
        const height = 150;
        const { scrollTop } = event.target.scrollingElement;
        document
          .querySelector("#navbar")
          .classList.toggle("sticky", scrollTop >= height);
      });
    }
    const getId = document.getElementById("backtotop");
    if (getId) {
      const topbutton = document.getElementById("backtotop");
      topbutton.onclick = function (e) {
        window.scrollTo({ top: 0, behavior: "smooth" });
      };
      window.onscroll = function () {
        if (
          document.body.scrollTop > 200 ||
          document.documentElement.scrollTop > 200
        ) {
          topbutton.style.opacity = "1";
        } else {
          topbutton.style.opacity = "0";
        }
      };
    }
  };
  var mySwiper = new Swiper(".hero-slider", {
    spaceBetween: 25,
    grabCursor: true,
    loop: false,
    autoHeight: true,
    speed: 1200,
    navigation: { nextEl: ".hero-next", prevEl: ".hero-prev" },
    breakpoints: {
      0: { slidesPerView: 1 },
      768: { slidesPerView: 1.3 },
      992: { slidesPerView: 1.5 },
      1200: { slidesPerView: 1.6 },
      1400: { slidesPerView: 1.7, spaceBetween: 35 },
      1600: { slidesPerView: 2.15, spaceBetween: 52 },
    },
  });
  var mySwiper = new Swiper(".trending-news-slider", {
    spaceBetween: 25,
    grabCursor: true,
    loop: true,
    autoHeight: true,
    speed: 1200,
    navigation: { nextEl: ".trending-next", prevEl: ".trending-prev" },
    breakpoints: {
      0: { slidesPerView: 1 },
      768: { slidesPerView: 1 },
      992: { slidesPerView: 1.9 },
      1200: { slidesPerView: 2.2 },
      1400: { slidesPerView: 2.5 },
      1600: { slidesPerView: 3 },
    },
  });
  var mySwiper = new Swiper(".trending-slider-two", {
    spaceBetween: 25,
    grabCursor: true,
    loop: true,
    autoHeight: true,
    speed: 1200,
    slidesPerView: 1,
    navigation: { nextEl: ".trending-btn-next", prevEl: ".trending-btn-prev" },
  });
  var mySwiper = new Swiper(".popular-news-slider", {
    spaceBetween: 25,
    grabCursor: true,
    loop: true,
    autoHeight: true,
    speed: 1200,
    autoplay: { delay: 2000, disableOnInteraction: false },
    breakpoints: {
      0: { slidesPerView: 1 },
      768: { slidesPerView: 2 },
      992: { slidesPerView: 2 },
      1200: { slidesPerView: 3 },
    },
  });
  var swiper = new Swiper(".instagram-slider", {
    spaceBetween: 10,
    grabCursor: true,
    loop: true,
    speed: 1400,
    autoplay: { delay: 2000, disableOnInteraction: false },
    breakpoints: {
      0: { slidesPerView: 1 },
      768: { slidesPerView: 2 },
      992: { slidesPerView: 3 },
      1200: { slidesPerView: 4 },
      1400: { slidesPerView: 5 },
    },
  });
  var swiper = new Swiper(".instagram-slider-two", {
    spaceBetween: 10,
    grabCursor: true,
    loop: true,
    speed: 1400,
    navigation: { nextEl: ".instagram-next", prevEl: ".instagram-prev" },
    breakpoints: {
      0: { slidesPerView: 1 },
      768: { slidesPerView: 2 },
      992: { slidesPerView: 3 },
      1200: { slidesPerView: 3.9 },
      1400: { slidesPerView: 4.6 },
    },
  });
  var swiper = new Swiper(".featured-slider", {
    spaceBetween: 15,
    grabCursor: true,
    slidesPerView: 1,
    loop: true,
    speed: 1400,
    autoHeight: true,
    navigation: { nextEl: ".featured-next", prevEl: ".featured-prev" },
  });
  var swiper = new Swiper(".video-slider", {
    spaceBetween: 25,
    grabCursor: true,
    slidesPerView: 1,
    loop: true,
    speed: 1400,
    autoHeight: true,
    navigation: { nextEl: ".video-next", prevEl: ".video-prev" },
    breakpoints: {
      0: { slidesPerView: 1 },
      992: { slidesPerView: 2 },
      1200: { slidesPerView: 3 },
    },
  });
  AOS.init({ startEvent: "load" });
  var resultEl = document.querySelector(".resultSet"),
    plusMinusWidgets = document.querySelectorAll(".v-counter");
  for (var i = 0; i < plusMinusWidgets.length; i++) {
    plusMinusWidgets[i]
      .querySelector(".minusBtn")
      .addEventListener("click", clickHandler);
    plusMinusWidgets[i]
      .querySelector(".plusBtn")
      .addEventListener("click", clickHandler);
  }
  function clickHandler(event) {
    var countEl = event.target.parentNode.querySelector(".count");
    if (event.target.className.match(/\bminusBtn\b/)) {
      countEl.value = Number(countEl.value) - 1;
    } else if (event.target.className.match(/\bplusBtn\b/)) {
      countEl.value = Number(countEl.value) + 1;
    }
    triggerEvent(countEl, "change");
  }
  function triggerEvent(el, type) {
    if ("createEvent" in document) {
      var e = document.createEvent("HTMLEvents");
      e.initEvent(type, false, true);
      el.dispatchEvent(e);
    } else {
      var e = document.createEventObject();
      e.eventType = type;
      el.fireEvent("on" + e.eventType, e);
    }
  }
  function triggerEvent(el, type) {
    if ("createEvent" in document) {
      var e = document.createEvent("HTMLEvents");
      e.initEvent(type, false, true);
      el.dispatchEvent(e);
    } else {
      var e = document.createEventObject();
      e.eventType = type;
      el.fireEvent("on" + e.eventType, e);
    }
  }
  (() => {
    const ROOT_CLASS = "scrollscreen";
    const createElement = (tag, name) => {
      const el = document.createElement(tag);
      el.className = `${ROOT_CLASS}--${name}`;
      return el;
    };
    const createScrollscreen = (root) => {
      const fragment = document.createDocumentFragment();
      [...root.childNodes].forEach((child) => {
        fragment.appendChild(child);
      });
      const content = createElement("div", "content");
      content.appendChild(fragment);
      root.appendChild(content);
      const track = createElement("div", "track");
      root.appendChild(track);
      const slider = createElement("div", "slider");
      track.appendChild(slider);
      let pendingFrame = null;
      const redraw = () => {
        cancelAnimationFrame(pendingFrame);
        pendingFrame = requestAnimationFrame(() => {
          const contentHeight = content.scrollHeight;
          const containerHeight = root.offsetHeight;
          const percentageVisible = containerHeight / contentHeight;
          const sliderHeight = percentageVisible * containerHeight;
          const percentageOffset =
            content.scrollTop / (contentHeight - containerHeight);
          const sliderOffset =
            percentageOffset * (containerHeight - sliderHeight);
          track.style.opacity = percentageVisible === 1 ? 0 : 1;
          slider.style.cssText = `
                        height: ${sliderHeight}px;
                        transform: translateY(${sliderOffset}px);
                    `;
        });
      };
      content.addEventListener("scroll", redraw);
      window.addEventListener("resize", redraw);
      redraw();
      const wakey = () => {
        requestAnimationFrame(() => {
          const offset = content.scrollTop;
          content.scrollTop = offset + 1;
          content.scrollTop = offset;
        });
      };
      root.addEventListener("mouseenter", wakey);
      wakey();
    };
    [...document.querySelectorAll(`.${ROOT_CLASS}`)].forEach(
      createScrollscreen
    );
  })();
})();
try {
  function setTheme(themeName) {
    localStorage.setItem("baxo_theme", themeName);
    document.documentElement.className = themeName;
  }
  function toggleTheme() {
    if (localStorage.getItem("baxo_theme") === "theme-dark") {
      setTheme("theme-light");
    } else {
      setTheme("theme-dark");
    }
  }
  (function () {
    if (localStorage.getItem("baxo_theme") === "theme-dark") {
      setTheme("theme-dark");
      document.getElementById("slider").checked = false;
    } else {
      setTheme("theme-light");
      document.getElementById("slider").checked = true;
    }
  })();
} catch (err) {}

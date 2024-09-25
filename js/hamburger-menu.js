document.addEventListener("DOMContentLoaded", function () {
  const hamburger = document.getElementById("hamburger");
  const navLinks = document.getElementById("nav-links");
  const navButtons = document.querySelector(".nav-buttons");

  hamburger.addEventListener("click", function () {
    hamburger.classList.toggle("active");
    navLinks.classList.toggle("active");
    navButtons.classList.toggle("active");
  });
});

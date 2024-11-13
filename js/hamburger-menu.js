document.addEventListener("DOMContentLoaded", function () {
  const hamburger = document.getElementById("hamburger");
  const navLinks = document.getElementById("nav-links");
  const navButtons = document.querySelector(".nav-buttons");
  const profileButton = document.querySelector(".profile-button");
  const profileDropdown = document.getElementById("profile-dropdown");

  hamburger.addEventListener("click", function () {
    hamburger.classList.toggle("active");
    navLinks.classList.toggle("active");
    navButtons.classList.toggle("active");
  });

  if (profileButton) {
    profileButton.addEventListener("click", function (event) {
      event.stopPropagation();
      profileDropdown.style.display = profileDropdown.style.display === "block" ? "none" : "block";
    });
  }

  window.addEventListener("click", function (event) {
    if (!event.target.closest('.user-info')) {
      profileDropdown.style.display = "none";
    }
  });
});

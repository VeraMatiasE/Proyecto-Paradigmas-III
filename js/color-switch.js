// Obtener el botón y el tema actual
const themeSwitcher = document.getElementById("theme-switcher");
let currentTheme =
  localStorage.getItem("theme") ||
  (window.matchMedia("(prefers-color-scheme: dark)").matches
    ? "dark"
    : "light");

document.documentElement.setAttribute("data-theme", currentTheme);

themeSwitcher.addEventListener("click", () => {
  const newTheme = currentTheme === "dark" ? "light" : "dark";
  document.documentElement.setAttribute("data-theme", newTheme);
  localStorage.setItem("theme", newTheme);
  currentTheme = newTheme;
});

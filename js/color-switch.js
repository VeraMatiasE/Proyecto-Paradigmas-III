// Obtener el botón y el tema actual
const themeSwitcher = document.getElementById("theme-switcher");
const currentTheme =
  localStorage.getItem("theme") ||
  (window.matchMedia("(prefers-color-scheme: dark)").matches
    ? "dark"
    : "light");

document.documentElement.setAttribute("data-theme", currentTheme);

themeSwitcher.addEventListener("click", () => {
  const currentTheme = localStorage.getItem("theme");
  const newTheme = currentTheme === "dark" ? "light" : "dark";
  document.documentElement.setAttribute("data-theme", newTheme);
  localStorage.setItem("theme", newTheme);
});

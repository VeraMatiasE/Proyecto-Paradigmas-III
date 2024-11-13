function showTab(tabId) {
  document
    .querySelectorAll(".tab-content")
    .forEach((tab) => tab.classList.remove("active-tab"));
  document
    .querySelectorAll(".tab")
    .forEach((tab) => tab.classList.remove("active"));

  document.getElementById(tabId).classList.add("active-tab");
  document
    .querySelector(`.tab[onclick="showTab('${tabId}')"]`)
    .classList.add("active");
}

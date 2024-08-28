document.addEventListener("DOMContentLoaded", function () {
  const toggleReplyButtons = document.querySelectorAll(".toggle-reply");

  /* Script para el texto de respuestas */
  toggleReplyButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const responseContent = this.parentElement.nextElementSibling;
      const replyForm = responseContent.nextElementSibling;
      const subResponses = replyForm.nextElementSibling;

      replyForm.classList.toggle("hidden");
      subResponses.classList.toggle("hidden");

      this.textContent = this.textContent === "Ocultar" ? "Mostrar" : "Ocultar";
    });
  });

  /* Script para ocultar/mostrar los comentarios y las respuestas */
  document.querySelectorAll(".toggle-comments").forEach((toggle_button) => {
    toggle_button.addEventListener("click", toggleShowElement);
  });
});

function toggleShowElement(event) {
  this.parentElement.parentElement
    .querySelectorAll(
      ".toggle-reply,.response-content,.sub-responses,.form-reply"
    )
    .forEach((element) => {
      console.log(element.classList.contains("hidden"));
      if (element.classList.contains("hidden")) {
        element.classList.remove("hidden");
      } else {
        element.classList.add("hidden");
      }
    });
}

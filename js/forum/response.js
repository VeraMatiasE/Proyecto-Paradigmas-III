const formResponse = document.createElement("form");
formResponse.action = "#";
formResponse.classList.add("form-reply");
formResponse.id = "Form-Response"
const textareaResponse = document.createElement("textarea");
textareaResponse.placeholder = "Escribe tu respuesta acá...";
const buttonResponse = document.createElement("button");
buttonResponse.classList.add("submit-reply");
buttonResponse.innerText = "Enviar Respuesta";
formResponse.appendChild(textareaResponse);
formResponse.appendChild(buttonResponse);

let currentReply = null;

document.addEventListener("DOMContentLoaded", function () {
  const toggleReplyButtons = document.querySelectorAll(".toggle-reply");

  /* Script para el texto de respuestas */
  toggleReplyButtons.forEach((button) => {
  document.querySelectorAll(".toggle-reply").forEach((button) => {
    button.addEventListener("click", function () {
      if(currentReply != null) {
        currentReply.classList.remove("hidden");
      }
      textareaResponse.value = null;
      this.classList.add("hidden");
      this.parentElement.insertBefore(formResponse, this);
      currentReply = this;
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

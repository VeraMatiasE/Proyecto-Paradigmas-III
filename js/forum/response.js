import { submitComment, getSlugPost } from "./api.js";
import { renderNewComment } from "./comment_renderer.js";

const formResponseTemplate = createResponseForm();
let currentForm = null;
let currentToggleButton = null;

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".toggle-reply").forEach((button) => {
    button.addEventListener("click", handleNewComment);
  });

  document.querySelectorAll(".toggle-comments").forEach((toggle_button) => {
    toggle_button.addEventListener("click", toggleShowElement);
  });
});

export function handleNewComment() {
  const responseContainer = this.closest(".response");
  const commentId = responseContainer.getAttribute("data-id");

  const formResponse = formResponseTemplate.cloneNode(true);
  formResponse.dataset.commentId = commentId;

  const subResponsesContainer =
    responseContainer.querySelector(".sub-responses");

  if (currentForm && currentForm !== formResponse) {
    currentForm.classList.add("hidden");
    currentToggleButton.classList.remove("hidden");
  }

  if (subResponsesContainer) {
    responseContainer.insertBefore(formResponse, subResponsesContainer);
  } else {
    responseContainer.appendChild(formResponse);
  }

  formResponse.classList.remove("hidden");
  currentForm = formResponse;
  currentToggleButton = this;

  this.classList.add("hidden");

  formResponse.addEventListener("submit", async (event) => {
    event.preventDefault();
    const responseText = formResponse.querySelector("textarea").value;

    try {
      const newCommentData = await submitComment(responseText, commentId);
      currentForm.classList.add("hidden");
      currentToggleButton.classList.remove("hidden");
      if (!subResponsesContainer) {
        const newSubResponsesContainer = document.createElement("div");
        newSubResponsesContainer.classList.add("sub-responses");
        responseContainer.appendChild(newSubResponsesContainer);
        renderNewComment(newCommentData, newSubResponsesContainer);
      } else {
        renderNewComment(newCommentData, subResponsesContainer);
      }
      formResponse.querySelector("textarea").value = "";
    } catch (error) {
      console.error("Error al enviar el comentario:", error);
    }
  });
}

function createResponseForm() {
  const form = document.createElement("form");
  form.action = "#";
  form.classList.add("form-reply");

  const textarea = document.createElement("textarea");
  textarea.placeholder = "Escribí tu respuesta acá...";
  form.appendChild(textarea);

  const button = document.createElement("button");
  button.classList.add("submit-reply");
  button.innerText = "Enviar Respuesta";
  button.type = "submit";
  form.appendChild(button);

  return form;
}

function toggleShowElement(event) {
  this.parentElement.parentElement
    .querySelectorAll(
      ".toggle-reply, .response-content, .sub-responses, .form-reply"
    )
    .forEach((element) => {
      element.classList.toggle("hidden");
    });
}

import { submitComment } from "./api.js";
import { renderNewComment } from "./comment_renderer.js";

const replySection = document.querySelector("section.reply");
const formComment = replySection.querySelector("form");
const textAreaComment = formComment.querySelector("textarea");
const titleResponses = document.querySelector(".responses h3");

document.addEventListener("DOMContentLoaded", function () {
  replySection.style.display = "block";
  formComment.addEventListener("submit", handleNewComment);
});

async function handleNewComment(event) {
  event.preventDefault();
  const response = await submitComment(textAreaComment.value, null);
  renderNewComment(response, titleResponses, false);
}

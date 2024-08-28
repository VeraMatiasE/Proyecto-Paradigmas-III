document.addEventListener("DOMContentLoaded", function () {
  const toggleReplyButtons = document.querySelectorAll(".toggle-reply");
  const toggleCommentButtons = document.querySelectorAll(".toggle-comments");

  toggleCommentButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const replyForm = this.parentElement.nextElementSibling;
      replyForm.classList.toggle("hidden");
    });
  });

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
});

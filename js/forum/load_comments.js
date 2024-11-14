import { createReplyElement } from "./comment_renderer.js";
import { loadComments, getSlugPost } from "./api.js";

let limit = 5;
let offset = limit;
let stopSentinela = false;

const responses = document.querySelector(".responses");
const sentinela = document.getElementById("sentinela");

const loadingIcon = document.createElement("div");
loadingIcon.innerHTML = `<img src="${BASE_PATH}/images/Logo.svg" alt="Cargando...">`;
loadingIcon.style.display = "none";
loadingIcon.classList.add("loading-icon");
responses.appendChild(loadingIcon);

const footer = document.querySelector("footer");
footer.style.display = "none";

let loading = false;
const observer = new IntersectionObserver(
  async (entries) => {
    const sentinelaEntry = entries[0];
    if (sentinelaEntry.isIntersecting && !loading) {
      loading = true;
      toggleLoading(true);

      try {
        const newComments = await loadComments(offset, limit);
        newComments.comments.forEach((comment) => {
          const commentElement = createReplyElement(
            comment,
            getSlugPost(),
            newComments.is_logged
          );
          responses.appendChild(commentElement);
        });

        offset += limit;

        if (newComments.comments.length === 0) {
          stopSentinela = true;
          footer.style.display = "";
        }
      } catch (error) {
        console.error("Error al cargar más comentarios:", error);
      }

      toggleLoading(false, stopSentinela);
      loading = false;
    }
  },
  {
    rootMargin: "0px",
    threshold: 1.0,
  }
);

observer.observe(sentinela);

function toggleLoading(isLoading, stopSentinela = false) {
  loadingIcon.style.display = isLoading ? "flex" : "none";
  sentinela.style.display = isLoading || stopSentinela ? "none" : "block";
  if (isLoading) {
    responses.appendChild(loadingIcon);
  }
}

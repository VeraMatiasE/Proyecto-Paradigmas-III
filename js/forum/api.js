import { createReplyElement } from "./comment_renderer.js";

async function fetchData(url, method = "GET", data = null) {
  const options = {
    method,
    headers: {
      "Content-Type": "application/json",
    },
  };

  if (data) {
    options.body = JSON.stringify(data);
  }

  const response = await fetch(url, options);

  if (!response.ok) {
    throw new Error(`Error en la respuesta de la red: ${response.statusText}`);
  }

  return await response.json();
}

export function getSlugPost() {
  const pathParts = window.location.pathname.split("/");

  const discussionIndex = pathParts.indexOf("discussion");
  if (discussionIndex !== -1 && pathParts[discussionIndex + 1]) {
    return pathParts[discussionIndex + 1];
  }

  return null;
}

export async function submitComment(content, id_comment) {
  return await fetchData(`${BASE_PATH}/api/forum/create_comment.php`, "POST", {
    content,
    id_comment,
    slug: getSlugPost(),
  });
}

export async function loadComments(offset = 0, limit = 5) {
  let postSlug = getSlugPost();
  try {
    return await fetchData(
      `${BASE_PATH}/api/forum/load_comments.php?slug=${postSlug}&offset=${offset}`
    );
  } catch (error) {
    console.error("Error al cargar comentarios:", error);
    return { comments: [] };
  }
}

export async function loadMoreReplies(commentId, button) {
  const depthLimit = 7;
  button.disabled = true;

  try {
    const data = await fetchData(
      `${BASE_PATH}/api/forum/load_replies.php?comment_id=${commentId}&depth_limit=${depthLimit}`
    );
    if (data.success) {
      let subResponsesContainer = button
        .closest(".response")
        .querySelector(".sub-responses");

      if (!subResponsesContainer) {
        subResponsesContainer = document.createElement("div");
        subResponsesContainer.classList.add("sub-responses");
        button.closest(".response").appendChild(subResponsesContainer);
      }

      data.replies.forEach((reply) => {
        const replyElement = createReplyElement(reply, getSlugPost(), data.is_logged);
        subResponsesContainer.appendChild(replyElement);
      });

      if (!data.hasMoreReplies) {
        button.style.display = "none";
      }
    } else {
      console.error("Error al cargar respuestas:", data.error);
    }
  } catch (error) {
    console.error("Error de red:", error);
  } finally {
    button.disabled = false;
  }
}

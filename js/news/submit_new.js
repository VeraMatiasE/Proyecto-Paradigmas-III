const newsForm = document.querySelector(".news-form");
const richEditor = newsForm.querySelector("rich-editor");
const titleInput = newsForm.querySelector("input");
const banner = newsForm.querySelector("#banner");

const newsIdInput = newsForm.querySelector("#new-id");

newsForm.addEventListener("submit", submitContent);

async function submitContent(event) {
  event.preventDefault();

  if (!titleInput.value.trim() || !richEditor.getContent().trim()) {
    alert("Por favor, completa todos los campos obligatorios.");
    return;
  }

  replaceBlobUrls();
  const formData = buildFormData();

  try {
    newsForm.querySelector("button[type='submit']").disabled = true;

    const url = newsIdInput && newsIdInput.value
    ? "../../api/news/update_new.php"
    : "../../api/news/create_new.php"; 

    const response = await fetch(url, {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      throw new Error(`Error en la respuesta: ${response.status} ${response.statusText}`);
    }

    const result = await response.json();

    const newSlug = result.slug;

    window.location.href = `${newSlug}`;
  } catch (error) {
    console.error("Error enviando contenido:", error);
    alert("Hubo un problema al enviar el contenido. Inténtalo de nuevo.");
  } finally {
    newsForm.querySelector("button[type='submit']").disabled = false;
  }
}

function replaceBlobUrls() {
  const content = richEditor.getContent();
  const updatedContent = content.replace(/blob:[^"]+/g, (blobUrl) => {
    const matchingFile = richEditor.imageFiles.find(imageData => imageData.imgElement.src === blobUrl);
    return matchingFile ? matchingFile.file.name : blobUrl;
  });
  richEditor.setContent(updatedContent);
}

function buildFormData() {
  const formData = new FormData();

  if (newsIdInput && newsIdInput.value) {
    formData.append("id", newsIdInput.value.trim());
  }

  if (richEditor.imageFiles && richEditor.imageFiles.length > 0) {
    richEditor.imageFiles.forEach((imageData, index) => {
      formData.append(`image${index}`, imageData.file);
    });
  }

  if (banner.files && banner.files[0]) {
    formData.append("banner", banner.files[0]);
  }

  formData.append("title", titleInput.value.trim());
  formData.append("content", richEditor.getContent().trim());

  return formData;
}
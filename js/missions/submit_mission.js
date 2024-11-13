document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");

  const missionIdInput = form.querySelector("#id_mission");

  form.addEventListener("submit", async (event) => {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    form.querySelector("button[type='submit']").disabled = true;

    const url =
      missionIdInput && missionIdInput.value
        ? "../../../api/missions/update_mission.php"
        : "../../api/missions/create_mission.php";

    try {
      const response = await fetch(url, {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      const missionNewUrl = missionIdInput && missionIdInput.value  ? `../${result.slug}` : result.slug;

      window.location.href = `${missionNewUrl}`;
    } catch (error) {
      console.error("Error enviando contenido:", error);
      alert("Hubo un problema al enviar el contenido. Inténtalo de nuevo.");
    } finally {
        form.querySelector("button[type='submit']").disabled = false;
    }
  });
});

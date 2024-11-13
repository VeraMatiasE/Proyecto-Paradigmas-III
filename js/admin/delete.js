async function deleteMission(id_mission) {
    if (confirm("¿Estás seguro de que deseas eliminar esta misión?")) {
        try {
            const response = await fetch('../../api/missions/delete_mission.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id_mission })
            });

            const result = await response.json();

            if (result.success) {
                alert("La misión se ha eliminado con éxito.");
                document.getElementById(`mission-${id_mission}`).remove();
            } else {
                alert("Hubo un problema al eliminar la misión.");
            }
        } catch (error) {
            console.error('Error al eliminar la misión:', error);
            alert("Error en el servidor al intentar eliminar la misión.");
        }
    }
}

document.querySelectorAll('.delete-mission-btn').forEach(button => {
    button.addEventListener('click', (event) => {
        const id_mission = button.getAttribute('data-id');
        deleteMission(id_mission);
    });
});

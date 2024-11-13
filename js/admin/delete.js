document.addEventListener("DOMContentLoaded", () => {
    async function deleteEntity(entityId, entityType) {
        if (confirm(`¿Estás seguro de que deseas eliminar este/a ${entityType}?`)) {
            try {
                const response = await fetch('../../api/delete_entity.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: entityId, type: entityType })
                });
    
                const result = await response.json();
    
                if (result.success) {
                    alert(`${entityType} eliminado(a) con éxito.`);
                    document.getElementById(`${entityType}-${entityId}`).remove();
                } else {
                    alert(`Hubo un problema al eliminar el/la ${entityType}.`);
                }
            } catch (error) {
                console.error('Error al eliminar:', error);
                alert("Error en el servidor al intentar eliminar.");
            }
        }
    }
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', (event) => {
            const entityId = button.getAttribute('data-id');
            const entityType = button.getAttribute('data-type');
            deleteEntity(entityId, entityType);
        });
    });
    
})
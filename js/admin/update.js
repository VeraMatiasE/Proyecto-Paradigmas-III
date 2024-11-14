const form = document.getElementById('editForm');
const id_field = form.querySelector('#id');
const table_field = form.querySelector('#table');

form.addEventListener('submit', async function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    const table = table_field.value;
    const idColumn = id_field.name;
    const idValue = id_field.value;

    formData.append('table', table);
    formData.append('id_column', idColumn);
    formData.append('id_value', idValue);


    const response = await fetch('../../../api/update_entity.php', {
        method: 'POST',
        body: formData
    });

    const result = await response.json();
    if (result.success) {
        console.log(result.message);
        alert("Registro actualizado exitosamente");
        window.location.href = `../dashboard.php#${table}`;
    } else {
        console.error(result.message);
        alert("Error al actualizar el registro");
    }
});

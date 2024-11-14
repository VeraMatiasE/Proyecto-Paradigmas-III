const form = document.getElementById('addForm');
const table_field = form.querySelector('#table');

form.addEventListener('submit', async function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    const table = table_field.value;

    formData.append('table', table);

    const response = await fetch('../../../api/create_entity.php', {
        method: 'POST',
        body: formData
    });

    const result = await response.json();
    if (result.success) {
        console.log(result.message);
        alert("Registro agregado exitosamente");
        window.location.href = `../dashboard.php#${table}`;
    } else {
        console.error(result.message);
        alert("Error al agregar el registro");
    }
});

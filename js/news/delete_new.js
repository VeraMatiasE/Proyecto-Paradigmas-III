document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('.button.delete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const slug = this.getAttribute('data-slug');

            if (confirm("¿Estás seguro de que quieres eliminar esta noticia?")) {
                fetch(`../../api/news/delete_new.php?slug=${slug}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        const newElement = document.querySelector(`#new-${slug}`);
                        if (newElement) {
                            newElement.remove();
                        }
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al intentar eliminar la noticia.');
                });
            }
        });
    });
});
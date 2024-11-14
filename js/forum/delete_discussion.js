document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('.button.delete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const slug = this.getAttribute('data-slug');

            if (confirm("¿Estás seguro de que quieres eliminar este post?")) {
                fetch(`../../api/forum/delete_discussion.php?slug=${slug}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        const postElement = document.querySelector(`#post-${slug}`);
                        if (postElement) {
                            postElement.remove();
                        }
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al intentar eliminar el post.');
                });
            }
        });
    });
});
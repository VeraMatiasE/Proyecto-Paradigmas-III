class RichTextEditor extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });

        // Crear la barra de herramientas y el editor
        const toolbar = document.createElement('div');
        toolbar.classList.add('toolbar');

        const editorContainer = document.createElement('div');
        editorContainer.classList.add('editor-container');
        editorContainer.contentEditable = true;

        // Crear input oculto para selección de imagen
        const imageInput = document.createElement('input');
        imageInput.type = 'file';
        imageInput.accept = 'image/*';
        imageInput.style.display = 'none';

        // Estilos para el editor y la barra de herramientas
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = `${BASE_PATH}/styles/css/richText.css`;

        // Botones de la barra de herramientas
        toolbar.innerHTML = `
            <img class="undo" data-command="undo" src="${BASE_PATH}/images/JS WebComponents/RichEditor/undo.svg" alt="Deshacer" >
            <img class="redo" data-command="redo" src="${BASE_PATH}/images/JS WebComponents/RichEditor/redo.svg" alt="Rehacer" >
            <button class="bold" data-command="bold">B</button>
            <button class="italic" data-command="italic">I</button>
            <button data-command="formatBlock" data-value="h1">H1</button>
            <button data-command="formatBlock" data-value="h2">H2</button>
            <button data-command="formatBlock" data-value="div">p</button>
            <img data-command="insertImage" src="${BASE_PATH}/images/JS WebComponents/RichEditor/image.svg" alt="Insertar Imagen" >
            <img data-command="createLink" src="${BASE_PATH}/images/JS WebComponents/RichEditor/link.svg" alt="Insertar Enlace" >
            <!-- Alineación -->
            <img data-command="justifyLeft" src="${BASE_PATH}/images/JS WebComponents/RichEditor/left-align.svg" alt="Undo" >
            <img data-command="justifyCenter" src="${BASE_PATH}/images/JS WebComponents/RichEditor/center-align.svg" alt="Undo" >
            <img data-command="justifyRight" src="${BASE_PATH}/images/JS WebComponents/RichEditor/right-align.svg" alt="Undo" >
            <!-- Listas -->
            <img data-command="insertUnorderedList" src="${BASE_PATH}/images/JS WebComponents/RichEditor/u-list.svg" alt="Lista Desordenada" >
            <img data-command="insertOrderedList" src="${BASE_PATH}/images/JS WebComponents/RichEditor/o-list.svg" alt="Lista Ordenada" >
        `;

        // Event listeners para los botones de la barra de herramientas
        toolbar.querySelectorAll('button, img').forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                editorContainer.focus();
                const command = event.target.getAttribute('data-command');
                const value = event.target.getAttribute('data-value') || null;

                if (command === 'insertImage') {
                    imageInput.click();
                } else if (command === 'createLink') {
                    const url = prompt("Ingrese la URL del enlace:");
                    if (url) {
                        document.execCommand('createLink', false, url);
                    }
                } else {
                    document.execCommand(command, false, value);
                }
            });
        });

        imageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const imageUrl = URL.createObjectURL(file);
                const imgElement = document.createElement('img');
                imgElement.src = imageUrl;
                imgElement.classList.add('preview');

                const rootSelection = window.navigator.userAgent.toLowerCase().includes("chrome")?this.shadowRoot:window;
                const selection = rootSelection.getSelection();
                const range = selection.getRangeAt(0);
                range.deleteContents();
                range.insertNode(imgElement);
                range.setStartAfter(imgElement);
                range.setEndAfter(imgElement);
                selection.removeAllRanges();
                selection.addRange(range);

                if (!this.imageFiles) this.imageFiles = [];
                this.imageFiles.push({ file, imgElement });
            }
        });

        this.shadowRoot.append(link, toolbar, editorContainer, imageInput);
    }

    getContent() {
        return this.shadowRoot.querySelector('.editor-container').innerHTML;
    }

    setContent(html) {
        this.shadowRoot.querySelector('.editor-container').innerHTML = html;
    }
}


customElements.define('rich-editor', RichTextEditor);
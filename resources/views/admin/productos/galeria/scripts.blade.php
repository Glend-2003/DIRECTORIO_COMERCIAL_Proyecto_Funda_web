<script>
let deleteImageId = null;

// Auto-cerrar alertas
setTimeout(() => {
    const successAlert = document.getElementById('successAlert');
    const errorAlert = document.getElementById('errorAlert');
    if (successAlert) successAlert.remove();
    if (errorAlert) errorAlert.remove();
}, 5000);

//DRAG & DROP PARA SUBIR ARCHIVO
const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('fileInput');
const previewContainer = document.getElementById('previewContainer');
const uploadButton = document.getElementById('uploadButton');

// Click en dropzone abre selector de archivos
dropzone.addEventListener('click', () => fileInput.click());

// Prevenir comportamiento por defecto
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropzone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

// Efectos visuales al arrastrar
['dragenter', 'dragover'].forEach(eventName => {
    dropzone.addEventListener(eventName, () => {
        dropzone.classList.add('border-blue-500', 'bg-blue-50');
    });
});

['dragleave', 'drop'].forEach(eventName => {
    dropzone.addEventListener(eventName, () => {
        dropzone.classList.remove('border-blue-500', 'bg-blue-50');
    });
});

// Manejar drop
dropzone.addEventListener('drop', (e) => {
    const dt = e.dataTransfer;
    const files = dt.files;
    fileInput.files = files;
    handleFiles(files);
});

// Manejar selección de archivos
fileInput.addEventListener('change', (e) => {
    handleFiles(e.target.files);
});

function handleFiles(files) {
    previewContainer.innerHTML = '';
    
    if (files.length > 0) {
        previewContainer.classList.remove('hidden');
        uploadButton.disabled = false;
        
        Array.from(files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                        <div class="aspect-square rounded-lg overflow-hidden border-2 border-slate-200">
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute top-2 left-2 bg-slate-900/80 text-white text-xs font-bold px-2 py-1 rounded">
                            ${index + 1}
                        </div>
                    `;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });
    } else {
        previewContainer.classList.add('hidden');
        uploadButton.disabled = true;
    }
}

//SORTABLE PARA REORDENAR IMÁGENES
const galeriaGrid = document.getElementById('galeriaGrid');
if (galeriaGrid) {
    const sortable = new Sortable(galeriaGrid, {
        animation: 150,
        ghostClass: 'opacity-50',
        onEnd: function() {
            updateOrder();
        }
    });
}

function updateOrder() {
    const items = document.querySelectorAll('.galeria-item');
    const orden = Array.from(items).map(item => item.getAttribute('data-id'));
    
    fetch('{{ route("productos.galeria.updateOrder", $producto->ID_PRODUCTO) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ orden: orden })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Actualizar números de orden visual
            items.forEach((item, index) => {
                const badge = item.querySelector('.absolute.top-2.left-2');
                if (badge) {
                    badge.textContent = '#' + (index + 1);
                }
            });
        }
    })
    .catch(error => console.error('Error:', error));
}

//MODAL VISTA PREVIA
function openImageModal(url) {
    const modal = document.getElementById('imageModal');
    const img = document.getElementById('modalImage');
    img.src = url;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// MODAL ELIMINAR 
function confirmDelete(id) {
    deleteImageId = id;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    deleteImageId = null;
}

function executeDelete() {
    if (deleteImageId) {
        document.getElementById('deleteForm' + deleteImageId).submit();
    }
}

// Cerrar modal con ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeImageModal();
        closeDeleteModal();
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('imageModal')?.addEventListener('click', (e) => {
    if (e.target === e.currentTarget) closeImageModal();
});

document.getElementById('deleteModal')?.addEventListener('click', (e) => {
    if (e.target === e.currentTarget) closeDeleteModal();
});

console.log('JavaScript de Galería cargado correctamente');
</script>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear historia</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-[#18191A] text-white min-h-screen overflow-x-hidden">

<div class="min-h-screen flex flex-col">

    <!-- HEADER -->
    <div class="flex items-center justify-between px-4 md:px-8 py-4">

        <button onclick="window.history.back()" class="text-3xl md:text-4xl hover:opacity-70">
            ✕
        </button>

        <h1 class="text-xl md:text-3xl font-bold">
            Crear historia
        </h1>

        <button class="text-2xl md:text-3xl hover:opacity-70">
            ⚙
        </button>

    </div>

    <!-- CONTENIDO -->
    <div class="flex-1 flex flex-col items-center justify-center px-6 py-12">

        <div class="text-[90px] md:text-[140px] mb-6">📁</div>

        <h2 class="text-3xl md:text-5xl font-bold text-center">
            Selecciona una foto o video
        </h2>

        <p class="text-gray-400 text-center mt-5 text-lg md:text-2xl max-w-[700px]">
            Elige un archivo desde tu computadora para crear tu historia.
        </p>

        <!-- FORM -->
<form id="storyForm"
            action="{{ route('historias.editor') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <input type="file"
           id="storyFile"
           name="media"
           hidden
           accept="image/*,video/*">

    <button
        type="button"
        onclick="document.getElementById('storyFile').click()"
        class="mt-6 bg-blue-600 px-6 py-3 rounded-xl">
        Seleccionar archivo
    </button>

</form>

<div id="previewContainer" class="hidden mt-8 max-w-md">

    <img
        id="imagePreview"
        class="hidden rounded-3xl w-full max-h-[500px] object-cover">

    <video
        id="videoPreview"
        class="hidden rounded-3xl w-full max-h-[500px] object-cover"
        controls>
    </video>

    <button
        id="continueButton"
        type="button"
        class="hidden mt-4 w-full bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-3 rounded-2xl">
        Continuar
    </button>

</div>

        <!-- CAMERA -->
        <button id="cameraButton" class="mt-10 bg-[#2B2D31] hover:bg-[#3A3B3C] px-6 md:px-10 py-4 md:py-5 rounded-2xl text-lg md:text-2xl font-bold transition">
            📷 Usar la cámara
        </button>

    </div>

</div>

<div id="cameraModal" class="hidden fixed inset-0 bg-black/95 z-50 flex items-center justify-center p-4">
    <div class="relative w-full max-w-2xl rounded-[32px] overflow-hidden border border-white/10 bg-black shadow-2xl">
        <video id="cameraVideo" autoplay playsinline muted class="w-full h-[60vh] bg-black object-cover"></video>

        <div class="flex flex-col gap-3 p-4 bg-black/90">
            <div class="flex items-center justify-between">
                <div class="text-white text-lg font-semibold">Cámara activa</div>
                <button id="closeCameraButton" class="rounded-full bg-white/10 px-4 py-2 text-sm text-white hover:bg-white/20 transition">Cerrar</button>
            </div>
            <p class="text-sm text-gray-300">Toma una foto y se enviará directamente al editor de historias.</p>
            <button id="captureButton" class="w-full rounded-2xl bg-blue-600 px-4 py-4 text-base font-semibold text-white hover:bg-blue-500 transition">Tomar foto</button>
        </div>
    </div>
</div>

<!-- JS LIMPIO -->
<script>

const fileInput = document.getElementById('storyFile');
const form = document.getElementById('storyForm');
const cameraButton = document.getElementById('cameraButton');
const cameraModal = document.getElementById('cameraModal');
const cameraVideo = document.getElementById('cameraVideo');
const captureButton = document.getElementById('captureButton');
const closeCameraButton = document.getElementById('closeCameraButton');
let cameraStream = null;

cameraButton.addEventListener('click', async function () {
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        alert('Tu navegador no soporta cámara. Usa la opción de seleccionar archivo.');
        return;
    }

    try {
        cameraStream = await navigator.mediaDevices.getUserMedia({ video: true });
        cameraVideo.srcObject = cameraStream;
        cameraModal.classList.remove('hidden');
    } catch (error) {
        alert('No se pudo acceder a la cámara: ' + error.message);
    }
});

closeCameraButton.addEventListener('click', function () {
    if (cameraStream) {
        cameraStream.getTracks().forEach(track => track.stop());
        cameraStream = null;
    }
    cameraModal.classList.add('hidden');
});

captureButton.addEventListener('click', function () {
    if (!cameraStream) {
        alert('La cámara no está activada.');
        return;
    }

    const canvas = document.createElement('canvas');
    canvas.width = cameraVideo.videoWidth || 1280;
    canvas.height = cameraVideo.videoHeight || 720;
    const context = canvas.getContext('2d');
    context.drawImage(cameraVideo, 0, 0, canvas.width, canvas.height);

    canvas.toBlob(function (blob) {
        if (!blob) {
            alert('No se pudo tomar la foto.');
            return;
        }

        const file = new File([blob], `story-${Date.now()}.jpg`, { type: 'image/jpeg' });
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;

        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
        }

        cameraModal.classList.add('hidden');
        form.submit();
    }, 'image/jpeg', 0.95);
});
const previewContainer =
    document.getElementById('previewContainer');

const imagePreview =
    document.getElementById('imagePreview');

const videoPreview =
    document.getElementById('videoPreview');

const continueButton =
    document.getElementById('continueButton');

fileInput.addEventListener('change', function () {

    const file = this.files[0];

    if (!file) return;

    const url = URL.createObjectURL(file);

    previewContainer.classList.remove('hidden');

    imagePreview.classList.add('hidden');
    videoPreview.classList.add('hidden');

    if (file.type.startsWith('image')) {

        imagePreview.src = url;
        imagePreview.classList.remove('hidden');

    } else {

        videoPreview.src = url;
        videoPreview.classList.remove('hidden');

    }

    continueButton.classList.remove('hidden');
});

continueButton.addEventListener('click', function () {
    form.submit();
});

</script>

</body>
</html>
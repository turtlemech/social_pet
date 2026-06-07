<form
    action="{{ route('stories.store') }}"
    method="POST"
    enctype="multipart/form-data"
    class="min-h-screen bg-black text-white flex flex-col"
>
    @csrf

    <!-- HEADER -->
    <div class="flex items-center justify-between p-5 border-b border-gray-800">

        <h1 class="text-2xl font-bold">
            Crear historia
        </h1>

        <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 px-5 py-2 rounded-full font-semibold"
        >
            Publicar
        </button>

    </div>

    <!-- CONTENIDO -->
    <div class="flex-1 overflow-y-auto px-5 py-8">

        <div class="max-w-4xl mx-auto">

            <!-- PREVIEW -->
            <div
                id="previewContainer"
                class="hidden mb-8"
            >

                <img
                    id="imagePreview"
                    class="hidden w-full max-h-[600px] object-contain rounded-3xl"
                >

                <video
                    id="videoPreview"
                    controls
                    class="hidden w-full max-h-[600px] object-contain rounded-3xl"
                >
                </video>

            </div>

            <!-- SELECCIONAR ARCHIVO -->
            <label
                class="relative block rounded-[35px] overflow-hidden min-h-[450px] cursor-pointer group"
            >

                <input
                    type="file"
                    name="media"
                    id="mediaInput"
                    accept="image/*,video/*"
                    required
                    class="hidden"
                >

                <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-cyan-500 to-indigo-700"></div>

                <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition"></div>

                <div class="relative h-full flex flex-col justify-end p-10">

                    <div class="text-6xl mb-6">
                        📸
                    </div>

                    <h2 class="text-3xl font-bold mb-3">
                        Foto o video
                    </h2>

                    <p class="text-white/80">
                        Haz clic para seleccionar una imagen o video.
                    </p>

                </div>

            </label>

            <!-- TEXTO OPCIONAL -->
            <div class="mt-8">

                <label class="block mb-2 font-semibold">
                    Descripción
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="w-full bg-gray-900 border border-gray-700 rounded-xl p-4 outline-none focus:border-blue-500"
                    placeholder="Escribe algo para tu historia..."
                ></textarea>

            </div>

        </div>

    </div>

</form>

<script>

const mediaInput = document.getElementById('mediaInput');

const previewContainer =
    document.getElementById('previewContainer');

const imagePreview =
    document.getElementById('imagePreview');

const videoPreview =
    document.getElementById('videoPreview');

mediaInput.addEventListener('change', function ()
{
    const file = this.files[0];

    if (!file)
        return;

    const url = URL.createObjectURL(file);

    previewContainer.classList.remove('hidden');

    imagePreview.classList.add('hidden');
    videoPreview.classList.add('hidden');

    if (file.type.startsWith('image'))
    {
        imagePreview.src = url;

        imagePreview.classList.remove('hidden');
    }
    else if (file.type.startsWith('video'))
    {
        videoPreview.src = url;

        videoPreview.classList.remove('hidden');
    }
});

</script>
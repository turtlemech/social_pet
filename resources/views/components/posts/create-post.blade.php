<div class="bg-white rounded-xl shadow-sm p-4 mb-6">

    <div class="flex space-x-3">

        <!-- AVATAR -->
        @if(auth()->user()->ava_us)

            <img
                src="{{ asset('storage/' . auth()->user()->ava_us) }}"
                alt="Avatar"
                class="w-10 h-10 rounded-full object-cover"
            >

        @else

            <div class="w-10 h-10 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">

                {{ strtoupper(substr(auth()->user()->nom_us ?? 'U', 0, 1)) }}

            </div>

        @endif

        <!-- BOTÓN PUBLICAR -->
        <div class="flex-1">

            <button
                type="button"
                onclick="document.getElementById('post-modal').classList.remove('hidden')"
                class="w-full text-left px-4 py-3 rounded-full bg-gray-100 hover:bg-gray-200 transition text-gray-500"
            >
                ✍️ Hacer publicación
            </button>

        </div>

    </div>

</div>
<!-- MODAL -->
<div
    id="post-modal"
    class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
>

    <div class="bg-white rounded-3xl max-w-xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">

        <!-- HEADER -->
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">

            <h3 class="text-xl font-bold text-gray-800 mx-auto">
                Crear publicación
            </h3>

            <button
                type="button"
                onclick="document.getElementById('post-modal').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl"
            >

                ✕

            </button>

        </div>

        <!-- FORM -->
        <form
            method="POST"
            action="{{ route('posts.store') }}"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="p-5">

                <!-- PERFIL -->
                <div class="flex items-center gap-4 mb-5">

                    @if(auth()->user()->ava_us)

                        <img
                            src="{{ asset('storage/' . auth()->user()->ava_us) }}"
                            class="w-14 h-14 rounded-full object-cover"
                        >

                    @else

                        <div class="w-14 h-14 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold text-lg">

                            {{ strtoupper(substr(auth()->user()->nom_us ?? 'U', 0, 1)) }}

                        </div>

                    @endif

                    <div>

                        <p class="font-bold text-gray-800">

                            {{ auth()->user()->nom_us ?? 'Usuario' }}

                        </p>

                        <p class="text-sm text-gray-500">

                            Crear nueva publicación

                        </p>

                    </div>

                </div>

                <!-- PUBLICAR COMO -->
                <div class="mb-5">

                    <label class="block mb-2 font-semibold text-gray-700">

                        Publicar como

                    </label>

                    <select
                        name="mascota_id"
                        class="w-full border border-gray-200 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-500"
                    >

                        <option value="">
                            Usuario
                        </option>

                        @foreach(auth()->user()->mascotas as $mascota)

                            <option value="{{ $mascota->id }}">

                                🐾 {{ $mascota->nom_mas }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- TEXTO -->
                <textarea
                    name="content"
                    placeholder="¿Qué está pasando?"
                    class="w-full border border-gray-200 rounded-2xl p-4 resize-none focus:outline-none focus:ring-2 focus:ring-teal-500 text-gray-700"
                    rows="5"
                ></textarea>
                <!-- UBICACIÓN -->

<div class="mt-5">

    <label class="block mb-2 font-semibold text-gray-700">
        Ubicación
    </label>

    <input
        type="text"
        name="ubicacion"
        placeholder="Ej: La Paz, Bolivia"
        class="w-full border border-gray-200 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-500"
    >

</div>
<!-- MÚSICA -->

<div class="mt-5">

    <label class="block mb-2 font-semibold text-gray-700">
        Música
    </label>

    <input

    type="text"

    id="spotifySearch"

    placeholder="Buscar canción..."

    class="w-full border border-gray-200 rounded-2xl px-4 py-3"

>

<input type="hidden" name="musica" id="musica">

<input type="hidden" name="musica_artista" id="musica_artista">

<input type="hidden" name="musica_preview" id="musica_preview">

<div

    id="spotifyResults"

    class="mt-2 max-h-60 overflow-y-auto"

></div>

</div>

                <!-- IMÁGENES CARRUSEL -->

<div class="mt-5">

    <label class="block mb-2 font-semibold text-gray-700">

        Imágenes (máximo 5)

    </label>

    <input

        id="imagesInput"

        type="file"

        name="images[]"

        accept="image/*"

        multiple

        class="w-full border border-gray-200 rounded-2xl p-3"

    >

    <div

        id="previewContainer"

        class="grid grid-cols-3 gap-2 mt-4"

    ></div>

</div>

                <!-- BOTÓN -->
                <div class="mt-6">

                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white py-3 rounded-2xl font-semibold transition shadow-md hover:shadow-lg"
                    >

                        Publicar

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>
<script>

document.addEventListener('DOMContentLoaded', () => {

    const input =
        document.getElementById('imagesInput');

    const preview =
        document.getElementById('previewContainer');

    if(!input) return;

    input.addEventListener('change', function() {

        preview.innerHTML = '';

        if(this.files.length > 5){

            alert('Máximo 5 imágenes');

            this.value = '';

            return;
        }

        Array.from(this.files).forEach(file => {

            const reader = new FileReader();

            reader.onload = function(e){

                preview.innerHTML += `
                    <img
                        src="${e.target.result}"
                        class="w-full h-24 object-cover rounded-xl"
                    >
                `;

            };

            reader.readAsDataURL(file);

        });

    });

});

</script>
<script>

const searchInput =
    document.getElementById('spotifySearch');

const resultsBox =
    document.getElementById('spotifyResults');

if(searchInput){

    let timer;

    searchInput.addEventListener('input', function(){

        clearTimeout(timer);

        if(this.value.length < 2){

            resultsBox.innerHTML = '';
            return;

        }

        timer = setTimeout(async () => {

            const response =
                await fetch(
                    '/music/search?q=' +
                    encodeURIComponent(this.value)
                );

            const data =
                await response.json();

            resultsBox.innerHTML = '';

            data.tracks.forEach(track => {

                resultsBox.innerHTML += `
                    <div
                        class="spotify-track flex items-center gap-3 p-2 hover:bg-gray-100 rounded-xl cursor-pointer"
                        data-title="${track.title}"
                        data-artist="${track.artist}"
                        data-preview="${track.preview ?? ''}"
                    >
                        <img
                            src="${track.cover}"
                            class="w-12 h-12 rounded-lg"
                        >

                        <div>
                            <div class="font-medium">
                                ${track.title}
                            </div>

                            <div class="text-sm text-gray-500">
                                ${track.artist}
                            </div>
                        </div>
                    </div>
                `;

            });

        }, 500);

    });

    document.addEventListener('click', function(e){

        const track =
            e.target.closest('.spotify-track');

        if(!track) return;

        document.getElementById('musica').value =
            track.dataset.title;

        document.getElementById('musica_artista').value =
            track.dataset.artist;

        document.getElementById('musica_preview').value =
            track.dataset.preview;

        searchInput.value =
            `${track.dataset.title} - ${track.dataset.artist}`;

        resultsBox.innerHTML = '';

    });

}

</script>
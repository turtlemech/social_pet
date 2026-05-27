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

        <!-- INPUT -->
        <div class="flex-1">

            <input
                type="text"
                placeholder="¿Qué está pasando?"
                class="w-full px-4 py-2 rounded-full bg-gray-100 border-0 focus:ring-2 focus:ring-teal-500 focus:bg-white transition cursor-pointer"
                readonly
                onclick="document.getElementById('post-modal').classList.remove('hidden')"
            >

        </div>

    </div>

    <!-- ACTIONS -->
    <div class="flex justify-around mt-4 pt-3 border-t border-gray-100">

        <!-- IMAGEN -->
        <button
            onclick="document.getElementById('post-modal').classList.remove('hidden')"
            class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 transition"
        >

            <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                ></path>

            </svg>

            <span class="text-sm font-medium">
                Imagen
            </span>

        </button>

        <!-- VIDEO -->
        <button
            onclick="document.getElementById('post-modal').classList.remove('hidden')"
            class="flex items-center space-x-2 text-gray-500 hover:text-red-500 transition"
        >

            <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
                ></path>

            </svg>

            <span class="text-sm font-medium">
                Video
            </span>

        </button>

        <!-- UBICACIÓN -->
        <button
            onclick="document.getElementById('post-modal').classList.remove('hidden')"
            class="flex items-center space-x-2 text-gray-500 hover:text-green-500 transition"
        >

            <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                ></path>

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                ></path>

            </svg>

            <span class="text-sm font-medium">
                Ubicación
            </span>

        </button>

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

                <!-- IMAGEN -->
                <div class="mt-5">

                    <label class="block mb-2 font-semibold text-gray-700">

                        Imagen

                    </label>

                    <input
                        type="file"
                        name="image"
                        accept="image/*"
                        class="w-full border border-gray-200 rounded-2xl p-3"
                    >

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
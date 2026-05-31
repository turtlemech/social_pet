@props(['post'])

<div

    onclick="event.preventDefault(); event.stopPropagation(); openCommentsModal({{ $post->id }})"

    class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden cursor-pointer hover:shadow-md transition"

>

    <!-- HEADER -->
    <div class="p-4 flex items-center justify-between">

        <div class="flex items-center space-x-3">

          <a

    onclick="event.stopPropagation()"

    href="{{ $post->mascota

        ? route('pets.show', $post->mascota->id)

        : route('usuario.profile', optional($post->usuario)->id)

    }}"

>

    <img
    src="{{ $post->mascota && $post->mascota->fot_mas
        ? asset('storage/' . $post->mascota->fot_mas)
        : (
            optional($post->usuario)->ava_us
            ? asset('storage/' .optional($post->usuario)->ava_us)
            : 'https://ui-avatars.com/api/?name='.urlencode(optional($post->usuario)->nom_us ?? 'Usuario').'&background=0d9488&color=fff'
        )
    }}"
    alt="Usuario"
    class="w-10 h-10 rounded-full object-cover hover:scale-105 transition"
>

</a>

            <div>
<a
    onclick="event.stopPropagation()"
    href="{{ $post->mascota
        ? route('pets.show', $post->mascota->id)
        : route('usuario.profile', optional($post->usuario)->id)
    }}"
    class="font-semibold text-gray-900 hover:text-teal-600 transition"
>

    {{ $post->mascota
        ? optional($post->mascota)->nom_mas
        : (optional($post->usuario)->nom_us ?? 'Usuario')
    }}

</a>

                <p class="text-xs text-gray-400">

                    @if(!empty($post->created_at))

                        {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}

                    @else

                        Sin fecha

                    @endif

                </p>

            </div>

        </div>

        <!-- DELETE -->
        @if(isset($post->us_id) && auth()->id() == $post->us_id)

            <form
                action="{{ route('posts.destroy', ['post' => $post->id]) }}"
                method="POST"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="text-red-500 hover:text-red-700"
                    onclick="event.stopPropagation(); return confirm('¿Eliminar publicación?')"
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
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"
                        />

                    </svg>

                </button>

            </form>

        @endif

    </div>

    <!-- CONTENT -->
    @if(!empty($post->com_pub))

<div class="px-4 pb-3">

    <p class="text-gray-800 whitespace-pre-line">

        {{ $post->com_pub }}

    </p>

</div>

@endif

    <!-- IMAGE -->
    @if(!empty($post->img_pub))

    <img

        onclick="event.stopPropagation(); openCommentsModal({{ $post->id }})"

        src="{{ asset('storage/' . $post->img_pub) }}"

        alt="Publicación"

        class="w-full object-cover max-h-96 cursor-pointer"

    >

@endif

    <!-- STATS -->
    <div class="px-4 py-2 flex justify-between text-sm text-gray-500 border-t border-gray-100">

        <div class="flex items-center space-x-1">

            <svg
                class="w-4 h-4 text-red-500 fill-current"
                viewBox="0 0 20 20"
            >

                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>

            </svg>

            <span id="likes-{{ $post->id }}">

                {{ $post->likes_count ?? 0 }} likes

            </span>

        </div>

        <div>

            {{ optional($post->comentarios)->count() ?? 0 }} comentarios

        </div>

    </div>

 

<!-- ACTIONS -->
<div class="flex border-t border-gray-100">

    <!-- LIKE -->
   <button

    type="button"

    data-id="{{ $post->id }}"

    class="like-btn flex-1 py-2 flex items-center justify-center space-x-2 transition {{ !empty($post->liked) ? 'text-red-500' : 'text-gray-500 hover:text-red-500' }}"

>

    <svg

        class="w-5 h-5 like-icon {{ !empty($post->liked) ? 'fill-red-500' : '' }}"

        fill="{{ !empty($post->liked) ? 'currentColor' : 'none' }}"

        stroke="currentColor"

        viewBox="0 0 24 24"

    >

        <path

            stroke-linecap="round"

            stroke-linejoin="round"

            stroke-width="2"

            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"

        />

    </svg>

    <span>Like</span>

</button>

    <!-- COMMENT -->
    <button
        onclick="event.stopPropagation(); openCommentsModal({{ $post->id }})"
        class="flex-1 py-2 flex items-center justify-center space-x-2 text-gray-500 hover:text-teal-500 transition"
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
                d="M8 12h.01M12 12h.01M16 12h.01"
            />

        </svg>

        <span>Comentarios</span>

    </button>

    <!-- SHARE -->
    <button
        type="button"
        class="flex-1 py-2 flex items-center justify-center space-x-2 text-gray-500 hover:text-green-500 transition"
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
                d="M8.684 13.342l6.632 3.316m0-6l-6.632-3.316"
            />

        </svg>

        <span>Share</span>

    </button>

</div>

    <!-- COMMENTS -->
    <div class="border-t border-gray-100 p-4">

        <!-- FORM -->
        <form
    onclick="event.stopPropagation()"
    action="{{ route('posts.comment', ['post' => $post->id]) }}"
    method="POST"
    class="flex gap-2 mb-4"
>

            @csrf

            <input
                type="text"
                name="comentario"
                placeholder="Escribe un comentario..."
                class="flex-1 border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                required
            >

            <button
                type="submit"
                class="bg-teal-500 text-white px-4 py-2 rounded-lg hover:bg-teal-600"
            >

                Comentar

            </button>

        </form>

        <!-- COMMENTS LIST -->
        @if(isset($post->comentarios) && $post->comentarios->count() > 0)

            @foreach($post->comentarios->take(3) as $comentario)

                @if($comentario->estado == 'activo')

                    <div class="bg-gray-50 rounded-lg p-3 mb-2">

                        <div class="flex items-center justify-between mb-1">

                           <a

    onclick="event.stopPropagation()"

    href="{{ route('usuario.profile', optional($comentario->usuario)->id) }}"

    class="font-semibold text-sm text-gray-800 hover:text-teal-600 transition"

>

    {{ optional($comentario->usuario)->nom_us ?? 'Usuario' }}

</a>

                            <div class="text-xs text-gray-400">

                                @if(!empty($comentario->created_at))

                                    {{ optional($comentario->created_at)->diffForHumans() }}

                                @endif

                            </div>

                        </div>

                        <div class="text-sm text-gray-700">

                            {{ $comentario->con_com }}

                        </div>

                    </div>

                @endif

            @endforeach

        @endif

    </div>

</div>






<!-- COMMENTS MODAL -->
<div

    id="comments-modal-{{ $post->id }}"

    onclick="event.stopPropagation(); closeCommentsModal({{ $post->id }})"

    class="hidden fixed top-0 left-0 w-screen h-screen bg-black/60 backdrop-blur-md z-[9999] flex items-center justify-center p-6"

>

    <div
        onclick="event.stopPropagation()"
        class="bg-white w-full max-w-6xl h-[92vh] rounded-3xl overflow-hidden flex relative shadow-2xl my-auto"    >

        <!-- CLOSE -->
        <button
            onclick="event.stopPropagation(); closeCommentsModal({{ $post->id }})"
            class="absolute top-5 right-5 z-50 bg-white/80 backdrop-blur-md text-gray-700 w-11 h-11 rounded-full hover:scale-110 transition shadow-lg"
        >
            ✕
        </button>

        @if(!empty($post->img_pub))

            <!-- LEFT IMAGE -->
            <div class="hidden md:flex w-1/2 bg-black items-center justify-center">

                <img
                    src="{{ asset('storage/' . $post->img_pub) }}"
                    class="w-full h-full object-cover"
                >

            </div>

            <!-- RIGHT -->
            <div class="w-full md:w-1/2 flex flex-col bg-white">

        @else

            <!-- SIN IMAGEN -->
            <div class="w-full flex flex-col bg-white">

        @endif

                <!-- USER -->
                <div class="p-5 border-b border-gray-100 flex items-center space-x-3 bg-white">

                    <a
    onclick="event.stopPropagation()"
    href="{{ $post->mascota
        ? route('pets.show', $post->mascota->id)
        : route('usuario.profile', optional($post->usuario)->id)
    }}"
>

    <img
        src="{{ $post->mascota && $post->mascota->fot_mas
            ? asset('storage/' . $post->mascota->fot_mas)
            : (
                optional($post->usuario)->ava_us
                ? asset('storage/' .optional($post->usuario)->ava_us)
                : 'https://ui-avatars.com/api/?name='.urlencode(optional($post->usuario)->nom_us ?? 'Usuario').'&background=0d9488&color=fff'
            )
        }}"
        alt="Usuario"
        class="w-10 h-10 rounded-full object-cover hover:scale-105 transition"
    >

</a>

                    <div>

                        <a
                            onclick="event.stopPropagation()"
                            href="{{ $post->mascota
                                ? route('pets.show', $post->mascota->id)
                                : route('usuario.profile', optional($post->usuario)->id)
                            }}"
                            class="font-semibold hover:text-teal-600 transition"
                        >

                            {{ $post->mascota
                                ? optional($post->mascota)->nom_mas
                                : (optional($post->usuario)->nom_us ?? 'Usuario')
                            }}

                        </a>

                        <div class="text-xs text-gray-400">

                            {{ optional($post->created_at)->diffForHumans() }}

                        </div>

                    </div>

                </div>

                <!-- POST CONTENT -->

@if(!empty($post->com_pub))

<div class="px-4 py-3 border-b">

    <p class="text-gray-700 whitespace-pre-line text-[15px]">

        {{ $post->com_pub }}

    </p>

</div>

@endif

                <!-- COMMENTS -->
                <div class="flex-1 overflow-y-auto p-5 space-y-4 bg-[#fafafa]">

                    @foreach($post->comentarios as $comentario)

                        @if($comentario->estado == 'activo')

                            <div class="bg-white rounded-2xl p-4 shadow-sm">

                                <div class="flex justify-between items-start">

                                    <div>

                                        <a
                                            onclick="event.stopPropagation()"
                                            href="{{ route('usuario.profile', optional($comentario->usuario)->id) }}"
                                            class="font-semibold text-sm hover:text-teal-600 transition"
                                        >

                                            {{ optional($comentario->usuario)->nom_us ?? 'Usuario' }}

                                        </a>

                                        <p class="text-sm text-gray-700 mt-1">

                                            {{ $comentario->con_com }}

                                        </p>

                                    </div>

                                    <span class="text-xs text-gray-400 ml-2 whitespace-nowrap">

                                        {{ optional($comentario->created_at)->diffForHumans() }}

                                    </span>

                                </div>

                            </div>

                        @endif

                    @endforeach

                </div>

                <!-- COMMENT FORM -->
                <div class="border-t p-4 bg-white">

                    <form
                        onclick="event.stopPropagation()"
                        action="{{ route('posts.comment', ['post' => $post->id]) }}"
                        method="POST"
                        class="flex gap-2"
                    >

                        @csrf

                        <input
                            type="text"
                            name="comentario"
                            placeholder="Agrega un comentario..."
                            class="flex-1 bg-gray-100 border-0 rounded-full px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400 placeholder:text-gray-400"
                            required
                        >

                        <button
                            type="submit"
                            class="bg-gradient-to-r from-teal-400 to-emerald-500 text-white px-6 py-3 rounded-full hover:scale-105 transition font-medium shadow-lg"
                        >

                            Enviar

                        </button>

                    </form>

                </div>

            </div>

    </div>

</div>
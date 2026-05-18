@props(['post'])

<div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">

    <!-- HEADER -->
    <div class="p-4 flex items-center justify-between">

        <div class="flex items-center space-x-3">

            <img
                src="{{ $post->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($post->user->nom_us ?? 'Usuario').'&background=0d9488&color=fff' }}"
                alt="Usuario"
                class="w-10 h-10 rounded-full object-cover"
            >

            <div>

                <h4 class="font-semibold text-gray-900">
                    {{ $post->user->nom_us ?? 'Usuario' }}
                </h4>

                <p class="text-xs text-gray-400">

                    @if(!empty($post->fec_pub))

                        {{ \Carbon\Carbon::parse($post->fec_pub)->diffForHumans() }}

                    @elseif(!empty($post->created_at))

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
                action="{{ route('posts.destroy', ['post' => $post->id ?? 0]) }}"
                method="POST"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="text-red-500 hover:text-red-700"
                    onclick="return confirm('¿Eliminar publicación?')"
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
    <div class="px-4 pb-3">

        <p class="text-gray-800">
            {{ $post->con_pub ?? 'Sin contenido' }}
        </p>

    </div>

    <!-- IMAGE -->
    @if(!empty($post->img_pub))

        <img
            src="{{ $post->img_pub }}"
            class="w-full object-cover max-h-96"
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

            <span id="likes-{{ $post->id ?? 0 }}">

                {{ $post->likes_count ?? 0 }} likes

            </span>

        </div>

        <div>

            {{ isset($post->comentarios) ? $post->comentarios->count() : 0 }} comments

        </div>

    </div>

    <!-- ACTIONS -->
    <div class="flex border-t border-gray-100">

        <!-- LIKE -->
        <button
            data-id="{{ $post->id ?? 0 }}"
            class="like-btn flex-1 py-2 flex items-center justify-center space-x-2 transition
            {{ !empty($post->liked) ? 'text-red-500' : 'text-gray-500 hover:text-red-500' }}"
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

            <span>Comment</span>

        </button>

        <!-- SHARE -->
        <button
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
        @if(!empty($post->id))

            <form
                action="{{ route('comentarios.store', ['post' => $post->id]) }}"
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

        @endif

        <!-- COMMENTS LIST -->
        @if(isset($post->comentarios) && $post->comentarios->count() > 0)

            @foreach($post->comentarios as $comentario)

                <div class="bg-gray-50 rounded-lg p-3 mb-2">

                    <div class="flex items-center justify-between mb-1">

                        <div class="font-semibold text-sm text-gray-800">

                            {{ $comentario->usuario->nom_us ?? 'Usuario' }}

                        </div>

                        <div class="text-xs text-gray-400">

                            @if(!empty($comentario->created_at))

                                {{ \Carbon\Carbon::parse($comentario->created_at)->diffForHumans() }}

                            @endif

                        </div>

                    </div>

                    <div class="text-sm text-gray-700">

                        {{ $comentario->comentario }}

                    </div>

                </div>

            @endforeach

        @endif

    </div>

</div>
@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-10">

    <!-- HEADER PERFIL -->
    <div class="bg-white rounded-3xl shadow-sm p-8 mb-8">

        <div class="flex flex-col md:flex-row gap-10">

            <!-- AVATAR -->
            <div class="flex justify-center">

                <img
                    src="{{ $user->ava_us
                        ? asset('storage/' . $user->ava_us)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->nom_us) }}"
                    class="w-40 h-40 rounded-full object-cover border-4 border-teal-500 shadow-lg"
                >

            </div>

            <!-- INFO -->
            <div class="flex-1">

                <!-- NOMBRE -->
                <div class="flex flex-col md:flex-row md:items-center gap-4 mb-6">

                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">
                            {{ $user->nom_us }}
                            {{ $user->app_us }}
                        </h1>

                        <p class="text-gray-500">
                            {{ '@' . strtolower($user->nom_us) }}
                        </p>
                    </div>

                    <!-- BOTÓN -->
                    <div>

                        @if(auth()->id() == $user->id)

                            <a
                                href="{{ route('configuracion') }}"
                                class="px-5 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 transition font-medium"
                            >
                                Editar perfil
                            </a>

                        @else

                            <form
                                action="{{ route('seguir.toggle', $user->id) }}"
                                method="POST"
                            >
                                @csrf

                                <button
                                    class="px-6 py-2 rounded-xl font-semibold transition
                                    {{ $siguiendo
                                        ? 'bg-gray-200 hover:bg-gray-300 text-gray-700'
                                        : 'bg-teal-600 hover:bg-teal-700 text-white'
                                    }}"
                                >
                                    {{ $siguiendo ? 'Siguiendo' : 'Seguir' }}
                                </button>

                            </form>

                        @endif

                    </div>

                </div>

                <!-- STATS -->
                <div class="flex gap-8 mb-6">

    <!-- POSTS -->
    <div>
        <span class="font-bold text-xl">
            {{ $postsCount }}
        </span>

        <p class="text-gray-500 text-sm">
            publicaciones
        </p>
    </div>

    <!-- SEGUIDORES -->
    <button
        onclick="openUsersModal('seguidores')"
        class="text-left hover:opacity-70 transition"
    >
        <span class="font-bold text-xl block">
            {{ $seguidoresCount }}
        </span>

        <p class="text-gray-500 text-sm">
            seguidores
        </p>
    </button>

    <!-- SIGUIENDO -->
    <button
        onclick="openUsersModal('siguiendo')"
        class="text-left hover:opacity-70 transition"
    >
        <span class="font-bold text-xl block">
            {{ $siguiendoCount }}
        </span>

        <p class="text-gray-500 text-sm">
            siguiendo
        </p>
    </button>

    <!-- MASCOTAS -->
    <button
        onclick="openUsersModal('mascotas')"
        class="text-left hover:opacity-70 transition"
    >
        <span class="font-bold text-xl block">
            {{ $user->mascotas->count() }}
        </span>

        <p class="text-gray-500 text-sm">
            mascotas
        </p>
    </button>

</div>

                <!-- BIO -->
                <div class="space-y-2">

                    <p class="text-gray-700">
                        🐾 Amante de las mascotas
                    </p>

                    @if($user->ubi_us)

                        <p class="text-gray-500">
                            📍 {{ $user->ubi_us }}
                        </p>

                    @endif

                </div>

            </div>

        </div>

    </div>

    <!-- HISTORIAS DESTACADAS -->
    <div class="bg-white rounded-3xl shadow-sm p-6 mb-8">

        <div class="flex gap-6 overflow-x-auto">

            @foreach(['Mascotas', 'Viajes', 'Adopciones', 'Eventos'] as $story)

                <div class="flex flex-col items-center min-w-[80px]">

                    <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-teal-400 to-teal-600 p-1">

                        <div class="w-full h-full rounded-full bg-white flex items-center justify-center text-2xl">

                            🐾

                        </div>

                    </div>

                    <p class="text-sm mt-2 text-gray-600">
                        {{ $story }}
                    </p>

                </div>

            @endforeach

        </div>

    </div>

    <!-- POSTS -->
    <div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">

            @forelse($posts as $post)

               @php

    $postData = [

    "id" => $post->id,

    "image" => $post->img_pub
        ? asset('storage/' . $post->img_pub)
        : null,

    "description" => $post->com_pub,

    "author_name" => $post->mascota
        ? $post->mascota->nom_mas
        : $user->nom_us,
    "profile_url" => $post->mascota

    ? route('pets.show', $post->mascota->id)

    : route('usuario.profile', $user->id),

    "author_avatar" => $post->mascota && $post->mascota->fot_mas
        ? asset('storage/' . $post->mascota->fot_mas)
        : (
            $user->ava_us
                ? asset('storage/' . $user->ava_us)
                : 'https://ui-avatars.com/api/?name=' . urlencode($user->nom_us)
        ),

    "likes" => $post->likes->count(),

    "liked" => $post->likes
        ->contains('id_usuario', auth()->id()),

    "comments" => $post->comentarios->map(fn($c) => [

        "user" => optional($c->usuario)->nom_us ?? "Usuario",

        "text" => $c->con_com

    ])->values()

];

@endphp

                <div
                    data-post='@json($postData)'
                    onclick="openPostModal(this)"
                    class="group relative overflow-hidden rounded-2xl bg-white shadow-sm cursor-pointer"
                >

                    @if($post->img_pub)

                        <img
                            src="{{ asset('storage/' . $post->img_pub) }}"
                            class="w-full h-80 object-cover group-hover:scale-105 transition duration-300"
                        >

                    @else

                        <div class="h-80 flex items-center justify-center p-6 text-gray-700">

                            {{ $post->com_pub }}

                        </div>

                    @endif

                    <!-- OVERLAY -->
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">

                        <div class="text-white text-center">

                            <p class="font-bold text-lg">
                                ❤️ {{ $post->likes->count() }}
                            </p>

                            <p>
                                💬 {{ $post->comentarios->count() }}
                            </p>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-span-3 bg-white rounded-2xl p-10 text-center text-gray-500">

                    Este usuario todavía no tiene publicaciones.

                </div>

            @endforelse

        </div>

    </div>

</div>

<!-- MODAL -->
<div
    id="postModal"
    class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50 p-4"
>

    <div class="bg-white w-full max-w-5xl rounded-3xl overflow-hidden relative">

        <!-- BOTON CERRAR -->
        <button
            onclick="closePostModal()"
            class="absolute top-4 right-4 z-50 bg-white w-10 h-10 rounded-full shadow"
        >
            ✕
        </button>

        <div class="grid md:grid-cols-2">

            <!-- IMAGEN -->
            <div class="bg-black flex items-center justify-center">

               <img

    id="modalImage"

    src=""

    class="w-full h-[700px] object-cover"

>

<div

    id="modalTextPost"

    class="hidden w-full h-[700px] flex items-center justify-center bg-white text-3xl font-semibold text-gray-700 p-10 text-center"

></div>

            </div>

            <!-- INFO -->
            <div class="flex flex-col h-[700px]">

                <!-- HEADER -->
<div

    id="modalProfileLink"

    class="flex items-center gap-3 p-5 border-b cursor-pointer hover:bg-gray-50 transition"

>
    <img
        id="modalAuthorAvatar"
        src=""
        class="w-12 h-12 rounded-full object-cover"
    >

    <div>

        <h3
            id="modalAuthorName"
            class="font-bold"
        ></h3>

        <p
            id="modalAuthorUsername"
            class="text-sm text-gray-500"
        ></p>

    </div>

</div>

                <!-- CONTENIDO -->
                <div class="flex-1 overflow-y-auto p-5">

                    <p
                        id="modalDescription"
                        class="text-gray-700 mb-6"
                    ></p>

                    <div
                        id="modalComments"
                        class="space-y-4"
                    ></div>

                </div>

                <!-- FOOTER -->

<div class="border-t p-5">

    <div class="flex items-center gap-4">

        <button

            id="modalLikeButton"

            onclick="toggleModalLike()"

            class="text-3xl transition hover:scale-110"

        >

            🤍

        </button>

        <span

            id="modalLikes"

            class="font-semibold"

        ></span>

    </div>

</div>

            </div>

        </div>

    </div>

</div>
<!-- MODAL LISTAS -->
<div
    id="usersModal"
    class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50"
>

    <div class="bg-white w-full max-w-md rounded-3xl overflow-hidden">

        <!-- HEADER -->
        <div class="flex items-center justify-between p-5 border-b">

            <h2
                id="usersModalTitle"
                class="font-bold text-xl"
            ></h2>

            <button
                onclick="closeUsersModal()"
                class="text-2xl"
            >
                ✕
            </button>

        </div>

        <!-- CONTENIDO -->
        <div
            id="usersModalContent"
            class="max-h-[500px] overflow-y-auto"
        ></div>

    </div>

</div>

<script>
    @php

$seguidoresData = $user->seguidores->map(function($u) {

    return [
        'name' => $u->nom_us,
        'avatar' => $u->ava_us
            ? asset('storage/' . $u->ava_us)
            : 'https://ui-avatars.com/api/?name=' . urlencode($u->nom_us),
        'url' => route('usuario.profile', $u->id)
    ];

});

$siguiendoData = $user->siguiendo->map(function($u) {

    return [
        'name' => $u->nom_us,
        'avatar' => $u->ava_us
            ? asset('storage/' . $u->ava_us)
            : 'https://ui-avatars.com/api/?name=' . urlencode($u->nom_us),
        'url' => route('usuario.profile', $u->id)
    ];

});

$mascotasData = $user->mascotas->map(function($m) {

    return [
        'name' => $m->nom_mas,
        'avatar' => $m->fot_mas
            ? asset('storage/' . $m->fot_mas)
            : 'https://ui-avatars.com/api/?name=' . urlencode($m->nom_mas),
        'url' => route('pets.show', $m->id)
    ];

});

@endphp
const seguidoresData = @json($seguidoresData);

const siguiendoData = @json($siguiendoData);

const mascotasData = @json($mascotasData);
    let currentPostId = null;
let liked = false;
function openUsersModal(type)
{
    const modal =
        document.getElementById('usersModal');

    const title =
        document.getElementById('usersModalTitle');

    const content =
        document.getElementById('usersModalContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    let data = [];

    if(type === 'seguidores') {

        title.innerText = 'Seguidores';
        data = seguidoresData;

    }

    if(type === 'siguiendo') {

        title.innerText = 'Siguiendo';
        data = siguiendoData;

    }

    if(type === 'mascotas') {

        title.innerText = 'Mascotas';
        data = mascotasData;

    }

    content.innerHTML = '';

    if(data.length === 0) {

        content.innerHTML = `
            <div class="p-10 text-center text-gray-500">
                No hay resultados
            </div>
        `;

        return;
    }

    data.forEach(item => {

        content.innerHTML += `
            <a
                href="${item.url}"
                class="flex items-center gap-4 p-4 hover:bg-gray-50 transition"
            >

                <img
                    src="${item.avatar}"
                    class="w-14 h-14 rounded-full object-cover"
                >

                <div>

                    <h3 class="font-semibold">
                        ${item.name}
                    </h3>

                </div>

            </a>
        `;

    });
}

function closeUsersModal()
{
    document.getElementById('usersModal')
        .classList.add('hidden');

    document.getElementById('usersModal')
        .classList.remove('flex');
}
function openPostModal(element)
{
    let post = JSON.parse(element.dataset.post);
    currentPostId = post.id;

liked = post.liked ?? false;
document.getElementById('modalAuthorName').innerText =

    post.author_name;

document.getElementById('modalAuthorAvatar').src =

    post.author_avatar;

document.getElementById('modalAuthorUsername').innerText =

    '@' + post.author_name.toLowerCase().replace(/\s+/g, '');
    document.getElementById('modalProfileLink')

    .onclick = () => {

        window.location.href = post.profile_url;

    };

    document.getElementById('postModal')
        .classList.remove('hidden');

    document.getElementById('postModal')
        .classList.add('flex');

    // IMAGEN O TEXTO

const modalImage =

    document.getElementById('modalImage');

const modalTextPost =

    document.getElementById('modalTextPost');

if(post.image)

{

    modalImage.src = post.image;

    modalImage.classList.remove('hidden');

    modalTextPost.classList.add('hidden');

}

else

{

    modalImage.classList.add('hidden');

    modalTextPost.classList.remove('hidden');

    modalTextPost.innerText =

        post.description ?? '';

}

    // DESCRIPCION
    document.getElementById('modalDescription').innerText =
        post.description ?? '';

    // LIKES
    document.getElementById('modalLikes').innerText =
        '❤️ ' + post.likes + ' Me gusta';
        document.getElementById('modalLikeButton').innerText =

    liked ? '❤️' : '🤍';

    // COMENTARIOS
    let commentsContainer =
        document.getElementById('modalComments');

    commentsContainer.innerHTML = '';

    post.comments.forEach(comment => {

        commentsContainer.innerHTML += `
            <div>
                <span class="font-bold">
                    ${comment.user}
                </span>

                <span class="text-gray-700">
                    ${comment.text}
                </span>
            </div>
        `;

    });
}

function closePostModal()
{
    document.getElementById('postModal')
        .classList.add('hidden');

    document.getElementById('postModal')
        .classList.remove('flex');
}
async function toggleModalLike()

{

    if(!currentPostId) return;

    try {

const response = await fetch(

    `/like/${currentPostId}`,

    {

        method: 'POST',

        headers: {

            'X-CSRF-TOKEN':
                document.querySelector('meta[name="csrf-token"]').content,

            'Accept': 'application/json'

        }

    }

);

const data = await response.json();

console.log(data);

liked = data.liked;

document.getElementById('modalLikeButton').innerText =
    liked ? '❤️' : '🤍';

document.getElementById('modalLikes').innerText =
    `❤️ ${data.likes} Me gusta`;
    
    } catch(error) {

        console.error(error);

    }

}
</script>

@endsection
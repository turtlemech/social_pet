<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $destacada->titulo }}</title>

@vite('resources/css/app.css')
</head>

<body class="bg-black overflow-hidden">

<div class="fixed inset-0 flex items-center justify-center bg-black">

    <div class="relative w-full max-w-md h-screen bg-black">

        {{-- BARRAS --}}
        <div class="absolute top-2 left-2 right-2 flex gap-1 z-50">
            @foreach($historias as $index => $historia)
                <div class="flex-1 h-1 bg-white/30 rounded overflow-hidden">
                    <div
                        class="story-progress h-full bg-white"
                        style="width:0%"
                    ></div>
                </div>
            @endforeach
        </div>

        {{-- INFO DESTACADA --}}
        <div class="absolute top-6 left-4 z-50 flex items-center gap-3">

            <div class="w-10 h-10 rounded-full overflow-hidden">

                <img
                    src="{{ $destacada->portada
                        ? asset('storage/'.$destacada->portada)
                        : 'https://ui-avatars.com/api/?name='.urlencode($destacada->titulo)
                    }}"
                    class="w-full h-full object-cover"
                >

            </div>

            <span class="text-white font-semibold">
                {{ $destacada->titulo }}
            </span>

        </div>

        {{-- CERRAR --}}
        <div class="absolute top-6 right-4 z-50 flex gap-3">

    @if(auth()->id() == $destacada->usuario_id)

    <form
        action="{{ route('historias.destacadas.destroy', $destacada->id) }}"
        method="POST"
        onsubmit="return confirm('¿Eliminar esta historia destacada?')"
    >
        @csrf
        @method('DELETE')

        <button
            type="submit"
            class="w-10 h-10 rounded-full bg-red-500 text-white text-xl hover:bg-red-600"
        >
            🗑
        </button>
    </form>

    @endif

    <button
        onclick="window.history.back()"
        class="w-10 h-10 rounded-full bg-black/40 text-white text-3xl"
    >
        ×
    </button>

</div>

        {{-- HISTORIAS --}}
        @foreach($historias as $index => $historia)

        <div
            class="story-slide absolute inset-0 {{ $index === 0 ? '' : 'hidden' }}"
        >

            @if($historia->tipo === 'video')

                <video
                    class="story-video w-full h-full object-cover"
                    src="{{ asset('storage/'.$historia->media) }}"
                    playsinline
                    muted
                    autoplay
                ></video>

            @else

                <img
                    src="{{ asset('storage/'.$historia->media) }}"
                    class="w-full h-full object-cover"
                >

            @endif

            {{-- ELEMENTOS --}}
            @if($historia->elementos)

                @php
                    $elementos = is_array($historia->elementos)
                        ? $historia->elementos
                        : json_decode($historia->elementos, true);
                @endphp

                @foreach($elementos ?? [] as $elemento)

                <div
                    class="{{ $elemento['className'] ?? '' }}"
                    style="
                        position:absolute;
                        left:{{ $elemento['left'] }};
                        top:{{ $elemento['top'] }};
                        z-index:9999;
                    "
                >
                    {{ $elemento['text'] }}
                </div>

                @endforeach

            @endif

            {{-- MÚSICA --}}
            @if($historia->musica)

            <div class="absolute bottom-28 left-4 z-50">

                <div class="bg-black/60 backdrop-blur px-3 py-2 rounded-full text-white text-sm">

                    🎵 {{ $historia->musica }}

                </div>

            </div>

            @endif

            {{-- DESCRIPCIÓN --}}
            @if($historia->descripcion)

            <div class="absolute bottom-8 left-4 right-4 z-50">

                <div class="bg-black/50 backdrop-blur rounded-xl p-3 text-white">

                    {{ $historia->descripcion }}

                </div>

            </div>

            @endif

        </div>

        @endforeach

        {{-- TAP IZQUIERDA --}}
        <div
            id="prevArea"
            class="absolute left-0 top-0 w-1/2 h-full z-40"
        ></div>

        {{-- TAP DERECHA --}}
        <div
            id="nextArea"
            class="absolute right-0 top-0 w-1/2 h-full z-40"
        ></div>

    </div>

</div>

<script>

const slides =
    document.querySelectorAll('.story-slide');

const progressBars =
    document.querySelectorAll('.story-progress');

const videos =
    document.querySelectorAll('.story-video');

let current = 0;

function showStory(index)
{
    if(index < 0) return;

    if(index >= slides.length)
    {
        window.history.back();
        return;
    }

    slides.forEach(s => s.classList.add('hidden'));

    slides[index].classList.remove('hidden');

    current = index;

    progressBars.forEach((bar,i)=>{

        if(i < index){

            bar.style.width = '100%';

        }else{

            bar.style.width = '0%';

        }

    });

    startProgress();

    videos.forEach(v=>{

        v.pause();
        v.currentTime = 0;

    });

    const video =
        slides[index].querySelector('video');

    if(video){

        video.play();

        video.onended = () => {

            showStory(current + 1);

        };

    }
}

let timer;

function startProgress()
{
    clearInterval(timer);

    let width = 0;

    timer = setInterval(()=>{

        width += 2;

        progressBars[current].style.width =
            width + '%';

        if(width >= 100){

            clearInterval(timer);

            const video =
                slides[current]
                .querySelector('video');

            if(!video){

                showStory(current + 1);

            }

        }

    },100);
}

document
.getElementById('nextArea')
.addEventListener('click',()=>{

    showStory(current + 1);

});

document
.getElementById('prevArea')
.addEventListener('click',()=>{

    showStory(current - 1);

});

showStory(0);

</script>

</body>
</html>
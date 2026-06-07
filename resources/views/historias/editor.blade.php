<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editor de historia</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-black text-white h-screen overflow-hidden">

<div class="relative h-screen bg-black overflow-hidden">

    <div class="absolute inset-0 flex items-center justify-center px-4">
        <div class="relative w-full max-w-[420px] aspect-[9/16] mx-auto">

            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/90 pointer-events-none"></div>

            <div class="relative w-full h-full rounded-[36px] overflow-hidden bg-black border border-white/10">
                @if($tipo === 'video')
                    <video id="storyMedia" src="{{ $media }}" class="w-full h-full object-cover" autoplay loop muted playsinline></video>
                @else
                    <img id="storyMedia" src="{{ $media }}" class="w-full h-full object-cover" alt="Historia">
                @endif

                <div id="overlayLayer" class="absolute inset-0"></div>
                <div id="descriptionOverlay" class="hidden absolute left-4 right-4 bottom-24 max-w-[calc(100%-2rem)] rounded-3xl bg-black/70 border border-white/10 p-3 text-sm text-white shadow-lg backdrop-blur-sm"></div>
            </div>

        </div>

        @php
            $spotifyConnected = auth()->check() && \App\Models\SpotifyToken::where('user_id', auth()->id())->exists();
        @endphp
    </div>

    <!-- TOP (mobile): centered header and progress dots (kept for small screens) -->
    <div class="absolute inset-x-0 top-2 px-4 pt-2 z-30 md:hidden">
        <div class="flex items-center justify-between mb-2">
            <button onclick="discardStory()" class="rounded-full bg-black/50 border border-white/10 px-3 py-2 text-sm text-white/90 hover:bg-white/10 transition">
                ← Salir
            </button>
            <div class="flex items-center gap-2">
                <span class="h-2 w-12 rounded-full bg-white/30"></span>
                <span class="h-2 w-10 rounded-full bg-white/30"></span>
                <span class="h-2 w-8 rounded-full bg-white/30"></span>
                <span class="h-2 w-4 rounded-full bg-white/80"></span>
            </div>
            <button type="submit" form="shareForm" class="rounded-full bg-white px-3 py-2 text-sm font-semibold text-black hover:bg-white/90 transition">Compartir</button>
        </div>

        <div class="flex items-center justify-between px-2 py-3 rounded-full bg-black/40 border border-white/10">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-white/10 border border-white/10 flex items-center justify-center text-white text-sm">Tu</div>
                <div>
                    <p class="text-sm font-semibold text-white">Tu historia</p>
                    <p class="text-xs text-gray-300">Toca para editar</p>
                </div>
            </div>
            <div class="text-xs text-gray-300">1/1</div>
        </div>
    </div>

    <!-- RIGHT HEADER (desktop): close + share -->
    <div class="hidden md:flex flex-col items-end absolute right-4 top-4 z-30 space-y-3">
        <button onclick="discardStory()" class="rounded-full bg-black/60 border border-white/10 px-4 py-2 text-sm text-white/90 hover:bg-white/10 transition">← Salir</button>
        <button type="submit" form="shareForm" class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-black hover:bg-white/90 transition">Compartir</button>
    </div>

    <!-- LEFT PANEL (desktop): vertical action menu -->
    <div class="hidden md:flex flex-col items-start absolute left-4 top-24 z-30 space-y-3">
        <button onclick="addText()" class="flex items-center justify-between gap-3 rounded-full bg-white/10 border border-white/10 px-4 py-3 text-sm text-white hover:bg-white/15 transition w-48"><span>Texto</span><span class="text-lg">Aa</span></button>
        <button onclick="openStickers()" class="flex items-center justify-between gap-3 rounded-full bg-white/10 border border-white/10 px-4 py-3 text-sm text-white hover:bg-white/15 transition w-48"><span>Stickers</span><span class="text-lg">😊</span></button>
        <button onclick="openMusicModal()" class="flex items-center justify-between gap-3 rounded-full bg-white/10 border border-white/10 px-4 py-3 text-sm text-white hover:bg-white/15 transition w-48"><span>Música</span><span class="text-lg">🎵</span></button>
        <button onclick="openEffects()" class="flex items-center justify-between gap-3 rounded-full bg-white/10 border border-white/10 px-4 py-3 text-sm text-white hover:bg-white/15 transition w-48"><span>Efectos</span><span class="text-lg">✨</span></button>
        <button onclick="addMention()" class="flex items-center justify-between gap-3 rounded-full bg-white/10 border border-white/10 px-4 py-3 text-sm text-white hover:bg-white/15 transition w-48"><span>Mencionar</span><span class="text-lg">@</span></button>
        <button onclick="addTime()" class="flex items-center justify-between gap-3 rounded-full bg-white/10 border border-white/10 px-4 py-3 text-sm text-white hover:bg-white/15 transition w-48"><span>Añadir hora</span><span class="text-lg">⏱</span></button>
        <button id="highlightButton" onclick="toggleHighlight()" class="flex items-center justify-between gap-3 rounded-full bg-white/10 border border-white/10 px-4 py-3 text-sm text-white hover:bg-white/15 transition w-48"><span>Destacar</span><span class="text-lg">⭐</span></button>
        <button onclick="discardStory()" class="flex items-center justify-between gap-3 rounded-full bg-red-500/20 border border-red-500/30 px-4 py-3 text-sm text-white hover:bg-red-500/30 transition w-48"><span>Descartar</span><span class="text-lg">🗑</span></button>

    </div>

    <div id="musicStatusBubble" class="absolute bottom-32 left-4 z-30 hidden rounded-full bg-black/75 px-4 py-2 text-xs text-white shadow-lg backdrop-blur-sm"></div>

    <!-- BOTTOM DESCRIPTION -->
    <div class="absolute inset-x-0 bottom-0 px-4 pb-6 z-30">
        <div class="absolute inset-x-0 bottom-0 px-4 pb-5 z-30">
    <div class="max-w-md mx-auto">
        <textarea
            id="storyDescription"
            placeholder="Escribe algo..."
            rows="1"
            class="w-full h-12 resize-none rounded-full
                   bg-black/70 backdrop-blur-xl
                   border border-white/10
                   px-5 py-3
                   text-sm text-white
                   placeholder:text-gray-400
                   focus:outline-none
                   focus:ring-2 focus:ring-cyan-500
                   overflow-hidden">
        </textarea>
    </div>
</div>
    </div>

    <audio id="storyAudio" class="hidden fixed bottom-4 left-1/2 z-50 w-[calc(100%-2rem)] max-w-2xl -translate-x-1/2 rounded-3xl bg-black/80 p-3 shadow-2xl" controls></audio>

    <form id="shareForm" action="{{ route('historias.guardarFinal') }}" method="POST" class="hidden">
        @csrf
        
        <input type="hidden" name="media_path" value="{{ $rutaMedia }}">
        <input type="hidden" name="tipo" value="{{ $tipo }}">
        <input type="hidden" name="elementos" id="elementsInput">
        <input type="hidden" name="musica" id="musicInput">
        <input type="hidden" name="spotify_id" id="spotifyId">

<input type="hidden" name="musica_titulo" id="musicTitle">

<input type="hidden" name="musica_artista" id="musicArtist">

<input type="hidden" name="musica_portada" id="musicCover">

<input type="hidden" name="musica_preview" id="musicPreview">
        <input type="hidden" name="texto_alternativo" id="altText">
        <input type="hidden" name="descripcion" id="descriptionInput">
        <input type="hidden" name="es_destacada" id="isHighlightedInput" value="0">
    </form>

</div>

<!-- MUSIC MODAL -->
<div id="musicModal" class="hidden fixed inset-0 bg-black/90 flex items-center justify-center z-50 px-4">
<div class="w-full max-w-2xl bg-[#0f1418] rounded-3xl shadow-2xl border border-white/10 flex flex-col h-[85vh]">
    

        <div class="p-4 border-b border-white/10 bg-[#11181d]">
            <div class="mb-4 flex items-center gap-3">
                <button onclick="closeMusicModal()" class="rounded-full bg-white/10 px-3 py-2 text-xs text-white/80 hover:bg-white/15">Cancelar</button>
                <input id="musicSearch" placeholder="Buscar..." class="flex-1 bg-[#19212a] rounded-full px-4 py-3 text-sm text-white placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                <button onclick="searchSpotify()" class="rounded-full bg-cyan-500 px-4 py-3 text-sm font-semibold text-white hover:bg-cyan-400">Buscar</button>
                @auth
                    @unless($spotifyConnected)
                        <div class="ml-2">
                            <a href="{{ route('spotify.authorize') }}" class="inline-block rounded-full bg-[#1DB954] hover:bg-green-500 px-3 py-2 text-xs font-semibold text-black">Conectar Spotify</a>
                        </div>
                    @endunless
                @endauth
            </div>
            <div class="flex gap-2 overflow-x-auto pb-1">
                <button onclick="setMusicTab('Para ti')" id="tab-Para ti" class="rounded-full bg-white/10 px-4 py-2 text-xs text-white/80">Para ti</button>
                <button onclick="setMusicTab('Tendencias')" id="tab-Tendencias" class="rounded-full bg-white/10 px-4 py-2 text-xs text-white/80">Tendencias</button>
                <button onclick="setMusicTab('Guardada')" id="tab-Guardada" class="rounded-full bg-white/10 px-4 py-2 text-xs text-white/80">Guardada</button>
                <button onclick="setMusicTab('Audio original')" id="tab-Audio original" class="rounded-full bg-white/10 px-4 py-2 text-xs text-white/80">Audio original</button>
            </div>
        </div>

        <div id="musicList" class="h-full overflow-y-auto p-4 space-y-3"></div>

        <div class="p-3 border-t border-white/10 bg-[#11181d]">
            <button onclick="closeMusicModal()" class="w-full rounded-full bg-white/10 px-4 py-3 text-sm text-white hover:bg-white/15">Cerrar</button>
        </div>

    </div>
</div>

<!-- NOW PLAYING INDICATOR -->
<div id="nowPlaying" class="hidden fixed bottom-20 left-4 bg-green-600 text-white p-3 rounded-lg text-sm z-40">
    ▶️ Reproduciendo...
</div>

<script>

const overlay = document.getElementById('overlayLayer');
const descriptionOverlay = document.getElementById('descriptionOverlay');
const storyDescription = document.getElementById('storyDescription');
const storyMedia = document.getElementById('storyMedia');
const audio = document.getElementById('storyAudio');
const musicStatusBubble = document.getElementById('musicStatusBubble');
const musicTabs = ['Para ti', 'Tendencias', 'Guardada', 'Audio original'];
let activeMusicTab = 'Guardada';
let selectedMusic = null;
let isHighlighted = false;
let scale = 1;
let rotation = 0;

function showAudioPlayer() {
    if (!audio) return;
    audio.classList.remove('hidden');
}

function playAudioPreview(song) {
    if (!audio || !song) return;

    const previewUrl = song.preview || song.preview_url;

    if (!previewUrl) {
        console.warn('Esta canción no tiene preview:', song);
        showStatusBubble('⚠️ Esta canción no tiene preview de audio en Spotify');
        return;
    }

    audio.src = previewUrl;
    audio.load();

    audio.play()
        .then(() => {
            showAudioPlayer();
            updateMusicStatus(song);
        })
        .catch(err => {
            console.error('Error reproduciendo audio:', err);
            showStatusBubble('❌ No se pudo reproducir el audio');
        });
}

function applyTransform(){
    if (storyMedia) {
        storyMedia.style.transform = `scale(${scale}) rotate(${rotation}deg)`;
    }
}
function zoomIn(){ scale = Math.min(scale + 0.1, 3); applyTransform(); }
function zoomOut(){ scale = Math.max(scale - 0.1, 1); applyTransform(); }
function rotateImage(){ rotation += 90; applyTransform(); }

function makeDraggable(el){
    let isDragging = false;
    let offsetX = 0;
    let offsetY = 0;

    el.style.position = 'absolute';
    el.style.cursor = 'grab';

    el.addEventListener('mousedown', (e) => {
        isDragging = true;
        offsetX = e.clientX - el.getBoundingClientRect().left;
        offsetY = e.clientY - el.getBoundingClientRect().top;
        el.style.cursor = 'grabbing';
    });

    document.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        const parent = overlay.getBoundingClientRect();
        let x = e.clientX - parent.left - offsetX;
        let y = e.clientY - parent.top - offsetY;
        el.style.left = x + 'px';
        el.style.top = y + 'px';
    });

    document.addEventListener('mouseup', () => {
        isDragging = false;
        el.style.cursor = 'grab';
    });
}

function addText(){

    const modal = document.createElement('div');

    modal.className =
    'fixed inset-0 bg-black/80 flex items-center justify-center z-[9999]';

   modal.innerHTML = `
    <div class="bg-[#11181d] rounded-3xl p-6 w-[500px] max-w-[95vw]">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-white text-xl font-bold">
                Agregar texto
            </h2>

            <button
                id="closeTextModal"
                class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-red-500 text-white transition">
                ✕
            </button>
        </div>
            <textarea
                id="storyTextInput"
                placeholder="Escribe algo..."
                class="w-full h-32 bg-black/40 border border-white/10 rounded-2xl p-4 text-white resize-none"
            ></textarea>

            <div class="flex gap-3 mt-4">

                <button
                    data-color="white"
                    class="color-btn w-10 h-10 rounded-full bg-white border">
                </button>

                <button
                    data-color="#22d3ee"
                    class="color-btn w-10 h-10 rounded-full bg-cyan-400">
                </button>

                <button
                    data-color="#facc15"
                    class="color-btn w-10 h-10 rounded-full bg-yellow-400">
                </button>

                <button
                    data-color="#f43f5e"
                    class="color-btn w-10 h-10 rounded-full bg-rose-500">
                </button>

            </div>

            <button
                id="addTextButton"
                class="mt-5 w-full bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-3 rounded-2xl">
                Agregar
            </button>

        </div>
    `;

    document.body.appendChild(modal);

modal.querySelector('#closeTextModal').onclick = () => {

    modal.remove();

};

let selectedColor = 'white';

    modal.querySelectorAll('.color-btn').forEach(btn => {

        btn.onclick = () => {
            selectedColor = btn.dataset.color;
        };

    });

    modal.querySelector('#addTextButton').onclick = () => {

        const text =
            modal.querySelector('#storyTextInput').value.trim();

        if(!text) return;

        const div =
            document.createElement('div');

        div.innerText = text;

        div.className =
        "absolute text-5xl font-black px-3 py-2 leading-tight";
        div.style.maxWidth = '300px';

div.style.wordBreak = 'break-word';

        div.style.color =
            selectedColor;

        div.style.textShadow =
        "0 4px 20px rgba(0,0,0,.85)";

        div.style.left = '80px';
        div.style.top = '150px';

        div.contentEditable = true;

        makeDraggable(div);

        overlay.appendChild(div);

        modal.remove();

        showStatusBubble('✅ Texto agregado');
    };

    modal.addEventListener('click', e => {

        if(e.target === modal){
            modal.remove();
        }

    });
}
let clockElement = null;
let clockInterval = null;

function addTime(){

    if(clockElement){

        clearInterval(clockInterval);

        clockElement.remove();

        clockElement = null;

        showStatusBubble('⏱ Hora eliminada');

        return;
    }

    const div = document.createElement('div');

    div.className =
    "text-white bg-black/50 px-3 py-1 rounded text-sm";

    function update(){
        div.innerText = new Date().toLocaleTimeString('es-ES',{
            hour:'2-digit',
            minute:'2-digit'
        });
    }

    update();

    clockInterval =
        setInterval(update,1000);

    div.style.left = "40px";
    div.style.top = "120px";

    makeDraggable(div);

    overlay.appendChild(div);

    clockElement = div;

    showStatusBubble('⏱ Hora agregada');
}

let musicData = {
    for_you: [],
    trending: [],
    saved: [],
    recommendations: [],
    original: []
};
let musicPlaylist = [];
let currentSongList = [];
let selectedSongInfo = null;
const musicTabKeyMap = {
    'Para ti': 'for_you',
    'Tendencias': 'trending',
    'Guardada': 'saved',
    'Audio original': 'original'
};

async function openMusicModal(){
    document.getElementById('musicModal').classList.remove('hidden');

    await loadMusicList();

    currentSongList = musicData[musicTabKeyMap[activeMusicTab]] || [];

    console.log('activeMusicTab:', activeMusicTab);
    console.log('musicTabKeyMap:', musicTabKeyMap[activeMusicTab]);
    console.log('currentSongList:', currentSongList);

    renderSongs(currentSongList);
    highlightActiveTab();
}

function closeMusicModal(){
    document.getElementById('musicModal').classList.add('hidden');
}

async function loadMusicList(){
    if(musicPlaylist.length > 0) return;

    try {
        const response = await fetch('/music');

        if(!response.ok) throw new Error('No se pudo cargar la lista de música');
        const data = await response.json();
        musicData = {
            for_you: data.for_you || [],
            trending: data.trending || [],
            saved: data.saved || [],
            recommendations: data.recommendations || [],
            original: data.original || []
        };
        console.log('Spotify data:', musicData);

        musicPlaylist = [...musicData.for_you, ...musicData.trending, ...musicData.saved, ...musicData.original];
    } catch (error) {
        console.warn(error);
        musicPlaylist = [
            { id: 1, title: 'Baby', artist: 'Justin Bieber', category: 'Para ti', preview: 'https://p.scdn.co/mp3-preview/c87c97e69fd9eae31e0cc9c0c63d04c087f6cf5a', cover: '', file: '/music/baby.mp3' },
            { id: 2, title: 'Peaches', artist: 'Justin Bieber', category: 'Tendencias', preview: 'https://p.scdn.co/mp3-preview/a87c97e69fd9eae31e0cc9c0c63d04c087f6cf5a', cover: '', file: '/music/peaches.mp3' },
            { id: 3, title: 'Stay', artist: 'The Kid LAROI, Justin Bieber', category: 'Guardada', preview: 'https://p.scdn.co/mp3-preview/b87c97e69fd9eae31e0cc9c0c63d04c087f6cf5a', cover: '', file: '/music/stay.mp3' }
        ];
        musicData = {
            for_you: musicPlaylist.filter(song => song.category === 'Para ti'),
            trending: musicPlaylist.filter(song => song.category === 'Tendencias'),
            saved: musicPlaylist.filter(song => song.category === 'Guardada'),
            recommendations: musicPlaylist.filter(song => song.category === 'Para ti'),
            original: []
        };
    }
}

function setMusicTab(tab){
    activeMusicTab = tab;
    highlightActiveTab();
    currentSongList = musicData[musicTabKeyMap[tab]] || [];
    if(currentSongList.length === 0) {
        currentSongList = musicPlaylist;
    }
    renderSongs(currentSongList);
}

function highlightActiveTab(){
    musicTabs.forEach(tab => {
        const button = document.getElementById(`tab-${tab}`);
        if (!button) return;
        button.classList.toggle('bg-cyan-500', tab === activeMusicTab);
        button.classList.toggle('text-white', tab === activeMusicTab);
        button.classList.toggle('bg-white/10', tab !== activeMusicTab);
        button.classList.toggle('text-white/80', tab !== activeMusicTab);
    });
}

function filterSongsByTab(list, tab){
    if(tab === 'Audio original') return list.filter(song => song.category === 'Audio original');
    if(tab === 'Guardada') return list.filter(song => song.category === 'Guardada');
    if(tab === 'Tendencias') return list.filter(song => song.category === 'Tendencias');
    return list;
}

async function searchSpotify(){
    const searchTerm = document.getElementById('musicSearch').value.trim();
    if(searchTerm.length < 2) {
        currentSongList = musicData[musicTabKeyMap[activeMusicTab]] || [];
        renderSongs(currentSongList);
        return;
    }

    try {
        const response = await fetch(`/music/search?q=${encodeURIComponent(searchTerm)}`);
        const results = await response.json();

        if ((results.tracks && results.tracks.length) || (results.artists && results.artists.length) || (results.albums && results.albums.length) || (results.playlists && results.playlists.length)) {
            renderSearchResults(results);
            return;
        }

        renderEmptyMessage('No se encontraron resultados para "' + searchTerm + '"');
    } catch (error) {
        console.error('Error buscando en Spotify:', error);
        renderEmptyMessage('Error buscando en Spotify');
    }
}

function renderSongs(list){
    console.log('renderSongs recibió:', list);

    currentSongList = list;

    const box = document.getElementById('musicList');
    console.log('musicList element:', box);

    box.innerHTML = '';

    if(!Array.isArray(list) || list.length === 0){
        box.innerHTML = '<div class="col-span-2 text-center text-gray-400 py-8">No se encontraron canciones</div>';
        return;
    }

    console.log('Cantidad de canciones:', list.length);

    list.forEach(song => {
        console.log('Canción:', song);

        const div = document.createElement('div');
        div.className = "bg-[#11181d] hover:bg-[#1f2937] rounded-3xl p-4 flex items-center gap-4 transition border border-transparent";

        if(selectedSongInfo && String(selectedSongInfo.id) === String(song.id)) {
            div.classList.add('border-cyan-500/60');
        }

        const coverEl = document.createElement('div');
        coverEl.className = 'h-16 w-16 rounded-2xl overflow-hidden flex items-center justify-center bg-cyan-500/10';

        if(song.cover) {
            const img = document.createElement('img');
            img.src = song.cover;
            img.alt = 'cover';
            img.className = 'h-16 w-16 rounded-2xl object-cover';
            coverEl.appendChild(img);
        } else {
            coverEl.innerHTML = '🎵';
        }

        const info = document.createElement('div');
        info.className = 'flex-1 min-w-0';
        info.innerHTML = `
            <p class="font-semibold text-white truncate">${song.title}</p>
            <p class="text-gray-400 text-xs truncate">${song.artist}</p>
            <p class="text-[11px] uppercase tracking-[0.25em] text-cyan-400 mt-1">
                ${song.category || 'Spotify'}
            </p>
        `;

        const actions = document.createElement('div');
        actions.className = 'flex flex-col gap-2';

        const previewBtn = document.createElement('button');
        previewBtn.type = 'button';
        previewBtn.className = 'rounded-full border border-white/10 bg-white/5 text-white text-sm px-3 py-2 hover:bg-white/10 transition';
        previewBtn.textContent = 'Reproducir';

        previewBtn.addEventListener('click', event => {
            event.stopPropagation();
            previewMusic(song, event);
        });

        const selectBtn = document.createElement('button');
        selectBtn.type = 'button';
        selectBtn.className = 'rounded-full bg-cyan-500 text-black text-sm px-3 py-2 hover:bg-cyan-400 transition';
        selectBtn.textContent = 'Seleccionar';

        selectBtn.addEventListener('click', event => {
            event.stopPropagation();
            selectMusic(song.id);
        });

        actions.appendChild(previewBtn);
        actions.appendChild(selectBtn);

        div.appendChild(coverEl);
        div.appendChild(info);
        div.appendChild(actions);

        box.appendChild(div);
    });
}

function renderSearchResults(results){
    const box = document.getElementById('musicList');
    box.innerHTML = '';

    if(results.tracks && results.tracks.length){
        box.appendChild(renderSectionHeader('Canciones'));
        results.tracks.forEach(track => box.appendChild(renderTrackCard(track)));
    }

    if(results.artists && results.artists.length){
        box.appendChild(renderSectionHeader('Artistas'));
        results.artists.forEach(artist => box.appendChild(renderArtistCard(artist)));
    }

    if(results.albums && results.albums.length){
        box.appendChild(renderSectionHeader('Álbumes'));
        results.albums.forEach(album => box.appendChild(renderAlbumCard(album)));
    }

    if(results.playlists && results.playlists.length){
        box.appendChild(renderSectionHeader('Playlists'));
        results.playlists.forEach(playlist => box.appendChild(renderPlaylistCard(playlist)));
    }

    if(
        (!results.tracks || !results.tracks.length) &&
        (!results.artists || !results.artists.length) &&
        (!results.albums || !results.albums.length) &&
        (!results.playlists || !results.playlists.length)
    ){
        box.innerHTML = '<div class="col-span-2 text-center text-gray-400 py-8">No se encontraron resultados</div>';
    }
}

function renderSectionHeader(title){
    const header = document.createElement('div');
    header.className = 'text-white text-xs uppercase tracking-[0.3em] text-cyan-400 mt-4 mb-2';
    header.innerText = title;
    return header;
}

function renderTrackCard(song){
    const card = document.createElement('div');
    card.className = "bg-[#11181d] hover:bg-[#1f2937] rounded-3xl p-4 flex items-center gap-4 transition border border-transparent";

    const coverEl = document.createElement('div');
    coverEl.className = 'h-16 w-16 rounded-2xl overflow-hidden flex items-center justify-center bg-cyan-500/10';
    if(song.cover) {
        const img = document.createElement('img');
        img.src = song.cover;
        img.alt = 'cover';
        img.className = 'h-16 w-16 rounded-2xl object-cover';
        coverEl.appendChild(img);
    } else {
        coverEl.innerHTML = '🎵';
    }

    const info = document.createElement('div');
    info.className = 'flex-1 min-w-0';
    info.innerHTML = `
        <p class="font-semibold text-white truncate">${song.title}</p>
        <p class="text-gray-400 text-xs truncate">${song.artist}</p>
        <p class="text-[11px] uppercase tracking-[0.25em] text-cyan-400 mt-1">${song.category || 'Spotify'}</p>
    `;

    const actions = document.createElement('div');
    actions.className = 'flex flex-col gap-2';

    const previewBtn = document.createElement('button');
    previewBtn.type = 'button';
    previewBtn.className = 'rounded-full border border-white/10 bg-white/5 text-white text-sm px-3 py-2 hover:bg-white/10 transition';
    previewBtn.textContent = 'Reproducir';
    previewBtn.addEventListener('click', event => {
        event.stopPropagation();
        previewMusic(song, event);
    });

    const selectBtn = document.createElement('button');
    selectBtn.type = 'button';
    selectBtn.className = 'rounded-full bg-cyan-500 text-black text-sm px-3 py-2 hover:bg-cyan-400 transition';
    selectBtn.textContent = 'Seleccionar';
    selectBtn.addEventListener('click', event => {
        event.stopPropagation();
        selectMusic(song.id);
    });

    actions.appendChild(previewBtn);
    actions.appendChild(selectBtn);

    card.appendChild(coverEl);
    card.appendChild(info);
    card.appendChild(actions);
    return card;
}

function renderArtistCard(artist){
    const card = document.createElement('div');
    card.className = 'bg-[#11181d] hover:bg-[#1f2937] rounded-3xl p-4 flex items-center gap-4 transition border border-transparent cursor-pointer';
    card.addEventListener('click', () => searchSpotifyByQuery(artist.name));

    const coverEl = document.createElement('div');
    coverEl.className = 'h-16 w-16 rounded-2xl overflow-hidden flex items-center justify-center bg-cyan-500/10';
    if(artist.image){
        const img = document.createElement('img');
        img.src = artist.image;
        img.alt = 'artist';
        img.className = 'h-16 w-16 rounded-2xl object-cover';
        coverEl.appendChild(img);
    } else {
        coverEl.innerHTML = '🎤';
    }

    const info = document.createElement('div');
    info.className = 'flex-1 min-w-0';
    info.innerHTML = `
        <p class="font-semibold text-white truncate">${artist.name}</p>
        <p class="text-gray-400 text-xs truncate">Artista</p>
    `;

    card.appendChild(coverEl);
    card.appendChild(info);
    return card;
}

function renderAlbumCard(album){
    const card = document.createElement('div');
    card.className = 'bg-[#11181d] hover:bg-[#1f2937] rounded-3xl p-4 flex items-center gap-4 transition border border-transparent cursor-pointer';
    card.addEventListener('click', () => searchSpotifyByQuery(album.name + ' ' + album.artist));

    const coverEl = document.createElement('div');
    coverEl.className = 'h-16 w-16 rounded-2xl overflow-hidden flex items-center justify-center bg-cyan-500/10';
    if(album.cover){
        const img = document.createElement('img');
        img.src = album.cover;
        img.alt = 'album';
        img.className = 'h-16 w-16 rounded-2xl object-cover';
        coverEl.appendChild(img);
    } else {
        coverEl.innerHTML = '💿';
    }

    const info = document.createElement('div');
    info.className = 'flex-1 min-w-0';
    info.innerHTML = `
        <p class="font-semibold text-white truncate">${album.name}</p>
        <p class="text-gray-400 text-xs truncate">${album.artist}</p>
    `;

    card.appendChild(coverEl);
    card.appendChild(info);
    return card;
}

function renderPlaylistCard(playlist){
    const card = document.createElement('div');
    card.className = 'bg-[#11181d] hover:bg-[#1f2937] rounded-3xl p-4 flex items-center gap-4 transition border border-transparent';

    const coverEl = document.createElement('div');
    coverEl.className = 'h-16 w-16 rounded-2xl overflow-hidden flex items-center justify-center bg-cyan-500/10';
    if(playlist.cover){
        const img = document.createElement('img');
        img.src = playlist.cover;
        img.alt = 'playlist';
        img.className = 'h-16 w-16 rounded-2xl object-cover';
        coverEl.appendChild(img);
    } else {
        coverEl.innerHTML = '📻';
    }

    const info = document.createElement('div');
    info.className = 'flex-1 min-w-0';
    info.innerHTML = `
        <p class="font-semibold text-white truncate">${playlist.name}</p>
        <p class="text-gray-400 text-xs truncate">${playlist.owner} · ${playlist.tracks_total} canciones</p>
    `;

    card.appendChild(coverEl);
    card.appendChild(info);
    return card;
}

function searchSpotifyByQuery(query){
    document.getElementById('musicSearch').value = query;
    searchSpotify();
}

function renderEmptyMessage(message){
    const box = document.getElementById('musicList');
    box.innerHTML = `<div class="col-span-2 text-center text-gray-400 py-8">${message}</div>`;
}

function previewMusic(song, event){
    event.stopPropagation();
    if (!song) return;

    if (song.preview) {
        playAudioPreview(song);
    } else {
        showStatusBubble('No hay preview disponible para esta canción');
    }
}

function selectMusic(songId){
    const song = currentSongList.find(s => String(s.id) === String(songId)) || musicPlaylist.find(s => String(s.id) === String(songId));
    if(!song) return;

    selectedMusic = JSON.stringify({
    id: song.id,
    title: song.title,
    artist: song.artist,
    cover: song.cover,
    preview: song.preview
});
    selectedSongInfo = song;
    document.getElementById('spotifyId').value = song.id ?? '';
document.getElementById('musicTitle').value = song.title ?? '';
document.getElementById('musicArtist').value = song.artist ?? '';
document.getElementById('musicCover').value = song.cover ?? '';
document.getElementById('musicPreview').value = song.preview ?? '';

    if(song.preview){
        playAudioPreview(song);
    }

    closeMusicModal();
updateMusicStatus(song);

document.querySelectorAll('.music-sticker')
    .forEach(el => el.remove());

const sticker = document.createElement('div');

sticker.className =
'music-sticker absolute bg-black/70 text-white px-4 py-2 rounded-xl text-sm';

sticker.innerText =
`🎵 ${song.title}\n${song.artist}`;

sticker.style.left = '50px';
sticker.style.top = '80px';

makeDraggable(sticker);

overlay.appendChild(sticker);
}

function updateMusicStatus(song){
    if (!musicStatusBubble) return;

    if(song){
        musicStatusBubble.innerText = `🎵 ${song.title} - ${song.artist}`;
        musicStatusBubble.classList.remove('hidden');
    } else {
        musicStatusBubble.innerText = 'Sin música seleccionada';
        musicStatusBubble.classList.remove('hidden');
    }
}

function clearMusicStatus(){
    if (!musicStatusBubble) return;
    musicStatusBubble.classList.add('hidden');
}

function syncDescriptionOverlay(){
    const value = storyDescription.value.trim();
    document.getElementById('descriptionInput').value = value;

    if (!value){
        descriptionOverlay.classList.add('hidden');
        return;
    }

    descriptionOverlay.innerText = value;
    descriptionOverlay.classList.remove('hidden');
}

storyDescription.addEventListener('focus', () => {
    syncDescriptionOverlay();
});

storyDescription.addEventListener('input', () => {
    syncDescriptionOverlay();
});

storyDescription.addEventListener('blur', () => {
    if (!storyDescription.value.trim()) {
        descriptionOverlay.classList.add('hidden');
    }
});

function toggleHighlight(){
    isHighlighted = !isHighlighted;
    const highlightInput = document.getElementById('isHighlightedInput');
    const button = document.getElementById('highlightButton');

    if (highlightInput) {
        highlightInput.value = isHighlighted ? '1' : '0';
    }

    button.classList.toggle('bg-yellow-500', isHighlighted);
    button.classList.toggle('hover:bg-yellow-600', isHighlighted);
    button.classList.toggle('text-black', isHighlighted);
    button.classList.toggle('bg-white/10', !isHighlighted);
    button.classList.toggle('hover:bg-white/15', !isHighlighted);
    button.innerText = isHighlighted ? '⭐ Historia destacada' : '⭐ Destacar historia';

    showStatusBubble(isHighlighted ? 'Historia marcada como destacada' : 'Historia normal');
}

function showStatusBubble(text){
    if (!musicStatusBubble) return;
    musicStatusBubble.innerText = text;
    musicStatusBubble.classList.remove('hidden');
    setTimeout(() => musicStatusBubble?.classList.add('hidden'), 2500);
}

const musicSearch = document.getElementById('musicSearch');
if (musicSearch) {
    musicSearch.addEventListener('keypress', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            searchSpotify();
        }
    });
}

function addAltText(){
    const text = prompt("Escribe el texto alternativo para esta historia:");
    if(!text) return;

    const input = document.getElementById('altText');
    input.value = text;
    alert("Texto alternativo guardado");
}

function openStickers(){

    const modal = document.createElement('div');

    modal.className =
    'fixed inset-0 bg-black/80 flex items-center justify-center z-[9999]';

    const stickers = [
        '❤️',
        '🐶',
        '🐱',
        '🐾',
        '⭐',
        '🔥',
        '😂',
        '😍',
        '🎉',
        '🌈',
        '💖',
        '👑',
        '😎',
        '🥳',
        '🦴',
        '🎈'
    ];

    modal.innerHTML = `
<div class="bg-[#11181d] rounded-3xl p-6 w-[450px] max-w-[95vw]">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-white text-xl font-bold">
            Seleccionar sticker
        </h2>

        <button
            id="closeStickerModal"
            class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-red-500 text-white transition">
            ✕
        </button>
    </div>

    <div
        id="stickerGrid"
        class="grid grid-cols-4 gap-4">
    </div>

</div>
`;

    document.body.appendChild(modal);

modal.querySelector('#closeStickerModal').onclick = () => {
    modal.remove();
};

const grid =
    modal.querySelector('#stickerGrid');

    stickers.forEach(sticker => {

        const btn =
            document.createElement('button');

        btn.className =
        'text-5xl hover:scale-125 transition';

        btn.innerText = sticker;

        btn.onclick = () => {

            const el =
                document.createElement('div');

            el.innerText = sticker;

            el.className =
            'absolute text-6xl';

            el.style.left = '100px';
            el.style.top = '120px';

            makeDraggable(el);

            overlay.appendChild(el);

            modal.remove();

            showStatusBubble(
                '✅ Sticker agregado'
            );
        };

        grid.appendChild(btn);
    });

    modal.addEventListener('click', e => {

        if(e.target === modal){
            modal.remove();
        }
    });
}

function openEffects(){

    const effects = [
        {
            nombre:'✨ Normal',
            filtro:'none'
        },
        {
            nombre:'🖤 Blanco y negro',
            filtro:'grayscale(100%)'
        },
        {
            nombre:'📸 Vintage',
            filtro:'sepia(100%)'
        },
        {
            nombre:'☀️ Brillante',
            filtro:'brightness(130%)'
        },
        {
            nombre:'❄️ Frío',
            filtro:'hue-rotate(180deg)'
        },
        {
            nombre:'🌈 Contraste',
            filtro:'contrast(180%)'
        }
    ];

    const modal = document.createElement('div');

    modal.className =
    'fixed inset-0 bg-black/80 flex items-center justify-center z-[9999]';

    modal.innerHTML = `
<div class="bg-[#11181d] rounded-3xl p-6 w-[500px] max-w-[95vw]">

    <div class="flex justify-between items-center mb-5">
        <h2 class="text-white text-xl font-bold">
            Seleccionar efecto
        </h2>

        <button
            id="closeEffectsModal"
            class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-red-500 text-white transition">
            ✕
        </button>
    </div>

    <div id="effectsList" class="space-y-3"></div>

</div>
`;

    document.body.appendChild(modal);
    modal.querySelector('#closeEffectsModal').onclick = () => {
    modal.remove();
};

    const list =
        modal.querySelector('#effectsList');

    effects.forEach(effect => {

        const btn =
            document.createElement('button');

        btn.className =
        'w-full bg-white/10 hover:bg-cyan-500 hover:text-black transition rounded-2xl p-4 text-left font-semibold';

        btn.innerText =
            effect.nombre;

        btn.onclick = () => {

            document
                .getElementById('storyMedia')
                .style.filter = effect.filtro;

            modal.remove();

            showStatusBubble(
                `✅ ${effect.nombre} aplicado`
            );
        };

        list.appendChild(btn);
    });

    modal.addEventListener('click', e => {

        if(e.target === modal){
            modal.remove();
        }

    });
}

function addMention(){

    const modal = document.createElement('div');

    modal.className =
    'fixed inset-0 bg-black/80 flex items-center justify-center z-[9999]';

    modal.innerHTML = `
<div class="bg-[#11181d] rounded-3xl w-[500px] max-w-[95vw] p-4">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-white text-xl font-bold">
            Mencionar usuario
        </h2>

        <button
            id="closeMentionModal"
            class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-red-500 text-white transition">
            ✕
        </button>
    </div>

    <input
        id="mentionSearch"
                type="text"
                placeholder="Buscar usuario..."
                class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white"
            >

            <div
                id="mentionResults"
                class="mt-4 max-h-[400px] overflow-y-auto"
            ></div>

        </div>
    `;

    document.body.appendChild(modal);
    modal.querySelector('#closeMentionModal').onclick = () => {
    modal.remove();
};

    const input = modal.querySelector('#mentionSearch');
    const results = modal.querySelector('#mentionResults');

    input.focus();

    input.addEventListener('input', async () => {

        const query = input.value.trim();

        if(query.length < 1){
            results.innerHTML = '';
            return;
        }

        const response =
            await fetch(`/usuarios/buscar?q=${query}`);

        const users =
            await response.json();

        results.innerHTML = '';

        users.forEach(user => {

            const row =
                document.createElement('div');

            row.className =
            'flex items-center gap-3 p-3 rounded-xl hover:bg-white/10 cursor-pointer';

            row.innerHTML = `
                <div class="w-10 h-10 rounded-full bg-cyan-500 flex items-center justify-center text-white">
                    👤
                </div>

                <div>
                    <div class="text-white font-semibold">
                        ${user.nom_us}
                    </div>

                    <div class="text-gray-400 text-sm">
                        ${user.app_us ?? ''}
                        ${user.apm_us ?? ''}
                    </div>
                </div>
            `;

            row.onclick = () => {

                const mention =
                    document.createElement('div');

                mention.innerText =
                    '@' + user.nom_us;

                mention.className =
                "text-white text-lg font-semibold bg-cyan-500/70 px-3 py-1 rounded-full";

                mention.style.left = "60px";
                mention.style.top = "120px";

                makeDraggable(mention);

                overlay.appendChild(mention);

                modal.remove();
            };

            results.appendChild(row);
        });
    });

    modal.addEventListener('click', e => {
        if(e.target === modal){
            modal.remove();
        }
    });
}




function saveStory(){
    document.getElementById('shareForm').requestSubmit();
}

function discardStory(){
    if(confirm("¿Descartar historia?")){
        window.location.href = "{{ route('historias.crear') }}";
    }
}

const shareForm = document.getElementById('shareForm');
shareForm.addEventListener('submit', function(){
    const elements = [];
    overlay.querySelectorAll('div').forEach(el => {
        elements.push({
            text: el.innerText,
            left: el.style.left,
            top: el.style.top,
            className: el.className
        });
    });

    document.getElementById('elementsInput').value = JSON.stringify(elements);
    document.getElementById('musicInput').value = selectedMusic ?? '';
});

</script>

</body>
</html>
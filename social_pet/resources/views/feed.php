<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Feed Mascotas 🐾</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>
body {
    background-color: #F5F2ED;
}

/* NAVBAR */
.bottom-nav {
    position: fixed;
    bottom: 10px;
    left: 10px;
    right: 10px;

    backdrop-filter: blur(20px);
    background: rgba(255,255,255,0.2);

    border-radius: 20px;
    overflow: hidden;
    z-index: 100;
}

/* BURBUJA */
.nav-glow {
    position: absolute;

    width: 100px;
    height: 65px;

    background: rgba(199, 234, 228, 0.27);
    backdrop-filter: blur(30px);
    -webkit-backdrop-filter: blur(30px);

    border-radius: 999px;

    pointer-events: none;

    transform: translate(-50%, -50%);
    transition: all 0.25s ease, opacity 0.2s ease;

    opacity: 0;
}

/* BOTÓN PLUS */
#plus-btn {
    transition: transform 0.2s ease;
}

/* REACCIONES */
.reaction-item {
    transition: transform 0.2s;
    cursor: pointer;
}

.reaction-item:hover {
    transform: scale(1.4) translateY(-5px);
}
</style>

</head>

<body class="text-gray-800">

<!-- FEED -->
<div class="max-w-xl mx-auto pt-6 pb-28 px-4" id="feed"></div>

<!-- NAVBAR -->
<div class="bottom-nav flex justify-around py-3 text-xl items-center" id="nav">

    <div class="nav-glow" id="glow"></div>

    <button>🐾</button>
    <button>🔍</button>
    <button id="plus-btn" class="bg-orange-500 text-white px-4 py-2 rounded-full">➕</button>
    <button>💘</button>
    <button>👤</button>

</div>

<script>

// DATA
const posts = [
{
    name: "Max",    
    breed: "Golden Retriever",
    location: "Parque Central",
    text: "Buscando amigos para jugar 🐾",
    music: "🎵 Happy Vibes",
    img: "https://images.unsplash.com/photo-1558788353-f76d92427f16"
},
{
    name: "Luna",
    breed: "Husky",
    location: "Madrid",
    text: "Hoy fue día de paseo 🌳",
    music: "",
    img: "https://images.unsplash.com/photo-1548199973-03cce0bbc87b"
}
];

const feed = document.getElementById("feed");

// RENDER
posts.forEach((post, index) => {
feed.innerHTML += `
<div class="bg-white rounded-2xl shadow mb-6 overflow-hidden">

    <img src="${post.img}" class="w-full h-72 object-cover">

    <div class="p-4">

        <h3 class="font-bold text-lg">🐶 ${post.name} • ${post.breed}</h3>
        <p class="text-sm text-gray-500">📍 ${post.location}</p>

        ${post.music ? `<p class="text-sm mt-1">${post.music}</p>` : ""}

        <p class="mt-3">${post.text}</p>

        <div class="relative mt-4 reaction-container">

            <button 
                id="main-btn-${index}"
                onmousedown="startPress(event, ${index})"
                onmouseup="cancelPress()"
                onmouseleave="cancelPress()"
                class="text-2xl"
            >
                🐾
            </button>

            <div id="reactions-${index}" 
                 class="hidden absolute bottom-14 left-0 bg-white shadow-xl rounded-full px-4 py-3 flex gap-3 items-center z-50">

                <div id="tooltip-${index}" 
                     class="absolute -top-8 left-1/2 -translate-x-1/2 bg-black text-white text-xs px-2 py-1 rounded hidden">
                </div>

                <div class="reaction-item"
                     onmouseenter="showTooltip(${index}, 'Le gusta 🦴')" 
                     onmouseleave="hideTooltip(${index})"
                     onclick="react(${index}, 'like')">
                    🦴
                </div>

                <div class="reaction-item"
                     onmouseenter="showTooltip(${index}, 'Le encanta 😍')" 
                     onmouseleave="hideTooltip(${index})"
                     onclick="react(${index}, 'love')">
                    <img src="../imagen/lovedog.png" width="40" height="40" style="pointer-events:none;">
                </div>

            </div>

        </div>

        <div class="flex justify-between items-center mt-4">
            <button onclick="connect(${index})"
            class="bg-orange-500 text-white px-4 py-2 rounded-lg">
                🐾 Conectar
            </button>

            <button class="text-gray-500">💬 Comentar</button>
        </div>

    </div>
</div>
`;
});

// FUNCIONES
function react(index, type){
    document.getElementById(`reactions-${index}`).classList.add("hidden");
    const btn = document.getElementById(`main-btn-${index}`);
    btn.innerText = type === "love" ? "❤️" : "🦴";
}

function connect(index){
    alert("🐾 Has enviado una conexión!");
}

// LONG PRESS
let pressTimer;

function startPress(e, index) {
    e.preventDefault();
    pressTimer = setTimeout(() => {
        document.getElementById(`reactions-${index}`).classList.remove("hidden");
    }, 300);
}

function cancelPress() {
    clearTimeout(pressTimer);
}

// CERRAR MENÚ
document.addEventListener("click", (e) => {
    if (!e.target.closest(".reaction-container")) {
        document.querySelectorAll('[id^="reactions-"]').forEach(el => {
            el.classList.add("hidden");
        });
    }
});

// TOOLTIP
function showTooltip(index, text) {
    const tooltip = document.getElementById(`tooltip-${index}`);
    tooltip.innerText = text;
    tooltip.classList.remove("hidden");
}

function hideTooltip(index) {
    document.getElementById(`tooltip-${index}`).classList.add("hidden");
}

// ===== BURBUJA =====
const nav = document.getElementById("nav");
const glow = document.getElementById("glow");

let mouseX = 0, mouseY = 0;
let currentX = 0, currentY = 0;

// mostrar / ocultar
nav.addEventListener("mouseenter", () => {
    glow.style.opacity = "1";
});

nav.addEventListener("mouseleave", () => {
    glow.style.opacity = "0";
});

// movimiento
nav.addEventListener("mousemove", (e) => {
    const rect = nav.getBoundingClientRect();
    mouseX = e.clientX - rect.left;
    mouseY = e.clientY - rect.top;
});

// animación fluida
function animate() {
    currentX += (mouseX - currentX) * 0.2;
    currentY += (mouseY - currentY) * 0.08;

    glow.style.left = currentX + "px";
    glow.style.top = currentY + "px";

    requestAnimationFrame(animate);
}
animate();

// magnetismo SUAVE (sin exagerar tamaño)
const buttons = nav.querySelectorAll("button");

buttons.forEach(btn => {
    btn.addEventListener("mouseenter", () => {
        const rect = btn.getBoundingClientRect();
        const navRect = nav.getBoundingClientRect();

        mouseX = rect.left - navRect.left + rect.width / 2;
        mouseY = rect.top - navRect.top + rect.height / 2;

        glow.style.width = "110px";
        glow.style.height = "70px";
    });

    btn.addEventListener("mouseleave", () => {
        glow.style.width = "100px";
        glow.style.height = "65px";
    });
});

// botón +
const plusBtn = document.getElementById("plus-btn");

plusBtn.addEventListener("mouseenter", () => {
    plusBtn.style.transform = "scale(1.3)";
});

plusBtn.addEventListener("mouseleave", () => {
    plusBtn.style.transform = "scale(1)";
});

// posición inicial
const rect = nav.getBoundingClientRect();
currentX = rect.width / 2;
currentY = rect.height / 2;

</script>

</body>
</html>
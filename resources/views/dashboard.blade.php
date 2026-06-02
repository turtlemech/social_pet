<h1>Dashboard Funciona</h1>

<p>Usuario: {{ Auth::user()->nom_us }}</p>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">
        Cerrar Sesión
    </button>
</form>

<button
    id="openMessages"
    class="fixed bottom-6 right-6 z-40 bg-[#1f2029] text-white rounded-full px-6 py-4 shadow-2xl flex items-center gap-4 hover:scale-105 transition-all duration-300 border border-white/10"
>
    <svg class="w-7 h-7"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24">

        <path stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M8 10h.01M12 10h.01M16 10h.01M21 10c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 18l1.395-3.72C3.512 13.042 3 11.574 3 10c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
    </svg>

    <span class="font-semibold text-lg">
        Mensajes
    </span>
</button>
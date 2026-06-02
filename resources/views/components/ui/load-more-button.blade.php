@props(['loading' => false])

<div class="text-center mt-6">
    <button {{ $attributes->merge(['class' => 'px-6 py-2 bg-white text-social-teal rounded-lg shadow-sm hover:shadow-md transition']) }}>
        {{ $loading ? 'Cargando...' : 'Cargar más publicaciones' }}
    </button>
</div>
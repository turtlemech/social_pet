<div class="absolute bottom-4 left-4 right-4 flex justify-end">

    <form action="{{ route('stories.store.final') }}" method="POST">
        @csrf

        <input type="hidden" name="media" value="{{ $media }}">
        <input type="hidden" name="type" value="{{ $type }}">

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full font-semibold">
            Compartir
        </button>

    </form>

</div>
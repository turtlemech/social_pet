<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <div class="flex space-x-3">
        <img src="https://ui-avatars.com/api/?name=John+Doe&background=0d9488&color=fff" 
             alt="Avatar" 
             class="w-10 h-10 rounded-full">
        
        <div class="flex-1">
            <input type="text" 
                   placeholder="What's your pet doing?" 
                   class="w-full px-4 py-2 rounded-full bg-gray-100 border-0 focus:ring-2 focus:ring-social-teal focus:bg-white transition cursor-pointer"
                   readonly
                   onclick="document.getElementById('post-modal').classList.remove('hidden')">
        </div>
    </div>
    
    <div class="flex justify-around mt-4 pt-3 border-t border-gray-100">
        <button class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="text-sm font-medium">Photo</span>
        </button>
        
        <button class="flex items-center space-x-2 text-gray-500 hover:text-red-500 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            <span class="text-sm font-medium">Video</span>
        </button>
        
        <button class="flex items-center space-x-2 text-gray-500 hover:text-green-500 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="text-sm font-medium">Check-in</span>
        </button>
    </div>
</div>

<!-- Post Modal -->
<<div id="post-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    
    <div class="bg-white rounded-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        
        <!-- Header -->
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold w-full text-center">
                Crear publicación
            </h3>
            <button onclick="document.getElementById('post-modal').classList.add('hidden')" 
                class="text-gray-400 hover:text-gray-600">
                ✕
            </button>
        </div>

        <!-- Form -->
        <form method="POST" action="/posts">
            @csrf

            <div class="p-4">

                <!-- Usuario -->
                <div class="flex items-center space-x-3 mb-4">
                    
                    <!-- Avatar -->
                    <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white font-bold">
                        JD
                    </div>

                    <div>

        <p class="font-semibold text-gray-900">

            {{ auth()->user()->name ?? 'Me' }}

        </p>

    </div>
                </div>

                <!-- Texto -->
                <textarea 
                    name="content"
                    placeholder="¿Qué estás pensando?"
                    class="w-full text-xl border-none focus:ring-0 resize-none placeholder-gray-400"
                    rows="4"
                    required></textarea>

                <!-- Botón -->
                <div class="mt-4">
                    <button type="submit"
                        class="w-full bg-teal-500 text-white py-2 rounded-lg font-semibold hover:bg-teal-600 transition">
                        Publicar
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>
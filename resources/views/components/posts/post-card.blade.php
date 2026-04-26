@props(['post'])

<div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
    
    <!-- Post Header -->
    <div class="p-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <img src="{{ $post->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($post->pet_name).'&background=0d9488&color=fff' }}" 
                 alt="{{ $post->pet_name }}" 
                 class="w-10 h-10 rounded-full object-cover">

            <div>
                <div class="flex items-center space-x-2">
                    <h4 class="font-semibold text-gray-900">{{ $post->pet_name }}</h4>
                    <span class="text-gray-400">·</span>
                    <span class="text-xs text-gray-500">{{ $post->breed }}</span>
                </div>
                <p class="text-xs text-gray-400">
                    {{ $post->time_ago }} · by {{ $post->author }}
                </p>
            </div>
        </div>

        <button class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 5v.01M12 12v.01M12 19v.01"></path>
            </svg>
        </button>
    </div>
    
    <!-- Content -->
    <div class="px-4 pb-3">
        <p class="text-gray-800">{{ $post->content }}</p>
    </div>
    
    <!-- Image -->
    @if(isset($post->image))
        <img src="{{ $post->image }}" class="w-full object-cover max-h-96">
    @endif
    
    <!-- Stats -->
    <div class="px-4 py-2 flex justify-between text-sm text-gray-500 border-t border-gray-100">
        <div class="flex items-center space-x-1">
            <svg class="w-4 h-4 text-red-500 fill-current" viewBox="0 0 20 20">
                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
            </svg>
            <span>{{ $post->likes ?? 0 }} likes</span>
        </div>

        <div>{{ $post->comments ?? 0 }} comments</div>
    </div>
    
<!-- Actions -->
<div class="flex border-t border-gray-100">

    <!-- ❤️ LIKE -->
    @if(isset($post->id))
    <form method="POST" action="/like/{{ $post->id }}" class="flex-1">
        @csrf

        <button type="submit"
            class="w-full py-2 flex items-center justify-center space-x-2 transition
            {{ $post->liked ? 'text-red-500' : 'text-gray-500 hover:text-red-500' }}">

            <svg 
                class="w-5 h-5 {{ $post->liked ? 'fill-red-500' : '' }}" 
                fill="{{ $post->liked ? 'currentColor' : 'none' }}" 
                stroke="currentColor" 
                viewBox="0 0 24 24">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>

            <span>Like</span>
        </button>
    </form>
    @else
    <!-- Para posts fake -->
    <div class="flex-1 py-2 flex items-center justify-center space-x-2 text-gray-400">
        ❤️ <span>Like</span>
    </div>
    @endif

    <!-- 💬 COMMENT -->
    <button class="flex-1 py-2 flex items-center justify-center space-x-2 text-gray-500 hover:text-social-teal transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M8 12h.01M12 12h.01M16 12h.01"></path>
        </svg>
        <span>Comment</span>
    </button>

    <!-- 🔗 SHARE -->
    <button class="flex-1 py-2 flex items-center justify-center space-x-2 text-gray-500 hover:text-green-500 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M8.684 13.342l6.632 3.316m0-6l-6.632-3.316"></path>
        </svg>
        <span>Share</span>
    </button>

</div>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['post']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['post']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
    <!-- Post Header -->
    <div class="p-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <img src="<?php echo e($post->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($post->pet_name).'&background=0d9488&color=fff'); ?>" 
                 alt="<?php echo e($post->pet_name); ?>" 
                 class="w-10 h-10 rounded-full object-cover">
            <div>
                <div class="flex items-center space-x-2">
                    <h4 class="font-semibold text-gray-900"><?php echo e($post->pet_name); ?></h4>
                    <span class="text-gray-400">·</span>
                    <span class="text-xs text-gray-500"><?php echo e($post->breed); ?></span>
                </div>
                <p class="text-xs text-gray-400"><?php echo e($post->time_ago); ?> · by <?php echo e($post->author); ?></p>
            </div>
        </div>
        <button class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
            </svg>
        </button>
    </div>
    
    <!-- Post Content -->
    <div class="px-4 pb-3">
        <p class="text-gray-800"><?php echo e($post->content); ?></p>
    </div>
    
    <!-- Post Image (if exists) -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($post->image)): ?>
        <img src="<?php echo e($post->image); ?>" alt="Post image" class="w-full object-cover max-h-96">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    <!-- Engagement Stats -->
    <div class="px-4 py-2 flex justify-between text-sm text-gray-500 border-t border-gray-100">
        <div class="flex items-center space-x-1">
            <svg class="w-4 h-4 text-red-500 fill-current" viewBox="0 0 20 20">
                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path>
            </svg>
            <span><?php echo e($post->likes ?? 0); ?> likes</span>
        </div>
        <div><?php echo e($post->comments ?? 0); ?> comments</div>
    </div>
    
    <!-- Action Buttons -->
    <div class="flex border-t border-gray-100">
        <button class="flex-1 py-2 flex items-center justify-center space-x-2 text-gray-500 hover:text-red-500 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            <span>Like</span>
        </button>
        <button class="flex-1 py-2 flex items-center justify-center space-x-2 text-gray-500 hover:text-social-teal transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <span>Comment</span>
        </button>
        <button class="flex-1 py-2 flex items-center justify-center space-x-2 text-gray-500 hover:text-green-500 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
            </svg>
            <span>Share</span>
        </button>
    </div>
</div><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/social_pet/resources/views/components/posts/post-card.blade.php ENDPATH**/ ?>
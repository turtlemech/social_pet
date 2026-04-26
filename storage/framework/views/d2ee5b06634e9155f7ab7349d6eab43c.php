<?php $__env->startSection('content'); ?>

<?php 
    use Carbon\Carbon; 
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-2xl shadow-lg p-6 mb-8 text-white">
        <div class="flex items-center justify-between flex-wrap">
            <div>
                <h1 class="text-2xl font-bold mb-2">
                    ¡Bienvenido de vuelta, <?php echo e(Auth::user()->name); ?>!
                </h1>
                <p class="text-teal-100">
                    Comparte momentos especiales con tu mascota
                </p>
            </div>
            <img src="https://cdn-icons-png.flaticon.com/512/1998/1998629.png" 
                 alt="Pets" 
                 class="w-20 h-20 opacity-90">
        </div>
    </div>
    
    <div class="flex flex-col lg:flex-row gap-6">
        
        <!-- Sidebar Left -->
        <div class="lg:w-1/4 space-y-6">
            <?php if (isset($component)) { $__componentOriginal846a635bef81eac7f7bc92fcfe64cca4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal846a635bef81eac7f7bc92fcfe64cca4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.stories-section','data' => ['stories' => ['Max', 'Luna', 'Charlie', 'Bella']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.stories-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['stories' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Max', 'Luna', 'Charlie', 'Bella'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal846a635bef81eac7f7bc92fcfe64cca4)): ?>
<?php $attributes = $__attributesOriginal846a635bef81eac7f7bc92fcfe64cca4; ?>
<?php unset($__attributesOriginal846a635bef81eac7f7bc92fcfe64cca4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal846a635bef81eac7f7bc92fcfe64cca4)): ?>
<?php $component = $__componentOriginal846a635bef81eac7f7bc92fcfe64cca4; ?>
<?php unset($__componentOriginal846a635bef81eac7f7bc92fcfe64cca4); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal840ec11f3104d9bf85bbbdacc0aa3723 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal840ec11f3104d9bf85bbbdacc0aa3723 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.quick-menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.quick-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal840ec11f3104d9bf85bbbdacc0aa3723)): ?>
<?php $attributes = $__attributesOriginal840ec11f3104d9bf85bbbdacc0aa3723; ?>
<?php unset($__attributesOriginal840ec11f3104d9bf85bbbdacc0aa3723); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal840ec11f3104d9bf85bbbdacc0aa3723)): ?>
<?php $component = $__componentOriginal840ec11f3104d9bf85bbbdacc0aa3723; ?>
<?php unset($__componentOriginal840ec11f3104d9bf85bbbdacc0aa3723); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal7c774f7a4c658561931f611b0868300c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7c774f7a4c658561931f611b0868300c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.user-card','data' => ['user' => Auth::user()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.user-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Auth::user())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7c774f7a4c658561931f611b0868300c)): ?>
<?php $attributes = $__attributesOriginal7c774f7a4c658561931f611b0868300c; ?>
<?php unset($__attributesOriginal7c774f7a4c658561931f611b0868300c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7c774f7a4c658561931f611b0868300c)): ?>
<?php $component = $__componentOriginal7c774f7a4c658561931f611b0868300c; ?>
<?php unset($__componentOriginal7c774f7a4c658561931f611b0868300c); ?>
<?php endif; ?>
        </div>
        
        <!-- Main Feed -->
        <div class="lg:w-2/4">
            
            <!-- Crear post -->
            <?php if (isset($component)) { $__componentOriginalae5799dd92fe08587eed672e85fd7d27 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalae5799dd92fe08587eed672e85fd7d27 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.posts.create-post','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('posts.create-post'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalae5799dd92fe08587eed672e85fd7d27)): ?>
<?php $attributes = $__attributesOriginalae5799dd92fe08587eed672e85fd7d27; ?>
<?php unset($__attributesOriginalae5799dd92fe08587eed672e85fd7d27); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalae5799dd92fe08587eed672e85fd7d27)): ?>
<?php $component = $__componentOriginalae5799dd92fe08587eed672e85fd7d27; ?>
<?php unset($__componentOriginalae5799dd92fe08587eed672e85fd7d27); ?>
<?php endif; ?>

            <!-- Tabs -->
            <?php if (isset($component)) { $__componentOriginalbbdc3a2c5440bae13a3a1a2d3ac9fbb8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbbdc3a2c5440bae13a3a1a2d3ac9fbb8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.feed-tabs','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.feed-tabs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbbdc3a2c5440bae13a3a1a2d3ac9fbb8)): ?>
<?php $attributes = $__attributesOriginalbbdc3a2c5440bae13a3a1a2d3ac9fbb8; ?>
<?php unset($__attributesOriginalbbdc3a2c5440bae13a3a1a2d3ac9fbb8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbbdc3a2c5440bae13a3a1a2d3ac9fbb8)): ?>
<?php $component = $__componentOriginalbbdc3a2c5440bae13a3a1a2d3ac9fbb8; ?>
<?php unset($__componentOriginalbbdc3a2c5440bae13a3a1a2d3ac9fbb8); ?>
<?php endif; ?>

            <?php
                $fakePosts = [
                    (object)[
                        'pet_name' => 'Max',
                        'breed' => 'Golden Retriever',
                        'author' => 'Sarah Johnson',
                        'time_ago' => '2 horas',
                        'content' => '¡Disfrutando del parque! 🐾',
                        'image' => 'https://images.dog.ceo/breeds/retriever-golden/n02099601_100.jpg',
                        'likes' => 124,
                        'comments' => 18
                    ],
                    (object)[
                        'pet_name' => 'Luna',
                        'breed' => 'Husky',
                        'author' => 'Mike Rodríguez',
                        'time_ago' => '5 horas',
                        'content' => '¿Quién quiere galletas? 🦴',
                        'image' => 'https://images.dog.ceo/breeds/husky/n02110185_100.jpg',
                        'likes' => 89,
                        'comments' => 12
                    ]
                ];
            ?>

            <!-- POSTS REALES -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginalee79e636c220d7ebbd52bd5d3dfc300e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee79e636c220d7ebbd52bd5d3dfc300e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.posts.post-card','data' => ['post' => (object)[
                        'pet_name' => 'Mascota',
                        'breed' => '',
                        'author' => $post->user->name ?? 'Usuario',
                        'time_ago' => $post->created_at 
                            ? Carbon::parse($post->created_at)->diffForHumans()
                            : 'Ahora',
                        'content' => $post->con_pub,
                        'image' => null,
                        'likes' => 0,
                        'comments' => 0
                    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('posts.post-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((object)[
                        'pet_name' => 'Mascota',
                        'breed' => '',
                        'author' => $post->user->name ?? 'Usuario',
                        'time_ago' => $post->created_at 
                            ? Carbon::parse($post->created_at)->diffForHumans()
                            : 'Ahora',
                        'content' => $post->con_pub,
                        'image' => null,
                        'likes' => 0,
                        'comments' => 0
                    ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee79e636c220d7ebbd52bd5d3dfc300e)): ?>
<?php $attributes = $__attributesOriginalee79e636c220d7ebbd52bd5d3dfc300e; ?>
<?php unset($__attributesOriginalee79e636c220d7ebbd52bd5d3dfc300e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee79e636c220d7ebbd52bd5d3dfc300e)): ?>
<?php $component = $__componentOriginalee79e636c220d7ebbd52bd5d3dfc300e; ?>
<?php unset($__componentOriginalee79e636c220d7ebbd52bd5d3dfc300e); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- POSTS DE EJEMPLO -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $fakePosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginalee79e636c220d7ebbd52bd5d3dfc300e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee79e636c220d7ebbd52bd5d3dfc300e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.posts.post-card','data' => ['post' => $post]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('posts.post-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee79e636c220d7ebbd52bd5d3dfc300e)): ?>
<?php $attributes = $__attributesOriginalee79e636c220d7ebbd52bd5d3dfc300e; ?>
<?php unset($__attributesOriginalee79e636c220d7ebbd52bd5d3dfc300e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee79e636c220d7ebbd52bd5d3dfc300e)): ?>
<?php $component = $__componentOriginalee79e636c220d7ebbd52bd5d3dfc300e; ?>
<?php unset($__componentOriginalee79e636c220d7ebbd52bd5d3dfc300e); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </div>
        
        <!-- Sidebar Right -->
        <div class="lg:w-1/4 space-y-6">
            <?php if (isset($component)) { $__componentOriginalb3bf1ec1997a5eccb5003e8d9e972e8c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb3bf1ec1997a5eccb5003e8d9e972e8c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.suggested-pets','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.suggested-pets'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb3bf1ec1997a5eccb5003e8d9e972e8c)): ?>
<?php $attributes = $__attributesOriginalb3bf1ec1997a5eccb5003e8d9e972e8c; ?>
<?php unset($__attributesOriginalb3bf1ec1997a5eccb5003e8d9e972e8c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb3bf1ec1997a5eccb5003e8d9e972e8c)): ?>
<?php $component = $__componentOriginalb3bf1ec1997a5eccb5003e8d9e972e8c; ?>
<?php unset($__componentOriginalb3bf1ec1997a5eccb5003e8d9e972e8c); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalfa995ab5254a3813d06854e564e7d006 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa995ab5254a3813d06854e564e7d006 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.trending-topics','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.trending-topics'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa995ab5254a3813d06854e564e7d006)): ?>
<?php $attributes = $__attributesOriginalfa995ab5254a3813d06854e564e7d006; ?>
<?php unset($__attributesOriginalfa995ab5254a3813d06854e564e7d006); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa995ab5254a3813d06854e564e7d006)): ?>
<?php $component = $__componentOriginalfa995ab5254a3813d06854e564e7d006; ?>
<?php unset($__componentOriginalfa995ab5254a3813d06854e564e7d006); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal02ad1901f5a9e8c47fc0699acd0a03b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal02ad1901f5a9e8c47fc0699acd0a03b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.event-card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.event-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal02ad1901f5a9e8c47fc0699acd0a03b2)): ?>
<?php $attributes = $__attributesOriginal02ad1901f5a9e8c47fc0699acd0a03b2; ?>
<?php unset($__attributesOriginal02ad1901f5a9e8c47fc0699acd0a03b2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal02ad1901f5a9e8c47fc0699acd0a03b2)): ?>
<?php $component = $__componentOriginal02ad1901f5a9e8c47fc0699acd0a03b2; ?>
<?php unset($__componentOriginal02ad1901f5a9e8c47fc0699acd0a03b2); ?>
<?php endif; ?>
        </div>
        
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/social_pet/resources/views/user/dashboard.blade.php ENDPATH**/ ?>
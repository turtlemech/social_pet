<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['variant' => 'primary', 'size' => 'md', 'type' => 'button']));

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

foreach (array_filter((['variant' => 'primary', 'size' => 'md', 'type' => 'button']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $variants = [
        'primary' => 'bg-social-teal text-white hover:bg-social-teal-dark',
        'secondary' => 'bg-gray-200 text-gray-700 hover:bg-gray-300',
        'danger' => 'bg-red-500 text-white hover:bg-red-600',
        'outline' => 'border border-social-teal text-social-teal hover:bg-social-teal hover:text-white'
    ];
    
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base'
    ];
    
    $classes = $variants[$variant] . ' ' . $sizes[$size] . ' rounded-lg transition font-medium';
?>

<button type="<?php echo e($type); ?>" <?php echo e($attributes->merge(['class' => $classes])); ?>>
    <?php echo e($slot); ?>

</button><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/social_pet/resources/views/components/ui/button.blade.php ENDPATH**/ ?>
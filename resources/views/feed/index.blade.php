@extends('components.layouts.app')

@section('title', 'Feed')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Sidebar Left - Stories -->
        <div class="lg:w-1/4">
            <div class="bg-white rounded-xl shadow-sm p-4 sticky top-20">
                <h3 class="font-semibold text-gray-900 mb-3">Stories</h3>
                
                <!-- Stories Horizontal Scroll -->
                <div class="stories-scroll overflow-x-auto pb-2 -mx-2 px-2">
                    <div class="flex space-x-4">
                        <x-posts.story-circle isAdd="true" />
                        <x-posts.story-circle name="Max" avatar="https://ui-avatars.com/api/?name=Max&background=0d9488&color=fff" />
                        <x-posts.story-circle name="Luna" avatar="https://ui-avatars.com/api/?name=Luna&background=0d9488&color=fff" />
                        <x-posts.story-circle name="Charlie" avatar="https://ui-avatars.com/api/?name=Charlie&background=0d9488&color=fff" />
                        <x-posts.story-circle name="Bella" avatar="https://ui-avatars.com/api/?name=Bella&background=0d9488&color=fff" />
                        <x-posts.story-circle name="Rocky" avatar="https://ui-avatars.com/api/?name=Rocky&background=0d9488&color=fff" />
                        <x-posts.story-circle name="Daisy" avatar="https://ui-avatars.com/api/?name=Daisy&background=0d9488&color=fff" />
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Feed -->
        <div class="lg:w-2/4">
            <!-- Create Post -->
            <x-posts.create-post />
            
            <!-- Feed Filter -->
            <div class="bg-white rounded-xl shadow-sm p-2 mb-6 flex">
                <button class="flex-1 py-2 text-sm font-medium text-social-teal border-b-2 border-social-teal">Feed</button>
                <button class="flex-1 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Trending</button>
                <button class="flex-1 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Following</button>
            </div>
            
            <!-- Posts -->
            @php
                $posts = [
                    [
                        'pet_name' => 'Max',
                        'breed' => 'Golden Retriever',
                        'author' => 'Sarah',
                        'time_ago' => '2h',
                        'content' => 'Enjoying a beautiful day at the park! 🐾☀️',
                        'image' => 'https://images.dog.ceo/breeds/retriever-golden/n02099601_100.jpg',
                        'likes' => 124,
                        'comments' => 18
                    ],
                    [
                        'pet_name' => 'Luna',
                        'breed' => 'Husky',
                        'author' => 'Mike',
                        'time_ago' => '5h',
                        'content' => 'Who wants treats? 🦴',
                        'image' => 'https://images.dog.ceo/breeds/husky/n02110185_100.jpg',
                        'likes' => 89,
                        'comments' => 12
                    ],
                    [
                        'pet_name' => 'Charlie',
                        'breed' => 'Beagle',
                        'author' => 'Emma',
                        'time_ago' => '1d',
                        'content' => 'Best nap ever 😴',
                        'likes' => 56,
                        'comments' => 7
                    ]
                ];
            @endphp
            
            @foreach($posts as $post)
                <x-posts.post-card :post="$post" />
            @endforeach
        </div>
        
        <!-- Sidebar Right -->
        <div class="lg:w-1/4">
            <div class="sticky top-20 space-y-6">
                <!-- Profile Card -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name=John+Doe&background=0d9488&color=fff" 
                             alt="Profile" 
                             class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-semibold text-gray-900">John Doe</h4>
                            <p class="text-xs text-gray-500">@johndoe</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mt-4 pt-3 border-t border-gray-100 text-center">
                        <div>
                            <p class="font-bold text-gray-900">128</p>
                            <p class="text-xs text-gray-500">Posts</p>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">1.2k</p>
                            <p class="text-xs text-gray-500">Followers</p>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">456</p>
                            <p class="text-xs text-gray-500">Following</p>
                        </div>
                    </div>
                </div>
                
                <!-- Suggested Pets -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-semibold text-gray-900">Suggested Pets</h3>
                        <button class="text-xs text-social-teal">See All</button>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <img src="https://ui-avatars.com/api/?name=Coco&background=0d9488&color=fff" class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="text-sm font-medium">Coco</p>
                                    <p class="text-xs text-gray-500">Poodle</p>
                                </div>
                            </div>
                            <button class="text-xs text-social-teal font-medium">Follow</button>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <img src="https://ui-avatars.com/api/?name=Rocky&background=0d9488&color=fff" class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="text-sm font-medium">Rocky</p>
                                    <p class="text-xs text-gray-500">Bulldog</p>
                                </div>
                            </div>
                            <button class="text-xs text-social-teal font-medium">Follow</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
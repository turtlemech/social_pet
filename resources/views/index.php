<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dog Training</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fuente -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .hero {
            background: url('https://images.unsplash.com/photo-1548199973-03cce0bbc87b') center/cover no-repeat;
        }
    </style>
</head>

<body class="bg-[#f5f2ed] text-gray-800">

<!-- NAVBAR -->
<header class="bg-white shadow-md fixed w-full z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center p-4">
        <h1 class="font-bold text-xl">🐶 i6eDieg</h1>

        <nav class="hidden md:flex gap-6">
            <a href="#" class="hover:text-orange-500">Home</a>
            <a href="#">About</a>
            <a href="#">Blog</a>
            <a href="login.php" class="hover:text-orange-500">Iniciar sesión</a>
        </nav>

        <button class="bg-orange-500 text-white px-4 py-2 rounded-lg">
            Donate
        </button>
    </div>
</header>

<!-- HERO -->
<section class="hero h-screen flex items-center text-white pt-20">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-5xl font-bold mb-4">
            We are training dogs to be better
        </h2>
        <p class="mb-6 max-w-lg">
            Professional dog training services to improve behavior and obedience.
        </p>
        <button class="bg-orange-500 px-6 py-3 rounded-lg font-semibold">
            Get Started
        </button>
    </div>
</section>

<!-- SERVICES -->
<section class="py-16 text-center">
    <h3 class="text-3xl font-bold mb-10">What we offer</h3>

    <div class="grid md:grid-cols-4 gap-6 max-w-6xl mx-auto px-6">
        <?php
        $services = ["Training", "Behavior", "Care", "Vet Help"];
        foreach($services as $service):
        ?>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <div class="text-4xl mb-4">🐾</div>
            <h4 class="font-semibold text-lg"><?= $service ?></h4>
            <p class="text-sm mt-2 text-gray-500">
                Professional service for your pet.
            </p>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ABOUT -->
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-10 items-center px-6">

        <div>
            <h3 class="text-3xl font-bold mb-4">
                Training time for your dog
            </h3>
            <p class="text-gray-600 mb-6">
                Improve your dog's behavior with our expert trainers and personalized programs.
            </p>

            <button class="bg-orange-500 text-white px-6 py-3 rounded-lg">
                Learn More
            </button>
        </div>

        <img src="https://images.unsplash.com/photo-1558788353-f76d92427f16"
             class="rounded-xl shadow-lg">
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-gray-900 text-white py-10">
    <div class="max-w-6xl mx-auto grid md:grid-cols-4 gap-6 px-6">

        <div>
            <h4 class="font-bold text-lg mb-3">Dog Training</h4>
            <p class="text-sm text-gray-400">
                Helping dogs become better companions.
            </p>
        </div>

        <div>
            <h5 class="font-semibold mb-2">Services</h5>
            <ul class="text-sm text-gray-400">
                <li>Training</li>
                <li>Behavior</li>
                <li>Care</li>
            </ul>
        </div>

        <div>
            <h5 class="font-semibold mb-2">Company</h5>
            <ul class="text-sm text-gray-400">
                <li>About</li>
                <li>Blog</li>
                <li>Contact</li>
            </ul>
        </div>

        <div>
            <h5 class="font-semibold mb-2">Subscribe</h5>
            <div class="flex">
                <input type="email" placeholder="Email"
                       class="w-full p-2 rounded-l bg-gray-800 border-none">
                <button class="bg-orange-500 px-4 rounded-r">
                    →
                </button>
            </div>
        </div>

    </div>
</footer>

<script src="script.js"></script>

</body>
</html>

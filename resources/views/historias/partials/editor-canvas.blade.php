<div class="w-full h-screen flex items-center justify-center p-4">

    <div class="bg-[#18191A] w-full max-w-6xl rounded-3xl overflow-hidden shadow-2xl">

        <!-- HEADER -->
        <div class="flex items-center justify-between p-5 border-b border-gray-700">

            <h2 class="text-2xl font-bold">
                Editor de historia
            </h2>

            <button
                onclick="window.history.back()"
                class="text-3xl"
            >
                ✕
            </button>

        </div>

        <!-- CONTENT -->
        <div class="p-6">

            <div class="relative bg-black rounded-3xl overflow-hidden h-[650px]">

                <img
                    src="{{ asset('storage/test.jpg') }}"
                    class="w-full h-full object-contain"
                >

            </div>

        </div>

    </div>

</div>
<x-app-layout>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <span class="font-medium">{{ $error }}</span>
            </div>
        @endforeach
    @endif

    <form action="{{ route('documents.create') }}" method="POST" enctype="multipart/form-data" class=" p-10">
        @csrf
        <label for="document" class="block mb-2 text-xl font-semibold text-white">Télécharger un document :</label>
        <div class="mb-5">
            <div class="flex items-center justify-center w-full">
                <label for="dropzone-file"
                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-700 border-dashed rounded-lg cursor-pointer bg-gradient-to-br from-gray-800 to-gray-900 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                                upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                    </div>
                    <input id="dropzone-file" type="file" class="hidden" name="document" required />
                </label>
            </div>
        </div>

        <button type="submit" id="uploadBtn"
            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Uploader</button>
    </form>

    <!-- Section masquée -->
    <section id="hidden-section"
        class="main-container overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
        style="display:none;">
        <div class="main relative p-4 w-full max-w-2xl max-h-full">
            <div class="big-circle">
                <div class="icon-block">
                    <img src="https://www.yudiz.com/codepen/animated-portfolio/web-dev-icon.png"
                        alt="web design icon" />
                </div>
                <div class="icon-block">
                    <img src="https://www.yudiz.com/codepen/animated-portfolio/game-design-icon.png"
                        alt="game design icon" />
                </div>
                <div class="icon-block">
                    <img src="https://www.yudiz.com/codepen/animated-portfolio/game-dev-icon.png" alt="game dev icon" />
                </div>
                <div class="icon-block">
                    <img src="https://www.yudiz.com/codepen/animated-portfolio/ui-ux-icon.png" alt="ui-ux icon" />
                </div>
            </div>
            <div class="circle">
                <div class="icon-block">
                    <img src="https://www.yudiz.com/codepen/animated-portfolio/app-icon.png" alt="app icon" />
                </div>
                <div class="icon-block">
                    <img src="https://www.yudiz.com/codepen/animated-portfolio/blockchain-icon.png"
                        alt="blockchain icon" />
                </div>
                <div class="icon-block">
                    <img src="https://www.yudiz.com/codepen/animated-portfolio/arvr-icon.png" alt="ar-vr icon" />
                </div>
                <div class="icon-block">
                    <img src="https://www.yudiz.com/codepen/animated-portfolio/artificial-intelligence-icon.png"
                        alt="artificial intelligence icon" />
                </div>
            </div>
            <div class="center-logo">
                <img src="" alt="logo" />
            </div>
        </div>
    </section>

    <!-- Script pour afficher la section -->
    <script>

        const uploadBtn = document.getElementById('uploadBtn');
        const loadingSpinner = document.getElementById('hidden-section');

        uploadBtn.addEventListener('click', function() {
            loadingSpinner.style.display = 'flex';
           
        });
    </script>
</x-app-layout>

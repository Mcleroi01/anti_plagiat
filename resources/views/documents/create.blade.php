<x-app-layout>

    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <form action="{{ route('documents.upload') }}" method="POST" enctype="multipart/form-data" id="form">
            @csrf
            <label for="document" class="block mb-2 text-xl font-semibold text-white">Télécharger un document
                :</label>
            <div class="mb-5">
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-700 border-dashed rounded-lg cursor-pointer bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-semibold">Cliquez pour télécharger</span> ou glisser-déposer
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">PDF</p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" name="document" accept=".pdf,.doc,.docx"
                            required />
                    </label>
                </div>

                <!-- Section pour afficher le nom du fichier -->
                <p id="file-name" class="mt-2 text-sm text-gray-600 dark:text-gray-300"></p>

            </div>

            <button type="submit" id="uploadBtn"
                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Uploader</button>
        </form>
    </div>

    <div class="fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50 hidden" id="hidden-section">
        <div class="flex justify-center items-center relative">
            <!-- Cercle extérieur gris -->
            <div class="h-24 w-24 rounded-full border-t-8 border-b-8 border-gray-200"></div>
            <!-- Cercle intérieur bleu avec animation -->
            <div
                class="absolute top-0 left-0 h-24 w-24 rounded-full border-t-8 border-b-8 border-blue-500 animate-spin">
            </div>
        </div>
    </div>

    <div id="progress-container" class="hidden">
        <div class="progress-bar bg-blue-500 h-4" id="progress-bar" style="width: 0%;"></div>
        <p id="progress-status">En attente...</p>
    </div>

    @section('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const uploadForm = document.getElementById('form');
                const uploadButton = document.getElementById('uploadBtn');
                const progressBar = document.getElementById('progress-bar');
                const progressContainer = document.getElementById('hidden-section');
                const progressStatus = document.getElementById('progress-status');

                uploadForm.addEventListener('submit', function(event) {
                    event.preventDefault(); // Empêche le rechargement de la page

                    const formData = new FormData(uploadForm);
                    progressContainer.classList.remove('hidden');
                    progressBar.style.width = '0%';
                    progressStatus.textContent = 'Téléchargement...';

                    // Envoi du fichier via AJAX
                    fetch('{{ route('documents.upload') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                monitorProgress(data
                                .document_id); // Démarrer la surveillance de la progression
                            } else {
                                throw new Error(data.message || 'Erreur lors du téléchargement');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: error.message || 'Une erreur est survenue.',
                            });
                            progressContainer.classList.add('hidden');
                        });
                });

                function monitorProgress(documentId) {
                    const interval = setInterval(() => {
                        fetch(`/api/progress/${documentId}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.progress !== undefined) {
                                    progressBar.style.width = `${data.progress}%`;
                                    progressStatus.textContent = `Progression: ${data.progress}%`;

                                    if (data.progress >= 100) {
                                        clearInterval(interval);
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Terminé',
                                            text: 'Le traitement est terminé.',
                                        });
                                    }
                                }
                            })
                            .catch(error => {
                                console.error('Erreur de progression:', error);
                                clearInterval(interval);
                            });
                    }, 1000); // Vérifie la progression toutes les secondes
                }
            });
        </script>




        <script>
            const fileInput = document.getElementById('dropzone-file');
            const fileNameDisplay = document.getElementById('file-name');

            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    fileNameDisplay.textContent = `Fichier sélectionné : ${file.name}`;
                } else {
                    fileNameDisplay.textContent = '';
                }
            });

            const uploadBtn = document.getElementById('uploadBtn');
            uploadBtn.disabled = true;

            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    fileNameDisplay.textContent = `Fichier sélectionné : ${file.name}`;
                    uploadBtn.disabled = false;
                } else {
                    fileNameDisplay.textContent = '';
                    uploadBtn.disabled = true;
                }
            });
        </script>
        <script>
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: '{{ session('success') }}',
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: '{{ session('error') }}',
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                });
            @endif
        </script>
    @endsection

</x-app-layout>

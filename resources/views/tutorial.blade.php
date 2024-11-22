<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="../img/logos.svg" loading="lazy">
    <title>Teras KBK || {{ Route::currentRouteName() }} </title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <section class="bg-white p-6 rounded-lg shadow-lg w-full max-w-4xl">
        <div class="video-container mb-4">
            <video id="videoPlayer" controls class="w-full h-96 rounded-lg">
                <source src="{{ $videos->first()['path'] }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="description-container mb-4 text-center">
            <p id="videoDescription" class="text-lg text-gray-700">{{ $videos->first()['filename'] }}</p>
        </div>
        <div class="controls text-center">
            <button id="prevBtn" class="bg-blue-500 text-white px-4 py-2 rounded-lg mr-2 disabled:opacity-50 hover:bg-blue-700">Back</button>
            <button id="nextBtn" class="bg-blue-500 text-white px-4 py-2 rounded-lg mr-2 hover:bg-blue-700">Next</button>
        </div>
    </section>

    <script>
        const videos = @json($videos); // Mengirim data video dari Laravel ke JavaScript

        let currentVideoIndex = 0;
        const videoPlayer = document.getElementById('videoPlayer');
        const videoDescription = document.getElementById('videoDescription');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        function loadVideo(index) {
            videoPlayer.src = videos[index].path;
            videoDescription.textContent = videos[index].filename;
            videoPlayer.load();
            updateButtons();
        }

        function updateButtons() {
            prevBtn.disabled = currentVideoIndex === 0;
            nextBtn.disabled = currentVideoIndex === videos.length - 1;
        }

        prevBtn.addEventListener('click', () => {
            if (currentVideoIndex > 0) {
                currentVideoIndex--;
                loadVideo(currentVideoIndex);
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentVideoIndex < videos.length - 1) {
                currentVideoIndex++;
                loadVideo(currentVideoIndex);
            }
        });

        loadVideo(currentVideoIndex);
    </script>
</body>
</html>

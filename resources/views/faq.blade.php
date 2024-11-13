<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="../img/logos.svg">
    <title>Teras KBK || {{ Route::currentRouteName() }} </title>
    <link rel="stylesheet"
        href="https://rawcdn.githack.com/gragemediatechnology/keyFood/5ac470d94f12d3fd869f505c958e4f359dbde479/public_html/css/faq.css">


    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
</head>

<body>
    <div class="accordion max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="title text-center mb-6">
            <h2 class="text-2xl font-bold sm:text-3xl">FAQ Section</h2>
        </div>
        @foreach ($faqs as $faq)
            <ul class="space-y-4">
                <li class="border-b border-gray-200 pb-4">
                    <input type="radio" name="accordion" id="faq-{{ $loop->index }}" class="hidden peer"
                        {{ $loop->first ? 'checked' : '' }}>
                    <label for="faq-{{ $loop->index }}"
                        class="block text-lg font-medium cursor-pointer hover:text-blue-500">
                        {{ $faq->title }}
                    </label>
                    <div class="content max-h-0 overflow-hidden peer-checked:max-h-full transition-all duration-300">
                        <p class="mt-2 text-gray-600 text-sm sm:text-base">
                            {!! nl2br(e($faq->content)) !!}
                        </p>
                    </div>
                </li>
            </ul>
        @endforeach
    </div>
</body>


</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="../img/logos.svg">
    <title>KeyFood || {{ Route::currentRouteName() }} </title>
    <link rel="stylesheet" href="https://rawcdn.githack.com/jipyy/keyFood/94e3005f001914148945e309f555715db94e24f6/public/css/faq.css">

</head>

<body>
    <div class="accordion">
        <div class="title">
            <h2>FAQ Section</h2>
        </div>
        @foreach ($faqs as $faq)
            <ul class="space-y-4 pl-4">
                <li class="pl-2">
                    <input type="radio" name="accordion" id="faq-{{ $loop->index }}"
                        {{ $loop->first ? 'checked' : '' }}>
                    <label for="faq-{{ $loop->index }}">{{ $faq->title }}</label>
                    <div class="content">
                        <p>{{ $faq->content }}</p>
                    </div>
                </li>
            </ul>
        @endforeach
    </div>
</body>

</html>

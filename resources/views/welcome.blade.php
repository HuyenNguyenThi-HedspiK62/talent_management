
<!DOCTYPE html>
<html>
<title>Talent Management Tool</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<style>
    body,h1 {font-family: "Raleway", sans-serif}
    body, html {height: 100%}
    .bgimg {
        background-image: url('https://www.w3schools.com/w3images/photographer.jpg');
        min-height: 100%;
        background-position: center;
        background-size: cover;
    }
</style>
<body>

<div class="bgimg w3-display-container w3-animate-opacity w3-text-white">
    <div class="w3-display-topright w3-padding-large w3-xlarge">
        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">ログイン</a>
{{--                @if (Route::has('register')) <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a> --}}
{{--                    @endif --}}
                @endauth
            </div>
        @endif
    </div>
    <div class="w3-display-middle">
        <h1 class="w3-jumbo w3-animate-top">タレント管理ツール</h1>
        <hr class="w3-border-grey" style="margin:auto;width:40%">
    </div>
</div>

</body>
</html>

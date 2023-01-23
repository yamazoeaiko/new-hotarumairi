@component('components.app')
@endcomponent
@component('components.header_wide')
@endcomponent
<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif
        <div class="content">
            <div class="title m-b-md">
                Laravel
            </div>
            <div class="links">
                <a href="https://laravel.com/docs"><button class='btn btn-default'>Docs</button></a>
                <a href="https://laracasts.com"><button class='btn btn-primary'>Laracasts</button></a>
                <a href="https://laravel-news.com"><button class='btn btn-success'>News</button></a>
                <a href="https://blog.laravel.com"><button class='btn btn-info'>Blog</button></a>
                <a href="https://nova.laravel.com"><button class='btn btn-warning'>Nova</button></a>
                <a href="https://forge.laravel.com"><button class='btn btn-danger'>Forge</button></a>
                <a href="https://vapor.laravel.com"><button class='btn btn-link'>Vapor</button></a>
                <a href="https://github.com/laravel/laravel"><button class='btn btn-primary'>GitHub</button></a>
            </div>
        </div>
    </div>
</body>

</html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title', 'Siatri')
    </title>
    {{ HTML::style('css/lib/bootstrap.min.css') }}
    {{ HTML::style('css/lib/font-awesome.min.css') }}
    {{ HTML::style('//fonts.googleapis.com/css?family=Montserrat') }}
    {{ HTML::style('css/global.css') }}
    @yield('styles')

</head>

<body>
    @if (!$errors->isEmpty())
        <span class="alert alert-info"> {{$errors->first('info') }} </span>
    @endif
    <section class="intro">
        <div class="intro-text">
            @if (Session::has('user'))
                <a class="pull-right btn btn-info" href="/logout">Logout</a>
            @else
                <a class="pull-right btn btn-info" href="/login">Login</a>
            @endif

            <h1 class="logo">
                <span class="fa-comments fa-question color midnight-blue">siatri</span>
            </h1>
            <h4>semantic social trivia</h4>
        </div>
    </section>
    <section class="content">
        @section('content')
            This is the default content shown  if not overriden in child templates. <br>
            @if (Session::has('user'))
            Hello {{ Session::get('user') }}
            @endif
        @show
    </section>
    
    {{ HTML::script('js/lib/jquery-2.0.3.js') }} 
    {{ HTML::script('js/global.js') }}
    @yield('scripts')

</body>

</html>

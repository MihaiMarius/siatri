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
   <!--  <div class="col-sm-6 col-md-6">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    ×</button>
               <span class="glyphicon glyphicon-ok"></span> <strong>Success Message</strong>
                <hr class="message-inner-separator">
                <p>
                    You successfully read this important alert message.</p>
            </div>
        </div> -->
        <section class="intro">
            <div class="intro-text">
                <h1 class="logo">
                    <span class="fa-comments fa-question color midnight-blue">siatri</span>
                </h1>
                <h4>semantic social trivia</h4>
            </div>
            @yield('menubuttons')
           
        </section>
        <section class="content">
            @section('content')
            This is the default content shown {{-- (notice the @show) --}} if not overriden in child templates. <br>
            Session cleared.
            @show
        </section>

        {{ HTML::script('js/lib/jquery-2.0.3.js') }} 
        {{ HTML::script('js/lib/knockout-3.0.0.debug.js') }} 
        {{ HTML::script('js/global.js') }}
        @yield('scripts')

    </body>

    </html>

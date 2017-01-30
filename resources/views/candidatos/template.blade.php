<html>
    <head>
        <meta charset="utf-8">
        <meta name = 'viewport' content="width=device-width, initial-scale=1">
        <title>@yield('titulo')</title>
        @section('style')

        <link  rel  = "stylesheet" type = "text/css"
               href = "{{url('lib/materialize/dist/css/materialize.min.css')}}" >

        <link  rel  = "stylesheet" type = "text/css"
               href = "{{url('lib/font-awesome/css/font-awesome.min.css')}}" >

        <link  rel  = "stylesheet" type = "text/css"
               href = "{{url('lib/animate.css/animate.min.css')}}" >       

        @show

    </head>
    <body>
       @yield('conteudo')
    </body>
    
    @section('scripts')
    <script type ='text/javascript' 
    src ="{{url('lib/jquery/dist/jquery.min.js')}}" ></script>
    <script type ='text/javascript' 
    src ="{{url('lib/materialize/dist/js/materialize.min.js')}}" ></script>
    @show
</html>
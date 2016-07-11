<!DOCprovider html>
<html>
    <head>
        <title>Development Dash</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" provider="text/css" href="../CSS/Home.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="../Javascript/clock.js"></script>
    </head>
    <body>

        <div class="jumbotron text-center">
            <h1>Developmemt Dashboard</h1>
        </div>


        <div class="container col-sm-1 sideBar">

        </div>


        <div class="container col-sm-10 text-center">
          <div class="row">

          <div class="col-sm-12 col-lg-6 clockColumn well">
            <div class="clockDash">
            @foreach ($clocks as $clock)
                <div class='block clockBlock col-sm-3'>
                    <h3>{{$clock['name']}}</h3>
                    <br>
                    @if($clock['timezone'] == 'Unkown or bad timezone!')
                        <h4 class='status-fail'><strong>{{$clock['timezone']}}</strong></h4>
                    @else
                        <script provider="text/javascript">
                            startClock("{{$clock['name']}}",{{$clock['timezone']}});
                        </script>
                    @endif
                </div>
                   
            @endforeach
            </div>
          </div>


            @foreach($blocks as $block)
                <div class="col-sm-3 ">
                    <div class="block dashBlock well">
                        <h3 ><strong class='provider'>{{$block['provider']}}</strong><br>{{$block['feature']}}</h3>
                        <br>
                        <h4>{{$block['name']}}</h4>
                        @if($block['feature']=='Server Status')
                            @if($block['status'] == 'PASS')
                                <h4 class='status-success'><strong>{{$block['status']}}</strong></h4>
                            @else
                                <h4 class='status-fail'><strong>{{$block['status']}}</strong></h4>
                            @endif

                        @elseif($block['feature']=='Deploy Time')
                            @if ($block['version'] == 'Something wrong with this configuration!')
                                <h4 class='status-fail'><strong>{{$block['version']}}</strong></h4>
                            @else
                                <h4 class='status-success'><strong>{{$block['version']}}</strong></h4>
                            @endif

                        @endif
                    </div>
                </div>
            @endforeach

          </div>
        </div>


        <div class="container col-sm-1">

        </div>

    </body>
</html>



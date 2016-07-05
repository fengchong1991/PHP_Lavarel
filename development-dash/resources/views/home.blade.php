<!DOCTYPE html>
<html>
    <head>
        <title>Development Dash</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        
    
    <style>
        .dashBlock{
            padding: 1px 1px 20px 1px;
        }

        .sideBar{
            overflow-y: scroll;
            overflow-wrap: break-word;
        }

    </style>

    </head>
    <body>

        <div class="jumbotron text-center">
            <h1>Developmemt Dash</h1>
        </div>


        <div class="container col-sm-2 well sideBar">

        </div>


        <div class="container col-sm-8 text-center">
          <div class="row">
            <div class="col-sm-3 ">
              <div class="dashBlock well">
                    <h3 class="text-center">Github</h3>
                    <br>
                    <h4>Open pull request: {{$GH_OpenPullRequest}}</h4>
              </div>
            </div>

            <div class="col-sm-3 ">
                <div class="dashBlock well">
                    <h3 class="text-center">Gitlab</h3>
                    <br>
                    <h4></h4>
                </div>
            </div>


            <div class="col-sm-3 ">
                <div class="dashBlock well">
                    <h3 class="text-center">easyEmployer</h3>
                    <br>
                    <h4></h4>
                </div>
            </div>

            <div class="col-sm-3 ">
                <div class="dashBlock well">
                    <h3 class="text-center">Jira</h3>
                    <br>
                    <h4></h4>
                </div>
            </div>
        
          </div>
        </div>


        <div class="container col-sm-2 well">

        </div>

    </body>
</html>



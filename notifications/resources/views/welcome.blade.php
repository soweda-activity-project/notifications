<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>


        <div id="token"></div>
        <div id="msg"></div>
        <div id="notis"></div>
        <div id="err"></div>

        <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase-auth.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase-database.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase-firestore.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase-messaging.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase-functions.js"></script>






        <script>


            MsgElem = document.getElementById("msg")
            TokenElem = document.getElementById("token")
            NotisElem = document.getElementById("notis")
            ErrElem = document.getElementById("err")

            // Initialize Firebase

            var config = {
                apiKey: "AIzaSyBtsG6NyFuWMTESi1wkds5oDl5jAvw0LqY",
                authDomain: "soweda-web-notification.firebaseapp.com",
                databaseURL: "https://soweda-web-notification.firebaseio.com",
                projectId: "soweda-web-notification",
                storageBucket: "",
                messagingSenderId: "377998634966"
            };
            firebase.initializeApp(config);


            const messaging = firebase.messaging();

            messaging.requestPermission()
                .then(function () {


                    MsgElem.innerHTML = "Notification permission granted."
                    console.log("Notification permission granted.");

                    // get the token in the form of promise
                    return messaging.getToken();
                })
                .then(function(token) {
                    TokenElem.innerHTML = "token is : " + token
                })
                .catch(function (err) {
                    ErrElem.innerHTML =  ErrElem.innerHTML + "; " + err
                    console.log("Unable to get permission to notify.", err);
                });

            messaging.onMessage(function(payload) {
                console.log("Message received. ", payload);
                NotisElem.innerHTML = NotisElem.innerHTML + JSON.stringify(payload)
            });

        </script>




        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>



</html>




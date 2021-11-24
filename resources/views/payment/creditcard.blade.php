<html>

<head>
    <title>Wyre widget</title>
</head>
<style>
    .container {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        min-height: 100vh;
        background-color: #ededed;
    }

    .loader {
        max-width: 15rem;
        width: 100%;
        height: auto;
        stroke-linecap: round;
    }

    circle {
        fill: none;
        stroke-width: 3.5;
        -webkit-animation-name: preloader;
        animation-name: preloader;
        -webkit-animation-duration: 3s;
        animation-duration: 3s;
        -webkit-animation-iteration-count: infinite;
        animation-iteration-count: infinite;
        -webkit-animation-timing-function: ease-in-out;
        animation-timing-function: ease-in-out;
        -webkit-transform-origin: 170px 170px;
        transform-origin: 170px 170px;
        will-change: transform;
    }

    circle:nth-of-type(1) {
        stroke-dasharray: 550;
    }

    circle:nth-of-type(2) {
        stroke-dasharray: 500;
    }

    circle:nth-of-type(3) {
        stroke-dasharray: 450;
    }

    circle:nth-of-type(4) {
        stroke-dasharray: 300;
    }

    circle:nth-of-type(1) {
        -webkit-animation-delay: -0.15s;
        animation-delay: -0.15s;
    }

    circle:nth-of-type(2) {
        -webkit-animation-delay: -0.3s;
        animation-delay: -0.3s;
    }

    circle:nth-of-type(3) {
        -webkit-animation-delay: -0.45s;
        -moz-animation-delay: -0.45s;
        animation-delay: -0.45s;
    }

    circle:nth-of-type(4) {
        -webkit-animation-delay: -0.6s;
        -moz-animation-delay: -0.6s;
        animation-delay: -0.6s;
    }

    @-webkit-keyframes preloader {
        50% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @keyframes preloader {
        50% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

</style>

<body>

    <div class="container">

        <svg class="loader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 340 340">
            <circle cx="170" cy="170" r="160" stroke="#E2007C" />
            <circle cx="170" cy="170" r="135" stroke="#404041" />
            <circle cx="170" cy="170" r="110" stroke="#E2007C" />
            <circle cx="170" cy="170" r="85" stroke="#404041" />
        </svg>

    </div>
    <div id="wyre-dropin-widget-container"></div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://verify.sendwyre.com/js/verify-module-init-beta.js"></script>
    <script type="text/javascript">
        var widget;
        (function($) {
            var jobs = "{{ $result['reservation'] }}";
            // debit card popup
            widget = new Wyre({
                env: 'test',
                reservation: jobs,
                /*A reservation id is mandatory. In order for the widget to open properly you must use a new, unexpired reservation id. Reservation ids are only valid for 1 hour. A new reservation must also be made if a transaction fails.*/
                operation: {
                    type: 'debitcard-hosted-dialog'
                }
            });

            widget.on("Failure", function(e) {
                alert("here");
            });


            widget.on("paymentSuccess", function(e) {
                console.log("paymentSuccess", e);
            });

            setTimeout(function() {
                 widget.open()
            }, 2000);

        })(jQuery);
    </script>
</body>

</html>

<html>
    <head>
        <title>Verify with Wyre</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    </head>
    <body>
        <div class="container">
            <button id="verify-button" class="btn btn-primary mt-5">Verify with Wyre</button>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="https://verify.sendwyre.com/js/verify-module-init.js"></script>
        <script type="text/javascript">
            (function($) {
                var handler = new Wyre({
                        apiKey: "AK-7Y9AZAF4-WWUPDEHW-V7YELGCA-EQCE2UCC",
                        env: "test",
                        destCurrency: "BTC", // optional, defaults to ETH
                        onExit: function (error) {
                            if (error != null)
                                console.error(error)
                            else
                                console.log("exited!")
                        },
                        onSuccess: function () {
                            console.log("success!")
                        }
                    });
                $('#verify-button').on('click', function(e) {
                    handler.open();
                });
            })(jQuery);
        </script>
    </body>
</html>
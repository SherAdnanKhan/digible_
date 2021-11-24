<!DOCTYPE html>
<html>
<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
  <script src="https://cdn.plaid.com/link/v2/stable/link-initialize.js"></script>
  <script src="https://verify.sendwyre.com/js/pm-widget-init.js"></script>
  <script type="text/javascript">
    var handler = new WyrePmWidget({
      env: "test",
      onLoad: function(){
        // In this example we open the modal immediately on load. More typically you might have the handler.open() invocation attached to a button.
        handler.open();
      },
      onSuccess: function(result){
        // Here you would forward the publicToken back to your server in order to  be shipped to the Wyre API
        console.log(result.publicToken);
        window.alert(result.publicToken);
      },
      onExit: function(err){
        if (err != null) {
          // The user encountered an error prior to exiting the module
        }
        console.log("Thingo exited:", err);
      }
    });
    
  </script>
</head>
<body>

</body>
</html>
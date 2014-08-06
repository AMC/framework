<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <base href='http://thesis.andrewcanfield.com/framework/'>

  <title>
    Web
  </title>
  
  <link rel="stylesheet" href="lib/normalize.css">
  <link rel="stylesheet" href="lib/web.css">
  <link rel="stylesheet" href="web/styles/web.css">

</head>


<body>


  <div id='controls'>
    <h1>Web</h1>
    

    <button id='getButton' class='cg_button'>Blogs</button>
    <button id='newButton' class='cg_button'>New</button>

  </div>
  
  <div id='response'></div>


  <script src="lib/candygram.js"></script>
  <script src="web/scripts/web.js"></script>

  <script>
    document.querySelector("#getButton").onclick = function() {
      var endpoint = 'http://thesis.andrewcanfield.com/framework/Blog';
      //var id = document.querySelector("#id").value;
      var properties = ["author", "title", "post"];
      var outputSelector = '#response';
      
      get(endpoint)
        .then(
          function(response) {
            //listView(endpoint, outputSelector, response, properties);
            listView(endpoint, outputSelector, response);
          },
          function(error) {
          console.log('error', error);
        });
    };
  
  
    document.querySelector("#newButton").onclick = function() {
      var endpoint = 'http://thesis.andrewcanfield.com/framework/Blog';
      var method = 'post';
      var outputSelector = '#response';

      options(endpoint)
        .then(function(response) {
         
          createForm(endpoint, method, response, outputSelector);
        });
    };
  </script>
  
</body>
</html>
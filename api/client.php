<?php
  
  function getModels($endpoint) {
    $options = array(
      "http" => array(
        "method" => "get",
        'header' => "Accept-language: en\r\n" . "Cookie: foo=bar\r\n",
      )
    );
    $context = stream_context_create($options);
    $response = json_decode(file_get_contents($endpoint, false, $context));

    return $response->data;
  }
  
  
  
?>

<!doctype html>
<html>
<head>
  <title>Javascript Client</title>
  
  <style>
    div {
      box-sizing: border-box;
    }
    
    #new.active {
      display: block;
    }
    
    #new {
      display: none;
    }
    
    #articles {
      display: none;
    }
    
    .ok {
      background: green;
      color: white;
    }
    
    .error {
      background: red;
      color: white;
    }
    
    body {
      background: #666;
    }
  
    #articles,
    #menu, 
    #new {
      width: 600px;
      margin: 0px auto 20px;
      border-radius: 5px;
      padding: 10px 10px;
      background: #eee;
      border: 2px solid #999;
    }
    
    .article {
      border: 1px solid #999;
      background: #fff;
      border-radius: 5px;
      padding: 5px;
      margin-bottom: 10px;
      width: 550px;
    }
    
    input,
    button {
      display: block;
      font-size: 14px;
      border-radius: 5px;
      margin: 5px 0px 10px;
    }

    input {
      border: 1px solid #999;
      background: #fff;
      color: #333;
      width: 550px;
    }

    
    button {
      border: 2px solid darkgreen;
      background: green;
      color: white;
      padding: 5px 10px;
    }
    
    button:hover {
      background: darkgreen;
    }
  </style>
</head>
<body>
  <div id='menu'>
    <button id='btnNew'>new</button>
  </div>
  
  <div id='new'>
  </div>
  
  
  <div id='articles'>
    <?php $models = getModels("http://thesis.andrewcanfield.com/framework"); ?>
    <?php foreach ($models as $m) { ?>
      <div class='article'>
        <h2><?=$m->author->value; ?></h2>
        <p><?=$m->post->value; ?></p>
      </div>
    <?php } ?>
  </div>
  

  
  
  <script>
    window.onload = function(e) {
      console.log("start");
      

      createRequest("post", "http://thesis.andrewcanfield.com/framework/api/index.php")
        .then(function(response) {
          console.log(response);
        });

    }
    

    
    function createRequest(method, endpoint, data) {
      console.log("createRequest");
      return new Promise(function (resolve, reject){
        var request = new XMLHttpRequest();
        var dataString = "";
        
        if (isObject(data)) {
          for (var property in data) 
            dataString = property + "=" + data[property] + "&";
          dataString = dataString.substring(0, formData.lastIndexOf('&'));
        }
        request.onload = function() {
          if (request.readyState == 4 && request.status == 200)
            resolve(request.response);
          else
            reject(Error("Unable to create request."));
        }
        
 
        
        if (method.toLowerCase() == 'get') {
          request.open(method.toUpperCase(), encodeURI(endpoint + dataString));
          request.send();
        } else if (method.toLowerCase() == 'post' || method.toLowerCase() == 'put' || method.toLowerCase() == 'delete' || method.toLowerCase() == 'options'){
          console.log(method);
          request.open(method.toUpperCase(), encodeURI(endpoint));
          request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
          request.send(encodeURI(dataString));
        } else {
          Error("Unable to create request. Invalid method specified: ", method);
        }
        
        
      }); // end promise
        
    } // end function
    
    function isObject(obj) {
      return (obj !== null && typeof obj === 'object' && !isArray(obj));
    }
    
    function isArray(obj) {
      return toString.call(obj) === "[object Array]";
    }
    


  </script>
</body>
</html>
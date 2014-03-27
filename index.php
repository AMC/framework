<!doctype html>
<html>
<head>
  <style>
    html,
    body {
      min-width: 100%;
      min-height: 100%;
      background: #333;
      font-size: 1.2em;
    }
  
    input,
    select
    {
      display: block;
      width: 250px;
      margin-bottom: 10px;
      border: 1px solid #666;
      border-radius: 2px;
      background: #fff;
      padding: 5px;
    }
    
    #results {
      white-space: pre;
      font-family: monospace;
      font-size: 11px;
    }
    
    .container {
      width: 600px;
      margin: 0px auto 20px;
      background: #fff;
      padding: 10px;
      border-radius: 5px;
    }
  </style>
  
</head>

<body>

  <div class='container'>
    <h3>Index.php</h3>
    
    <input type='text' name='uri' id='uri' placeholder='uri' value='192.168.56.102/framework'>

    <select name='method' id='method'>
      <option>get</option>
      <option>post</option>
      <option>put</option>
      <option>delete</option>
      <option>options</option>
    </select>

    <select name='controller' id='controller'>
      <option>controller</option>
    </select>
  
    <input type='text'  name='id'       id='id'        placeholder='id'>
    <input type='text'  name='action'   id='action'    placeholder='action'>
    <input type='text'  name='limit'    id='limit'     placeholder='limit'>
    <input type='text'  name='skip'     id='skip'      placeholder='skip'>

    <br>
    
    <input type='text'  name='properties' class='properties'  placeholder='property' value='a'>
    <input type='text'  name='values'    class='values'     placeholder='value' value='x'>
    <input type='text'  name='properties' class='properties'  placeholder='property' value='b'>
    <input type='text'  name='values'    class='values'     placeholder='value' value='y'>
    <input type='text'  name='properties' class='properties'  placeholder='property' value='c'>
    <input type='text'  name='values'    class='values'     placeholder='value' value='z'>

    
    <button name='btnRequest' id='btnRequest'>make request</button>

  </div>

    <div id='results' class='container'>
    </div>
  

  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

  <script>
    function makeRequest(uri, method, data) {
      console.log("request");
      console.log(uri);
      console.log(method);
      console.log(data)
      console.log("...");
      $.ajax({
        type: method,
        url: uri,
        data: data,
        success: function(data, status, xhr) {
          //console.log(data);
          console.log(status);
          //console.log(xhr);
          $("#results").text(JSON.stringify(data, undefined, 2));
        },
      }); 
    }

  
    $(document).ready(function(){
      console.log("ready!");
      
      $("#btnRequest").on("click", function(){
        console.log("click!");
        
        var uri = $("#uri").val()
        var method = $("#method").val();
        var controller = $("#controller").val();
        var id = $("#id").val();
        var action = $("#action").val();
        var limit = $("#limit").val();
        var skip = $("#skip").val();

        var properties = [];        
        var values = [];
        
        $(".properties").each(function() {
          properties.push($(this).val());
        });
        
        $(".values").each(function() {
          values.push($(this).val());
        });

        data = new Object();
        data.action = $("#action").val();
        data.limit = $("#limit").val();
        data.skip = $("#skip").val();
        data.params = [];
        for (i = 0; i < properties.length; i++) 
          data.params[properties[i]] = values[i];
        
        makeRequest(uri.concat("/", controller, "/", id), method, data);
        
      }).focus();
    });

  </script>

</body>
</html>
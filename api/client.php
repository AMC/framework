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
    window.onload = main;

    
    function main() {
      document.getElementById('btnNew').onclick = function() {
        displayNew("http://thesis.andrewcanfield.com/framework", "#new");
      }
      
      //document.querySelector("#btnNew").click();
    } // end function
    
/*    
    function linkButton(buttonSelector, destinationSelector, method, endpoint) {
      document.getElementById(buttonSelector).onclick = function () {
        
      }
    }
*/    
    function displayNew(endpoint, destination) {
      get(endpoint)
        .then(JSON.parse)
        .then(function(response) {
          return new Model(response.data);
        })
        .then(function(model) {

          model.editView(destination);
        })
        .catch(function(error){
          console.log("An error occurred: ", error);
        });

      
    } // end function
    
    function Model(obj) {
      this['name'] = obj['class'];
      for (var property in obj) {
          
          var value = obj[property];
          
          if (isObject(value) && !isArray(value)) 
            this[property] = new Component(property, obj[property]);
          //else if (!isArray(value))
            //this[property] = value;

      } // end for loop
    } // end function
    
    Model.prototype.editView = function (destination) {
      var element = document.querySelector(destination);
      element.classList.add("active");
      element.innerHTML = "";

      for(var property in this) {
        
        if (isObject(this[property]))
          element.innerHTML += this[property].editView();
      }
      
      element.innerHTML += "<button id='btnSave'>Save</button>";
      document.querySelector("#btnSave").onclick = function () {
        saveModel(destination);
      };
    }
    
    function saveModel(destination) {
      var element = document.querySelector(destination);
      element.classList.remove("active");
      
      for (var child in element.getChildren()) {
        
        console.log(typeof child);
      }
      
    }
    
    function checkIfValid() {
      // apply to each edit box

      var regex = new RegExp(this.dataset.validation);

      if (regex.test(this.value)) {
        this.classList.add("ok");
        this.classList.remove("error");
      } else { 
        this.classList.add("error");
        this.classList.remove("ok");
      }

      console.log(this);
    }
    
    function Component(name, obj) {
      //console.log("*** component");
      this.name       = name;
      this.value      = obj['value'];
      this.type       = obj['class'];
      this.required   = obj['required'];
      this.validation = obj['validation'].toString().replace(/\//g, '');
    } // end function
    
    Component.prototype.isValid = function() {
      if (this.required && this.value.length == 0)
        return false;

      var regex = new RegExp(this.validation);

      return regex.test(this.value);
    }
    
    Component.prototype.editView = function() {
      var result  = "";

      result += "<label for='" + this.name + "' ";
      result += "class='" + this.type + "' ";
      result += ">" + this.name + ":</label>";

      result += "<input type='text' ";
      result += "name='" + this.name + "' ";
      result += "placeholder='" + this.name + "' ";
      result += "class='" + this.type + "' ";
      result += "data-validation='" + this.validation + "' ";
      result += "onkeyup='checkIfValid.call(this)' ";
      result += "/>";

      return result;
    }
    
    function get(url) {
      return new Promise(function(resolve, reject) {
        var request = new XMLHttpRequest();
        request.open('OPTIONS', url);
        
        request.onload = function() {
          if (request.readyState == 4 && request.status == 200)
            resolve(request.response);
          else
            reject(Error(request.statusText));
        };
        
        request.onerror = function() {
          reject(Error("Network Error"));
        };
        
        request.send();
      });
    }
    
    function getRequest(endpoint, data, callback) {
      request = new XMLHttpRequest();
      var queryString = "?";
      if (typeof data !== undefined) {
        for (var key in data) 
          queryString += key + "=" + data[key] + "&";
          
        // remove trailing ampersand
        queryString = queryString.substring(0, queryString.lastIndexOf('&'));
      } // end if
      
      if (typeof callback !== undefined) 
        request.onreadystatechange = callback;

      request.open("GET", encodeURI(endpoint + queryString), true);
      request.send();
    } // end function
      
    function postRequest(endpoint, data, callback) {
      request = new XMLHttpRequest();
      var formData = "";
      if (typeof data !== undefined) {
        for (var key in data) 
          formData += key + "=" + data[key] + "&";
          
        // remove trailing ampersand
        formData = formData.substring(0, formData.lastIndexOf('&'));
      } // end if
      
      if (typeof callback !== undefined) 
        request.onreadystatechange = callback;

      request.open("POST", endpoint, true);
      request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      request.send(encodeURI(formData));
    } // end function
    
    function putRequest(endpoint, data, callback) {
      request = new XMLHttpRequest();
      var formData = "";
      if (typeof data !== undefined) {
        for (var key in data) 
          formData += key + "=" + data[key] + "&";
          
        // remove trailing ampersand
        formData = formData.substring(0, formData.lastIndexOf('&'));
      } // end if
      
      if (typeof callback !== undefined) 
        request.onreadystatechange = callback;

      request.open("PUT", endpoint, true);
      request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      request.send(encodeURI(formData));
    }
    
    function deleteRequest(endpoint, data, callback) {
      request = new XMLHttpRequest();
      var formData = "";
      if (typeof data !== undefined) {
        for (var key in data) 
          formData += key + "=" + data[key] + "&";
          
        // remove trailing ampersand
        formData = formData.substring(0, formData.lastIndexOf('&'));
      } // end if
      
      if (typeof callback !== undefined) 
        request.onreadystatechange = callback;

      request.open("DELETE", endpoint, true);
      request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      request.send(encodeURI(formData));
    }
    
    function optionsRequest(endpoint, data, callback) {
      request = new XMLHttpRequest();
      var formData = "";
      if (typeof data !== undefined) {
        for (var key in data) 
          formData += key + "=" + data[key] + "&";
          
        // remove trailing ampersand
        formData = formData.substring(0, formData.lastIndexOf('&'));
      } // end if
      
      if (typeof callback !== undefined) 
        request.onreadystatechange = callback;

      request.open("OPTIONS", endpoint, true);
      request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      request.send(encodeURI(formData));
    }
    
    function toConsole() {
     if (request.readyState != 4)
        return;

      if (request.status != 200)
        return;
        
      response = JSON.parse(request.response);
      console.log(response);
    }
    
    function isObject(arg) {
      return (arg !== null && typeof arg === 'object' && !isArray(arg));
    }
    
    function isArray(arg) {
      if (typeof arg != 'object')
        return false;
        
      return (arg.constructor.toString().match(/array/i) != null)
    }
    
    function isNull(arg) {
      if (arg === null)
      //if ((arg !== undefined) && (arg !== null || arg != 'null'))
        return true;
      return false;
    }
    
    
    
    
  
  </script>
</body>
</html>
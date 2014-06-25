<head>
<style>
  input, 
  textarea {
    display: block;
    width: 100%;
    padding: 5px;
    border-radius: 5px;
    background: #fff;
    border: 1px solid #666;
    font-size: 14px;
  }
  
  input[type='submit'] {
    background: green;
    color: white;
    font-size: 14px;
  }
  
  input[type='submit']:hover {
    background: darkgreen;
  }
  
  textarea {
    height: 100px;
  }
  
  form {
    display: block;
    width: 250px;
    margin: 0px auto 25px;
  }
  
  h2 {
    margin: 0;
  }
  
  #admin {
    background: #000;
    color: #fff;
    display: inline;
    padding: 5px;
    position: absolute;
    top: 0;
    left: 0;
  }
  
  .error {
    border: 1px solid darkred;
    background: red;
    color: white;
  }
  
  .ok {
    border: 1px solid darkgreen;
    background: green;
    color: white;
  }
</style>
</head>

<body onload='onload()'>

  <div id='editor'>
  </div>

<script>

function Component(name, value, type, required, validation) {
  this.name       = name;
  this.value      = value;
  this.type       = type;
  this.required   = required;
  this.validation = validation.toString().replace(/\//g, '');

  
}

Component.prototype.isValid = function() {
  if (this.required && this.value.length == 0)
    return false;
    
  var regex = new RegExp(this.validation);
  
  return regex.test(this.value);
}

Component.prototype.toString = function() {
  return this.value;
}

Component.prototype.edit = function() {
  var result  = "";
  
  result += "<label for='" + this.name + "' ";
  result += "class='" + this.type + "' ";
  result += ">" + this.name + " </label>";
  
  result += "<input type='text' ";
  result += "name='" + this.name + "' ";
  result += "placeholder='" + this.name + "' ";
  result += "class='" + this.type + "' ";
  result += "data-validation='" + this.validation + "' ";
  result += "onkeyup='checkIfValid.call(this)' ";
  result += "/>";
  
  return result;
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


function Model(endpoint) {
  this.endpoint = endpoint;
  this.json = null;
}

Model.prototype.new = function() {
  this.json = "hello world";
  jsonRequest = new XMLHttpRequest();
  jsonRequest.onreadystatechange = function() {
    if (jsonRequest.readyState == 4)
      alert(JSON.parse(jsonRequest.responseText));
  }
  jsonRequest.open("OPTIONS", this.endpoint, true);
  jsonRequest.send();
}

function onload() {
  document.getElementById("editor").innerHTML += c.edit();
}

var m = new Model("http://thesis.andrewcanfield.com");

var c = new Component("Author", "123", "Integer", true, /^\d+$/);

</script>

</body>
// TODO: change create button to a button function

// createGetButton('http://thesis.andrewcanfield.com/framework', 'Blogs', '#controls', '#response', '#id');




// remove?
/*
function createGetButton(endpoint, buttonText, buttonSelector, outputSelector, inputSelector) {
  var buttonOutputElement = document.querySelector(buttonSelector);
  var outputElement = document.querySelector(outputSelector);
  
  if (inputSelector !== undefined)
    var inputElement = document.querySelector(inputSelector);
  
  var button = document.createElement('button');
    button.appendChild(document.createTextNode(buttonText));
    button.classList.add('cg_button');
    button.onclick = function() {
      if (inputElement)
        var id = inputElement.value;

      get(endpoint, id)
        .then(
          function(response) {
            var properties = ["author", "title", "post"]
            listView(endpoint, "#response", response);
          },
          function(error) {
          console.log('error', error);
        });
    };
  
  buttonOutputElement.appendChild(button);
}
*/


function detailView(selector, endpoint, id) {
  var outputElement = document.querySelector(selector);
  outputElement.innerHTML = "";
  console.log("detailView", endpoint, id);
}


function createForm(endpoint, method, data, outputSelector) {
  //endpoint = 'http://thesis.andrewcanfield.com/framework/Blog';
  
  var outputElement = document.querySelector(outputSelector);
    outputElement.innerHTML = "";
    
  var form = document.createElement('form');
    form.action = endpoint;
    form.method = method;
    form.enctype = "multipart/form-data";
    
    form.onsubmit = function() {
      return false;
    }
  
  outputElement.appendChild(form);
  
  var element = document.createElement("input");
    element.id = '_id';
    element.name = '_id';
    element.type = 'hidden';
    element.value = data._id;
    
  form.appendChild(element);
    
  var label = document.createElement("label");
    label.setAttribute('for', 'visibility');
    label.appendChild(document.createTextNode("visibility"));
    label.classList.add('cg_label');
    
  var visibility = document.createElement('select');
    visibility.setAttribute('id', 'visbility');
    visibility.classList.add('cg_select');
  
  var options = ['private', 'group', 'public'];
  for (var i = 0; i < options.length; i++) {
    var option = document.createElement('option');

    option.setAttribute('value', options[i]);
    option.text = options[i];
    visibility.appendChild(option);
  }

  form.appendChild(label);
  form.appendChild(visibility);
  
  for (key in data) {
    var component = data[key];
    
    if (!isObject(component))
      continue;
      
    var label = document.createElement("label");
      label.setAttribute('for', key);
      label.appendChild(document.createTextNode(key));

    if (component['class'].toLowerCase() === 'textarea') {
      var element = document.createElement('textarea');
      if (component.value !== null)
        element.appendChild(document.createTextNode(component.value));
    } else {
      var element = document.createElement('input');  

      if (component.value !== null)
        element.value = component.value;
    }

    element.id = key;
    element.name = key;
    element.pattern = component.validation;

    element.onkeyup = function() {
      var regex = new RegExp(this.pattern);
      if (regex.test(this.value)) {
        this.classList.remove('cg_fail');
        this.classList.add('cg_success');
      } else {
        this.classList.remove('cg_success');
        this.classList.add('cg_fail');
      }
    };

    element.onchange = function() {
      var regex = new RegExp(this.pattern);
      if (regex.test(this.value)) {
        this.classList.remove('cg_fail');
        this.classList.add('cg_success');
      } else {
        this.classList.remove('cg_success');
        this.classList.add('cg_fail');
      }
    };

    element.type = component['class'];
    element.classList.add('cg_input');

    form.appendChild(label);
    form.appendChild(element);
  }
    
  var button = document.createElement("button");
    button.appendChild(document.createTextNode('save'));
    button.classList.add('cg_button');
    
    button.onclick = function() {
      post(this.form);
      this.form.classList.add('cg_submitted');
    }
  
  form.appendChild(button);
}


function createFormElement() {
  
}


// TODO: change create button to a button function

// createGetButton('http://thesis.andrewcanfield.com/framework', 'Blogs', '#controls', '#response', '#id');








document.querySelector("#post").onclick = function() {
  post()
    .then(function(response) {
      console.log(response);
    })
};

document.querySelector("#put").onclick = function() {
  put()
    .then(function(response) {
      console.log(response);
    })
};

document.querySelector("#delete").onclick = function() {
  del()
    .then(function(response) {
    console.log(response);
  });
};

// remove?
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


function detailView(selector, endpoint, id) {
  var outputElement = document.querySelector(selector);
  outputElement.innerHTML = "";
  console.log("detailView", endpoint, id);
}


function createForm(endpoint, method, data, outputSelector) {
  var outputElement = document.querySelector(outputSelector);
    outputElement.innerHTML = "";
    
  var form = document.createElement('form');
    form.action = endpoint;
    form.method = method;
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
  
  console.log(data);
  
  for (key in data) {
    var component = data[key];
    console.log(key, component);
    
    if (!isObject(component))
      continue;
      
    console.log('.');
    var label = document.createElement("label");
      label.setAttribute('for', key);
      label.appendChild(document.createTextNode(key));

    console.log('.');
    console.log(component.type);
    if (component.type.toLowerCase() === 'textarea') {
      console.log('*');
      var element = document.createElement('textarea');
      if (component.value !== "null")
        element.appendChild(document.createTextNode(component.value));
    } else {
      console.log('#');
      var element = document.createElement('input');  

      if (component.value !== "null")
        element.value = component.value;
    }

    console.log('.');
    element.id = key;
    element.name = key;
    element.pattern = component.validation;

    console.log('.');
    element.onkeyup = function() {
      var regex = new RegExp(this.pattern);
      if (regex.test(this.value)) {
        this.classList.remove('error');
        this.classList.add('success');
      } else {
        this.classList.remove('success');
        this.classList.add('error');
      }
    };

    console.log('.');
    element.onchange = function() {
      var regex = new RegExp(this.pattern);
      if (regex.test(this.value)) {
        this.classList.remove('error');
        this.classList.add('success');
      } else {
        this.classList.remove('success');
        this.classList.add('error');
      }
    };

    console.log('.');
    element.type = component.type;
    element.classList.add('cg_input');

    console.log('.');
    form.appendChild(label);
    form.appendChild(element);
  }
    
  var button = document.createElement("button");
    button.appendChild(document.createTextNode('submit'));
    button.classList.add('cg_button');
    
    button.onclick = function() {
      // get method
      // send data
      var formData = new FormData(this.form);
      console.log(formData);
      
      this.disabled = true;
    }
  
  
  console.log(button);
  form.appendChild(button);
  
  console.log('fin');
}


function createFormElement() {
  
}


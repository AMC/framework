function get(endpoint, id) {
  return new Promise(function(resolve, reject) {
    var queryString;
    var request;
    
    if (id)
      queryString = "?id=" + id;
    else
      queryString = "";
    
    request = new XMLHttpRequest();
    request.withCredentials = true;

    request.onload = function() {
      if (request.status == 200) {
        console.log("get", request.response);
        resolve(JSON.parse(request.response).data);
      } else {
        console.log("rejected");
        reject(Error(request.statusText));
        
      }
    }
    
    request.onerror = function() {
      reject(Error("an error occured"));
    }


    request.open('GET', endpoint + queryString, true);
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send();
  });
}


function post(form) {
  return new Promise(function(resolve, reject) {
    var request;
    var queryString = "?";
    
    for (var i = 0; i < form.elements.length; i++) {
      var element = form.elements[i];
      console.log(element, element.type);
      if (element.value != '')
        queryString +=  element.id + "=" + element.value + "&";
    }
    
    request = new XMLHttpRequest();
    request.withCredentials = true;

    request.onload = function() {
      if (request.status == 200) {
        console.log('gu', request.response);
        resolve(JSON.parse(request.response).data);
      } else {
        console.log("rejected");
        reject(Error(request.statusText));
        
      }
    }
    
    request.onerror = function() {
      reject(Error("an error occured"));
    }


    request.open('POST', form.action + queryString, true);
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send();
  });
}


function options(endpoint) {
  return new Promise(function(resolve, reject) {
    var request;
    
    request = new XMLHttpRequest();
    request.withCredentials = true;

    request.onload = function() {
      if (request.status == 200) {
        console.log(request.response);
        resolve(JSON.parse(request.response).data);
      } else {
        console.log("rejected");
        reject(Error(request.statusText));
        
      }
    }
    
    request.onerror = function() {
      reject(Error("an error occured"));
    }


    request.open('OPTIONS', endpoint, true);
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send();
  });
}


function del(endpoint, id) {
  return new Promise(function(resolve, reject) {
    var queryString;
    var request;
    
    if (!id)
      reject(Error('no id provided'));
    
    request = new XMLHttpRequest();
    request.withCredentials = true;

    request.onload = function() {
      console.log(request);
      if (request.status == 200) {
        console.log(request.response);
        resolve(JSON.parse(request.response).data);
      } else {
        console.log("rejected");
        reject(Error(request.statusText));
        
      }
    }
    
    request.onerror = function() {
      reject(Error("an error occured"));
    }


    request.open('DELETE', endpoint + "?_id=" + id, true);
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send();
  });
}


function listView(endpoint, outputSelector, objects, properties) {
  var outputElement = document.querySelector(outputSelector);
    outputElement.innerHTML = "";

  for (var i = 0; i < objects.length; i++) {
    var obj = objects[i];
    var id = obj['_id']['$id'];

    var outputDiv = document.createElement('div');
      outputDiv.classList.add('cg_outputDiv');

    outputElement.appendChild(outputDiv);

    var editButton = document.createElement('button');
      editButton.setAttribute("data-_id", id);
      editButton.appendChild(document.createTextNode("edit"));
      editButton.classList.add('cg_button');
      
      editButton.onclick = function() {
        detailView(selector, endpoint, id);
      }
      
    outputDiv.appendChild(editButton);
      
    var deleteButton = document.createElement('button');
      deleteButton.appendChild(document.createTextNode("delete"));
      deleteButton.classList.add('cg_button');

      deleteButton.onclick = function() {
        del(endpoint, id);
        this.parentNode.classList.add('cg_deleted');
      }

    outputDiv.appendChild(deleteButton);
    
    for (key in obj) {
      var property = obj[key];
      //console.log(key, ":", property);
      
      // _id, permission, and groups handled elsewhere
      if (key === "_id" || key === "permission" || key === "groups")
        continue;
      
      if (properties !== undefined && properties.indexOf(key) === -1)
        continue;
      
      if (typeof property !== 'object' || property.value == undefined)
        continue;
      
      var element = createElement(key, property);
      
      //outputElement.appendChild(document.createTextNode(key + ":"));
      outputDiv.appendChild(element);
      
    } // end for key
  } // end for i
  
}


function createElement(name, obj, type) {
  if (typeof type === 'undefined')
    type = 'span';
  
  var element = document.createElement(type);
    element.setAttribute('data-name', name);

  if (isArray(obj) && obj.length != 0) {
    element.classList.add('cg_sublist');
    for (var i = 0; i < obj.length; i++) {
      for (var key in obj[i]) {
        var property = obj[i][key];
        if (isObject(property)) {
          var subElement = createElement(name, property);
          element.appendChild(subElement);
        } // end if
      } // end for key
    } // end for i
  } else {
    element.appendChild(document.createTextNode(obj.value));

    for (var key in obj) {
      var property = obj[key];
    
      if (key === 'value')
        continue;
    
      element.setAttribute("data-" + key, property);
    } // end for
  
    element.classList.add('cg_output');

    if (obj.value === null) 
      element.classList.add('cg_null');
  } // end if

  return element;
}


function isObject(obj) {
  return (obj !== null && typeof obj === 'object' && !isArray(obj));
}

function isArray(obj) {
  return toString.call(obj) === "[object Array]";
}
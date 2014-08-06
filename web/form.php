<style>
  input,
  textarea,
  button,
  label {
    display: block;
  }
</style>

<?php /*?>
<form id='form' method='post' action='http://thesis.andrewcanfield.com/framework/api/index.php'>
  <input type='text' name='author'>
  <input type='text' name='title'>  
  <input type='date' name='date'>
  <textarea name='post'></textarea>
  <button id='button'>go</button>
  
</form>
<?php */ ?>

<form action="http://thesis.andrewcanfield.com/framework/api/index.php" method="post" >
  <input id="_id" name="_id" type="hidden">

  <label for="visibility" class="cg_label">visibility</label>
  <select id="visbility" class="cg_select">
    <option value="private">private</option>
    <option value="group">group</option>
    <option value="public">public</option>
  </select>

  <label for="author">author</label>
  <input id="author" name="author" pattern="^(\w|\d){1,255}$" type="String" class="cg_input">

  <label for="title">title</label>
  <input id="title" name="title" pattern="^(\w|\d){1,255}$" type="String" class="cg_input">

  <label for="date">date</label>
  <input id="date" name="date" pattern="^\d{4}-\d{2}-\d{2}$" type="Date" class="cg_input">

  <label for="post">post</label>
  <textarea id="post" name="post" class="cg_input"></textarea>
  <button class="cg_button">submit</button></form>


<script>
  function post(form) {
    //form = document.querySelector(selector);
    return new Promise(function(resolve, reject) {
      fd = new FormData(form);

      var endpoint = form.action;
      var request;

      request = new XMLHttpRequest();
  //    request.withCredentials = true;

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
        //reject(Error("an error occured"));
        console.log("error");
      }

      console.log(fd);
      request.open('PUT', endpoint, true);
      request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
      request.send(fd);
    });
  }

  frm = document.querySelector("form");
  frm.onsubmit = function() {
    return false;
  }

  btn = document.querySelector('.cg_button');
  
  
  
  btn.onclick = function() {
    console.log('click');
    post(this.form);

    
  }


</script>
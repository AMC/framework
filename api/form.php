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
</style>

<div id='admin'>
  >>
</div>

<form action='index.php' method='post'>
  <h2>New</h2>
  <input type='input' name='author' placeholder='author' value='Andrew Canfield'>
  <input type='date' name='date' placeholder='date' value='2014-06-24'>
  <input type='input' name='tags' placeholder='tags' value='this, that, other'>
  <textarea name='post' placeholder='post'>Hello World</textarea>
  <input type='submit' value='submit'>
</form>

<form action='index.php' method='delete'>
  <h2>Delete</h2>
  <input type='input' name='_id' placeholder='_id' >
  <input type='submit' value='submit'>
</form>

<form action='index.php' method='put'>
  <h2>Update</h2>
  <input type='input' name='_id' placeholder='_id' >
  <input type='input' name='author' placeholder='author' value='Andrew Canfield'>
  <textarea name='post' placeholder='post'>Hello World</textarea>
  <input type='submit' value='submit'>
</form>

<script>
xmlhttp = new XMLHttpRequest();
xmlhttp.open("OPTIONS","thesis.andrewcanfield.com", true);
xmlhttp.send();
console.log(xmlhttp.responseText);

</script>


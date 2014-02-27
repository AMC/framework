<h3>Index.php</h3>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

<script>
  function makeRequest(method, msg) {
    var url = "http://192.168.56.102/framework/";
    
    $.ajax({
      type: method,
      url: url,
      data: msg,
      success: function(data, status, xhr) {
        console.log(data);
        console.log(status);
        console.log(xhr);
      },
    }); 
  }

</script>

<pre>

<? print_r($_SERVER); ?>
<?

/*
if (!in_array("mod_rewrite", apache_get_modules()))
  die("mod_rewrite is not enabled.");



phpinfo();


if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
    die();
}
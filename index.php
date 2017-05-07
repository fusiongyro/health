<?php

require_once 'db.php';

if (isset($_POST['name'])) {
  $original_name = basename($_FILES["bodyshot"]["name"]);
  $new_name = "uploads/" . uniqid($original_name);

  if (move_uploaded_file($_FILES["bodyshot"]["tmp_name"], $new_name))
    $message = "file uploaded successfully";
  else
    $message = "file upload failed!";

  insert_weighin(
    $_POST['name'],
    $_POST['feeling'],
    $_POST['motivation'],
    $new_name,
    $_POST['weight']);
}

?>
<html>
<head><title>Welcome!</title></head>
<body>
<?php if (isset($message)): ?>
  <p><?php echo $message ?></p>
  <blockquote><pre><code><?php var_dump($_POST); ?></code></pre></blockquote>
<?php endif; ?>
<form method="post" enctype="multipart/form-data">
  <div class="form-element">
    <label for="name">Select your name below:</label>
    <select name="name" id="name">
      <option>Amber</option>
      <option>Heather</option>
      <option>Kate</option>
      <option>Liz</option>
    </select>
  </div>

  <div class="form-element">
    <label>How are you feeling today?</label>
    <input name="feeling" id="feeling-1" type="radio" value="1"><label for="feeling-1">1</label>
    <input name="feeling" id="feeling-2" type="radio" value="2"><label for="feeling-2">2</label>
    <input name="feeling" id="feeling-3" type="radio" value="3"><label for="feeling-3">3</label>
    <input name="feeling" id="feeling-4" type="radio" value="4"><label for="feeling-4">4</label>
    <input name="feeling" id="feeling-5" type="radio" value="5"><label for="feeling-5">5</label>
  </div>

  <div class="form-element">
    <label for="motivation">What is motivating you today?</label><br/>
    <textarea id="motivation" name="motivation" rows="4" cols="60"></textarea>
  </div>

  <div class="form-element">
    <label for="bodyshot">Upload that full body baby!</label>
    <input type="file" name="bodyshot" id="bodyshot">
  </div>

  <div class="form-element">
    <label for="weight">Weight</label>
    <input name="weight" id="weight">
  </div>

  <div class="form-element">
    <input type="submit" value="Update" name="submit">
  </div>
</form>
</body>
</html>
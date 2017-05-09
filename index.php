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
<head>
  <title>Welcome!</title>
  <link rel="stylesheet" type="text/css" href="css/main.css"/>
  <script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>
<?php if (isset($message)): ?>
  <p><?php echo $message ?></p>
  <blockquote><pre><code><?php var_dump($_POST); ?></code></pre></blockquote>
<?php endif; ?>
<h1>Weigh In!</h1>
<form method="post" enctype="multipart/form-data">
  <div class="form-element">
    <label for="name" class="control-label">Select your name below:</label>
    <select name="name" id="name">
      <option>Amber</option>
      <option>Heather</option>
      <option>Kate</option>
      <option>Liz</option>
    </select>
  </div>

  <div class="form-element">
    <label class="control-label">How are you feeling today?</label>
    <input name="feeling" id="feeling-1" type="radio" value="1"><label class="checkable checkbox-label" for="feeling-1">1</label>
    <input name="feeling" id="feeling-2" type="radio" value="2"><label class="checkable checkbox-label" for="feeling-2">2</label>
    <input name="feeling" id="feeling-3" type="radio" value="3"><label class="checkable checkbox-label" for="feeling-3">3</label>
    <input name="feeling" id="feeling-4" type="radio" value="4"><label class="checkable checkbox-label" for="feeling-4">4</label>
    <input name="feeling" id="feeling-5" type="radio" value="5"><label class="checkable checkbox-label" for="feeling-5">5</label>
  </div>

  <div class="form-element">
    <label for="motivation" class="control-label">What is motivating you today?</label>
    <textarea id="motivation" name="motivation" rows="4" cols="60"></textarea>
  </div>

  <div class="form-element">
    <label for="bodyshot" class="control-label">Upload that full body baby!</label>
    <input type="file" name="bodyshot" id="bodyshot">
  </div>

  <div class="form-element">
    <label for="weight" class="control-label">Weight</label>
    <input name="weight" id="weight">
  </div>

  <div id="container"></div>

  <div class="form-element">
    <input type="submit" value="Update" name="submit">
  </div>
</form>

<script type="application/ecmascript">
  document.onload = function() {
    var request = new XMLHttpRequest();
    request.open('GET', 'history.php?name=' + 'Amber', true);

    request.onload = function() {
      if (this.status >= 200 && this.status < 400) {

        Highcharts.chart('container', {
          title: {
            text: ''
          },

          yAxis: {
            title: {
              text: 'Number of Employees'
            }
          },
          legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
          },

          plotOptions: {
            series: {
              pointStart: 2010
            }
          },

          series: [{
            name: 'Amber',
            data: [
              this.response
            ]
          }]
        });
      } else {
        // We reached our target server, but it returned an error
      }
    };

    request.onerror = function() {
      // There was a connection error of some sort
    };

    request.send();
  };
</script>
</body>
</html>
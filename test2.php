<!DOCTYPE html>
<html>
<body>

<h2>Upload Image</h2>

<!--
    FORM SETUP:
    - method="post" → data server এ যাবে
    - enctype="multipart/form-data" → file পাঠানোর জন্য MUST
-->
<form action="upload.php" method="post" enctype="multipart/form-data">

  <!-- user file select করবে -->
  Select image:
  <input type="file" name="fileToUpload">

  <br><br>

  <!-- submit button -->
  <input type="submit" name="submit" value="Upload">

</form>

</body>
</html>
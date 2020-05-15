<?php
/**************************************************************
 * This code works, it scales an image to 640px wide
 * We need an interface where a user can choose several
 * different sizes.
 * The interface needs to have an initial file
 * This file should be stored in public/images
 * The result should be all of the new sized images in the
 * resized folder
 *************************************************************/


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
<title>Image Resizer</title>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
  <form
    method="post"
    id="resize-image-form"
    action="{{url('createImages')}}"
    enctype="multipart/form-data">
    @csrf <!-- {{ csrf_field() }} -->
    <label for="size1">Size 1</label>
    <input type="text" name="size1" value="980" />
    <br /><br />
    <label for="size2">Size 2</label>
    <input type="text" name="size2" value="680" />
    <br /><br />
    <label for="size3">Size 3</label>
    <input type="text" name="size3" value="480" />
    <br /><br />
    <label for="size4">Size 4</label>
    <input type="text" name="size4" value="320" />
    <br /><br />
    <label for="size5">Size 5</label>
    <input type="text" name="size5" />
    <br /><br />
    <label for="size6">Size 6</label>
    <input type="text" name="size6" />
    <br /><br />
    <label for="size7">Size 7</label>
    <input type="text" name="size7" />
    <br /><br />
    <label for="size8">Size 8</label>
    <input type="text" name="size8" />
    <br /><br />
    <label for="size9">Size 9</label>
    <input type="text" name="size9" />
    <br /><br />
    <label for="size10">Size 10</label>
    <input type="text" name="size10" />
    <br /><br />

    <label for="image">Upload File</label>
    <input type="file" name="photo" id="photo"/>
    <br /><br />
    <br />
    <!-- <input type="submit" value="Submit" /> -->
    <a class="btn" href="javascript: submitForm()">Submit</a>
  </form>
<script src="{{ asset('js/form.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

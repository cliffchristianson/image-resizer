<?php
/***********************************************************************
 * Author: Clifford Christianson
 * Creation Date: May 14, 2020
 * ResponsiveImageController.php
 * This application resizes images to
 * different horizontal widths automatically
 * We take up to 12 sizes and an image file as input.
 * It will then save the image file in
 * each of the horizontal width sizes
 * Don't put this on an internet server
 * or someone will upload a RAT!
 * Always store uploaded user files off server somewhere else!
 * Validate the actual images, not the extension
 * Use on your local development environment only!
 * Make sure GD library is installed
 * and enabled with phpinfo();
 *
 *
 *               ____...---...___
 * ___.....---"""        .       ""--..____
 *     .                  .            .
 * .            ^_.--._^      /|
 *        .    .'()..()`.    / /
 *            ( `-.__.-' )  ( (    .
 *   .         \        /    \ \
 *       .      \      /      ) )        .
 *            .' -.__.- `.-.-'_.'
 * .        .'  /-____-\  `.-'       .
 *          \  /-.____.-\  /-.
 *           \ \`-.__.-'/ /\|\|           .
 *          .'  `.    .'  `.
 *          |/\/\|    |/\/\|
 * jro
 **********************************************************************/

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ResponsiveImageController extends Controller
{
  public function resizeImages(Request $request)
  {
    $directory = 'images/resized'; // This path is in my public, NOT my storage/app
    $imageArray = []; // return array of images we create
    $DEBUG = 0; // Set to 1 for testing

    if (extension_loaded('gd') && function_exists('gd_info')) {
      if($DEBUG)
        echo "PHP GD Library is install in php";
    }
    else {
        return view('welcome', ['error' => 'The php gd library is NOT installed in your php, you can try phpinfo(); to see more.  You may have to install a new version of php or recompile php with gd enabled.']);
    }

    // lets read all the image sizes into scales
    if($request->size1)
      $scales[] = $request->size1;
    if($request->size2)
      $scales[] = $request->size2;
    if($request->size3)
      $scales[] = $request->size3;
    if($request->size4)
      $scales[] = $request->size4;
    if($request->size5)
      $scales[] = $request->size5;
    if($request->size6)
      $scales[] = $request->size6;
    if($request->size7)
      $scales[] = $request->size7;
    if($request->size8)
      $scales[] = $request->size8;
    if($request->size9)
      $scales[] = $request->size9;
    if($request->size10)
      $scales[] = $request->size10;
    if($request->size11)
      $scales[] = $request->size11;
    if($request->size12)
      $scales[] = $request->size12;

    if($DEBUG)
      var_dump($scales);

    if($request->hasFile('photo'))
    {
      request()->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif',
        'size1' => 'nullable|numeric',
        'size2' => 'nullable|numeric',
        'size3' => 'nullable|numeric',
        'size4' => 'nullable|numeric',
        'size5' => 'nullable|numeric',
        'size6' => 'nullable|numeric',
        'size7' => 'nullable|numeric',
        'size8' => 'nullable|numeric',
        'size9' => 'nullable|numeric',
        'size10' => 'nullable|numeric',
        'size11' => 'nullable|numeric',
        'size12' => 'nullable|numeric'
      ]);

      if($DEBUG)
        echo "\r\nPassed Validation\r\n";

      $imageName = $request->photo->getClientOriginalName();

      // save the original image
      $image = $request->photo->storeAs('public/images', $imageName);

      // create the directory if it doesn't exist
      if(!file_exists('images/Resized'))
      {
        mkdir($directory, 0775, true);
      }

      $mime=$request->photo->extension();

      if($DEBUG)
        echo "mime = ".$mime;

      switch($mime)
      {
        case "jpg":
          if($DEBUG)
            echo "Cliff here in jpg";
          $start_name = str_replace('.jpg', '', basename($image));
          $im_php = imagecreatefromjpeg($request->photo);
          break;
        case "jpeg":
          if($DEBUG)
            echo "Cliff here in jpeg";
          $im_php = imagecreatefromjpeg($request->photo);
          $start_name = str_replace('.jpeg', '', basename($image));
          $start_name = str_replace('.jpg' , '', basename($image));
          break;
        case "png":
          $start_name = str_replace('.png', '', basename($image));
          $im_php = imagecreatefrompng($request->photo);
          break;
        case "gif":
          $start_name = str_replace('.gif', '', basename($image));
          $im_php = imagecreatefromgif($request->photo);
          break;
        default:
          return view('welcome', [
            'error' => 'Please attach a jpg, png, or gif image'
          ]);
      }

      // now lets create an image for each scale
      foreach($scales as $scale)
      {
        $im_php = imagescale($im_php, $scale);
        $new_height = imagesy($im_php);
        $new_name = $start_name.'_X'.$scale.'_Y'.$new_height.'.jpg';

        if($DEBUG)
        echo "\r\n".$new_name."\r\n";

        $file_path = $directory . '/' . $new_name;

        // create the new image with 90% quality
        switch($mime)
        {
          case "jpg":
            imagejpeg($im_php, $file_path, 90);
            break;
          case "jpeg":
            imagejpeg($im_php, $file_path, 90);
            break;
          case "png":
            imagepng($im_php, $file_path, 90);
            break;
          case "gif":
            imagegif($im_php, $file_path, 90);
            break;
          default:
          return view('welcome', [
            'error' => 'Please attach a jpg, png, or gif image'
          ]);
        }
        $imageArray[] = $file_path;
      }
      return back()->with('imageArray', $imageArray);
    }
    else
    {
      return view('welcome', ['error' => 'Please add an image']);
    }
  }
}

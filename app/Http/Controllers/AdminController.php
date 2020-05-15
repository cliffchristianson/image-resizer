<?php
/***********************************************************************
 * Author: Clifford Christianson
 * Creation Date: May 14, 2020
 * This application resizes images to
 * different horizontal widths automatically
 * We take up to 10 sizes and an image file as input.
 * It will then save the image file in
 * each of the horizontal width sizes
 * Don't put this on an internet server or someone will upload a RAT!
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

/**
 * What would be cool to have
 * How about the ouput is a generated figure with all the guys?
 */

class AdminController extends Controller
{
  //
  public function resizeImages(Request $request)
  {
    if (extension_loaded('gd') && function_exists('gd_info')) {
      // say something here to make sure
    }
    else {
        echo "PHP GD library is NOT installed in php";
        return ("GD Library is not installed in php");
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

    $input = $request->photo;

    $directory = 'public/images';
    // $scales = [980,680,480,320];

    if($request->hasFile('photo'))
    {
      request()->validate([
      'photo' => 'required|image|mimes:jpeg,png,jpg,gif',
      'size1' => 'sometimes|numeric',
      'size2' => 'sometimes|numeric',
      'size3' => 'sometimes|numeric',
      'size4' => 'sometimes|numeric',
      'size5' => 'sometimes|numeric',
      'size6' => 'sometimes|numeric',
      'size7' => 'sometimes|numeric',
      'size8' => 'sometimes|numeric',
      'size9' => 'sometimes|numeric',
      'size10' => 'sometimes|numeric',
      ]);

      $imageName = $request->photo->getClientOriginalName();

      $image = $request->photo->storeAs('public/images', $imageName);

      // I'm
      $mime=$request->photo->extension();

      switch($mime)
      {
        case "jpg":
          $im_php = imagecreatefromjpeg($request->photo);
          break;
        case "jpeg":
          $im_php = imagecreatefromjpeg($request->photo);
          break;
        case "png":
          $im_php = imagecreatefrompng($request->photo);
          break;
        case "gif":
          $im_php = imagecreatefromgif($request->photo);
          break;
        default:
          return "Please attach a valid image";
      }
      // now lets write each scale
      foreach($scales as $scale)
      {
        $im_php = imagescale($im_php, $scale);
        $new_height = imagesy($im_php);
        $new_name = str_replace('.jpg', '', basename($image));
        $new_name = str_replace('.jpeg', '', basename($image));
        $new_name = $new_name.'_X'.$scale.'_Y'.$new_height.'.jpg';
        // create the new image with 90% quality
        switch($mime)
        {
          case "jpg":
            imagejpeg($im_php, 'images/Resized/' . $new_name, 90);
            break;
          case "jpeg":
            imagejpeg($im_php, 'images/Resized/' . $new_name, 90);
          break;
          case "png":
            imagepng($im_php, 'images/Resized/' . $new_name, 90);
            break;
          case "gif":
            imagegif($im_php, 'images/Resized/' . $new_name, 90);
            break;
          default:
            return "Please attach a valid image";
        }
          echo "File saved - ".$new_name;
      }
    }
    else
    {
      return "Please add an image";
    }

  }
}

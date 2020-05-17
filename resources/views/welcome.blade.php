<?php
/***********************************************************************
 * Author: Clifford Christianson
 * Creation Date: May 14, 2020
 * welcome.blade.php
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type"
  content="text/html; charset=UTF-8">
<meta name="viewport"
  content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
<title>Image Resizer</title>
<link rel="stylesheet"
  href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto&display=swap">
<link rel="stylesheet"
  href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
  integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet"
  href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/styles/default.min.css">
<link rel="stylesheet" href="css/main.css">
</head>
<body>
  <form
  method="post"
  id="resize-image-form"
  action="{{url('createImages')}}"
  enctype="multipart/form-data">
  @csrf <!-- {{ csrf_field() }} -->
  <div class="page-wrapper bg-gra-04 p-t-45 p-b-50">
    <div class="wrapper wrapper--w790">
      <div class="card card-5"
        id="step1"
        @if(session()->has('imageArray'))
            style="display: none;"
        @endif
      >
        <div class="card-heading">
          <h2 class="title">Responsive Image Builder</h2>
        </div>
        <div class="card-body">
          <div class="form-row">
          @for($cnt=1; $cnt<13; $cnt++)
            <div class="form-group col-md-4">
              <label for="size{{$cnt}}">Size {{$cnt}}</label>
              <input
                type="text"
                name="size{{$cnt}}"
                id="size{{$cnt}}"
                class="form-control"
                aria-describedby="sizeHelp{{$cnt}}"/>
              <small id="sizeHelp{{$cnt}}" class="form-text text-muted">Set an image width</small>
              @if($errors->has('size'.$cnt))
                <div class="error">
                  {{ $errors->first('size'.$cnt)}}
                </div>
              @endif
            </div>
            @if(!($cnt%3) && $cnt<10)
          </div>
          <div class="form-row">
            @endif
          @endfor
          </div>
          <div class="form-row">
            <!--
            -->
            <div class="form-group col-md-12">
              <label for="photo">Upload File</label>
              <input
                type="file"
                name="photo"
                id="photo"/>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <button class="btn btn-primary"
                  href="javascript: submitForm()">
              Submit
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="card card-5" id="step2"
        @if(!session()->has('imageArray'))
          style="display: none"
        @endif
        >
        <div class="card-heading">
          <h2 class="title">Responsive Image Builder - Step 2</h2>
        </div>
        <div class="card-body">
          <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Created Files</h4>
            <hr class="mt-1 pb-1" />
            @if(session()->has('imageArray'))
            @foreach(Session::get('imageArray') as $cnt => $image)
              <p class="p-1"
                name="image{{ $cnt+1 }}"
                id="image{{ $cnt+1 }}">{{ $image }}</p>
            @endforeach
            @endif
          </div>
          <!--
            We need another form here, this form should have
            1.  link for image
            2.  caption
            3.  link for caption
            4.  cite
            5.  link for cite
            6.  Break point offset
          -->
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="image-link">Image Link</label>
              <input type="text"
                id="image-link"
                name="image-link"
                class="form-control"
                aria-describedby="image-link-help"
              />
              <small id="image-link-help" class="form-text text-muted">Link for the image</small>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="figure-caption">Figure Caption</label>
              <textarea
                id="figure-caption"
                name="figure-caption"
                class="form-control"
                rows="4"
                aria-describedby="figure-caption-help"></textarea>
              <small id="figure-caption-help" class="form-text text-muted">Text that accompanies the image</small>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="caption-link">Caption Link</label>
              <input type="text"
                id="caption-link"
                name="caption-link"
                class="form-control"
                aria-describedby="caption-link-help"
              />
              <small id="caption-link-help" class="form-text text-muted">Link for the caption text</small>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="cite">Cite</label>
              <textarea
                id="cite"
                name="cite"
                class="form-control"
                rows="4"
                aria-describedby="cite-help">
              </textarea>
              <small id="cite-help" class="form-text text-muted">Cite the image author, title, and license</small>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="cite-link">Cite Link</label>
              <input type="text"
                id="cite-link"
                name="cite-link"
                class="form-control"
                aria-describedby="cite-link-help"
              />
              <small id="cite-link-help" class="form-text text-muted">Link to the usage license</small>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="offset">Break Point Offset</label>
              <input
                type="text"
                name="offset"
                id="offset"
                class="form-control"
                aria-describedby="offset-help"
              />
              <small id="offset-help" class="form-text text-muted">Extra width for padding and margin for each breakpoint</small>

            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <button
                type="button"
                class="btn btn-primary"
                onclick="buildFigure()">
              Submit
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="card card-5" id="step3" style="display: none;">
        <div class="card-heading">
          <h2 class="title">Responsive Image Builder - Step 3</h2>
        </div>
        <div class="card-body">
          <pre>
            <code class="html hljs">
&lt;figure&gt;
  <span id="image-link-span"></span>
  &lt;picture&gt;
@if(session()->has('imageArray'))
@foreach(Session::get('imageArray') as $cnt => $image)
    &lt;source media="(min-width: <span id="min-width-{{ $cnt + 1 }}"></span>)" srcset="<span id='image-srcset-{{ $cnt + 1 }}'></span>"&gt;
@endforeach
    <span id="image-src"></span>
@endif
  &lt;/picture&gt;
  <span id="image-end-link-span"></span>
  &lt;figcaption&gt;
    <span id="caption-link-span"></span>
      <span id="figure-caption-span"></span>
    <span id="caption-end-link-span"></span>
    <span id="cite-link-span"></span>
      <span id="cite-span"></span>
    <span id="cite-link-end-span"></span>
  &lt;/figcaption&gt;
&lt;/figure&gt;
            </code>
          </pre>
        </div>
      </div>
    </div>
  </div>
  </form>
<script src="{{ asset('js/form.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
</body>
</html>

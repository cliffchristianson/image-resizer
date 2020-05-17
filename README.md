# Welcome to the image-resizer!

![Screen Shot 1](../assets/Screen-Shot-1.png?raw=true)
Up to 12 different image sizes, Responsive Image Generation on the fly!

![Screen Shot 2](../assets/Screen-Shot-2.png?raw=true)
All of the fields on step 2 are optional, they will be removed from the code if you leave them blank.

![Screen Shot 3](../assets/Screen-Shot-3.png?raw=true)

Tired of scaling and saving images in GIMP?  How about copy/pasting filenames for all of your responsive images?  

**Yuck!**  We don't want to do that anymore!

This nifty little laravel tool will do all the work for us.  Just set the horizontal widths you want for your image, upload the image, and BAM!!!  Automatic Responsive Image Generation!!

Just copy/paste the code and move the images to where you want them!  It even saves your settings for next time!

Resized images will save into 
**public/images/resized/**

The form can be found at 
resources/views/welcome.blade.php

The controller can be found at 
app/Http/Controllers/ResponsiveImageController.php

The script can be found at
public/js/form.js

##### WARNING:  DO NOT PUT THIS CODE ON A WEBSITE OR A HACKER WILL PAWN YOU WITH A RAT!  THIS APPLICATION IS FOR USE ON YOUR LOCAL DEV SERVER ONLY!  DON'T EVER STORE USER UPLOADED FILES ON YOUR SERVER EVER, DONT DO IT!! USE THE CLOUD OR A SERVICE FROM SOMEWHERE. ALWAYS CHANGE UPLOADED FILENAMES TO SOMETHING COMPLETELY RANDOM AND NEVER TRUST FILE EXTENSIONS.  SEARCH FOR OWASP TO LEARN MORE.

Troubleshooting:  This application uses the gd library for image manipulation so make sure it is enabled with phpinfo()

#Welcome to the image-resizer!

Tired of scaling and saving images in GIMP?  How about copy/pasting filenames for all of your responsive images?  

Yuck!  We don't want to do that anymore!

This nifty little laravel app will do all the work for us.  Just set the horizontal widths you want for your image, upload the image, and BAM!!!  Automatic Responsive Image Generation!!

Just copy/paste the code and move the images to where you want them!  It even saves your settings for next time!

Resized images will save into 
public/images/resized/

The form can be found at 
resources/views/welcome.blade.php

The controller can be found at 
app/Http/Controllers/ResponsiveImageController.php

The script can be found at
public/js/form.js

All of the fields on step 2 are optional, they will be removed from the code if you leave them blank.

###WARNING:  DO NOT PUT THIS CODE ON A WEBSITE OR A HACKER WILL PAWN YOU WITH A RAT!  THIS APPLICATION IS FOR USE ON YOUR LOCAL DEV SERVER ONLY!  DON'T EVER STORE USER UPLOADED FILES ON YOUR SERVER EVER, DONT DO IT!! USE THE CLOUD OR A SERVER FROM SOMEONE YOU DON'T LIKE. ALWAYS CHANGE UPLOADED FILENAMES TO SOMETHING COMPLETELY RANDOM AND NEVER TRUST FILE EXTENSIONS.  SEARCH FOR OWASP TO LEARN MORE.

Troubleshooting:  This application uses the gd library for image manipulation so make sure it is enabled with phpinfo()
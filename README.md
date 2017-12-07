# profilecropper
Some code to automatically create profile photos using face detection.

# instructions
- Download and install Docker www.docker.com
- Download and install Facebox https://machinebox.io 
- Make sure you have the GD V2 compiled into your PHP 
- Put images you wish to crop into the 'in' directory
- Run the code
- When complete, check the 'out' directory for cropped photos

## notes
- Machine Box provides the face recognition tool. It returns a rect from a photo. There currently is a 20 pixel padding hard coded into profilecropper to give some space around the cropped photo. This obviously can be adjusted. 
- profilecropper will give an error if there is a photo in the 'in' directory with less than or more than 1 face, and will skip to the next photo. 


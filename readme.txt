What is here?

a) How to install Galeria - new installation
b) How to update from v1.0 or v1.1 Galeria to v1.2 Galeria
c) How to uninstall Galeria
d) Note


==========================================================
a) How to install Galeria - new installation
==========================================================

1.- You need to unzip the galeria in your xoops root
	File structure will be 
	[pathToXoops]/modules/uskolaxgallery 
	[pathToXoops]/class
	[pathToXoops]/include
	when correctly placed. only this readme.txt is not need to send

2.- Go to the Administration Menu -> System Admin -> 
    Modules -> Galeria Activate

3.- Click "Yes" when you see: 
    "Please confirm: Activate Galeria".

4.- Go back to the Administration Menu and click on the 
    Galeria icon.

5.- Click on the icon 
    "Install Galeria Tables to Xoops".

6.- Scroll down and click the button
    "Install Galeria Tables to Xoops".

7.- Success results should be shown:

	"Galeria is installed in your system."

8.- We suggest starting with ADD NEW GALLERY, then 
    CONFIGURE A PRESENTATION.


============================================================
b) How to update from v1.0 or v1.1 Galeria to Galeria v1.2.6
============================================================

Note: If you update from Galeria v.1.0 you need to use the complete install files of the Galeria v1.2.

1.- Be sure that the Galeria BLOCK is set to NOT VISIBLE, 
    because the v1.1 or v1.0 blocks do NOT work with the 
    Galeria 1.2 version.

2.- Go to the Administration Menu -> System Admin -> 
    Modules -> Galeria Update

3.- Click "Yes" when you see: 
    "Please confirm: Update Galeria".

4.- Go back to the Administration Menu and click on the 
    Galeria icon.

5.- Click on the icon 
    "Install Galeria Tables to Xoops".

6.- Scroll down and click the button 
    "Install Galeria Tables to Xoops".

7.- Success results should be shown.
    Note: These errors are shown but they are normal 
    because in the UPDATE, these tables already exist:

	1.- Unable to create the table. galeriaupdate_uskolag_carpeta 
	2.- Unable to create the table. galeriaupdate_uskolag_imagenes 
	3.- Unable to create the table. galeriaupdate_uskolag_comentarios 
	4.- Unable to create the table. galeriaupdate_uskolag_master 
	Error inserting Default values 

8.- Configure your Galeria block presentation for each 
    gallery.

9.- Go back to the Administration Menu and activate the 
    Galeria BLOCK as desired.


==========================================================
c) How to uninstall Galeria
==========================================================

Notes: 	You must first remove the GALERIA BLOCK if is shown:

       	Administration Menu -> System Admin -> Blocks -> 
	Delete the Galeria Block
 

       	If you have Galeria as your START PAGE module, 	
	select another module as your start page:

       	Administration Menu -> System Admin -> Preferences -> 
		"Module for your start page"		

From the administration of the Galeria Module:

1.- Click on the Uninstall Galeria icon.

2.- Scroll down the page and click "Uninstall".

3.- Go to the Administration Menu -> System Admin -> 
	Modules -> Galeria Deactivate.

4.- Click "yes" when you see 
    "Please confirm: Deactivate Galeria"


==========================================================
d) Notes:
==========================================================

If you want to make the options of "install" and "uninstall" 
Galeria NOT AVAILABLE to your Galeria administrators, 
remove or rename these files: 

	modules/uskolaxgallery/admin/install.php
	modules/uskolaxgallery/admin/uninstall.php


Thank you for choosing GALERIA!

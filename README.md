* Hair Salon

* Hair Salon App, 07/14/17

By Jacob Ruleaux

* Description;

* The Hair Salon app shows current stylists as well as a list of each stylists' clients. The program will allow user to add stylists or clients, or delete either.

* Setup/Installation Requirements

  * You Will Need MAMP installed.

  * You Will Need Composer Installed.

* Open GitHub site on your browser: https://github.com/jakeruleaux/hair-two

* Select the dropdown (green box) "Clone or download"

* Copy the link for the GitHub repository

* Open Terminal on your computer

* In Terminal, perform the following steps:

* Type 'cd desktop' and press enter.

* Type 'git clone' then copy the repository link and press enter.

* Type 'cd hair-two' to access the path on your terminal.

* Type 'composer install' in terminal to download terminal.

* Type 'localhost:8888/phpmyadmin' and select the import tab near the top of the screen. In the import tab browse for 'hair_salon.sql.zip'.

* Select this file and click the 'go' button at the bottom.

* In Terminal type /Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot.

* In mysql type 'SHOW DATABASES;' to confirm that you have the 'hair_salon' database.

* In mysql type 'USE hair_salon;'.

* In your Address Bar type 'localhost:8888' to view app.

* The paths in MAMP may need to be adjusted. In MAMP click the 'web server' tab. Make sure you have the appropriate document root path, ex: 'User/File-directory/file/web'.

* Known Bugs

* The program requires a localhost to function. It was designed with MAMP in mind. Similar programs may support it.

* Support and contact details

 Feel free to contact the author with questions or concerns at jakeruleaux@hotmail.com

* Technologies Used

The application relies on MAMP, PHP, Silex, Twig with some Bootstrap for styling and basic HTML for display.

* License
  MIT

* Copyright (c) 2017 Jacob Ruleaux

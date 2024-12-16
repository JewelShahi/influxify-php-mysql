# How to Start the Web-Based Application

Instructions are for the Windows operating system.

1. Install the XAMPP program with all default settings, installing it on the C: drive.

2. After installing XAMPP, a `xampp` folder will be created. Navigate into it and then into the `htdocs` folder.

3. Move the `influxify` folder from the flash drive into the `htdocs` folder (`C:\xampp\htdocs`).
    - (There might be an issue, so a zip file is provided. When opening the zip, drag and drop the file from the zip and move it to `C:\xampp\htdocs`.
    - When extracting, be careful as it creates a folder containing the actual content (you need to extract the `influxify` folder from the additional folder), which should be moved to `C:\xampp\htdocs`).

4. After these steps, start the Apache and MySQL modules from the XAMPP Control Panel application.

5. Start the MySQL server and select the "Admin" button on the same row.

6. Open a browser and go to the URL: `http://localhost/phpmyadmin/`.

7. On the left side, all available databases are listed, each with a name.
    - To add a new one, click the "+New" button.
    - A title "Databases" will appear under the navbar, with an option "Create database".
    - Enter `shop_db` as the database name, then click the "Create" button.
    - The interface will update and provide an option "Create new table".
    - Then, from the navbar on the site, select the "Import" option.
    - There will be an option to select a file - "Choose file", click it.
    - Select the database file located in the current directory of the application or on the flash drive named `shop_db.sql`.
    - At the bottom of the site, there is a "Go"/"Import" button, click it and the application's database will be successfully created.

8. When the project files are transferred to (`C:\xampp\htdocs`), open a browser and enter the URL: `http://localhost/influxify/user/` for the client side, and for the admin side: `http://localhost/influxify/admin/admin_login.php`.
    - (Through `http://localhost/influxify/admin/`, you can access all admin files. If there is no registration, you will be redirected to `http://localhost/influxify/admin/admin_login.php`).

9. The website is ready for testing.

10. Additional information regarding the project:

    * To add an admin, log in with the main account with Email: `admin@admin.com` and Password: `admin`. If you already have a created profile, simply log in with your own credentials.
    * When adding specifications for each product, it is good to add `GB` after the number for Storage and RAM. (Example: 16GB)
    * Another important thing to mention, if you write in a language other than English, an error might occur due to globalization, as specified in point 3.1 of the document.

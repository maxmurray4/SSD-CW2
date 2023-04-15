For part 2 of the coursework, you must import the website you've been assigned into XAMPP and test it according to the coursework sepc.

You will need to copy the files into the htdocs folder and import the database through phpmyadmin.

General Setup: 

1. Copy the contents of the htdocs folder into your xampp htdocs folder.
	In Windows finder: click view tab > check "hidden items" box
		You can copy all files including hidden ones using: "xcopy <src> <destination> /e /i /h". 
	If on OSX / Linux, copy using the terminal
		There may be hidden .htaccess files (verify with "ls -lah" in cmd/terminal). 
	If the website isn't working, try copy .htaccess explicitly: "cp <src>.htaccess <destination>", this is the most likely source of bugs. 

2. Check the .htaccess for any auto-prepend statements, make sure the file path matches your computers/xampps path structure.

3. Import the database file using localhost/phpmyadmin > import on the .SQL document. 
	If you get any errors importing the database, try manually creating the database first, clicking it, then importing the file.
	The database is usally the name of the sql file, unless specified in README_SECOND.txt

4. Read any other README documents included for setup (may be some in htdocs folder)

Website Specific Setup: 

1. Read the README_SECOND.txt document (if empty, no extra configs needed)
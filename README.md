[![Open in Visual Studio Code](https://classroom.github.com/assets/open-in-vscode-f059dc9a6f8d3a56e377f745f24479a46679e63a5d9fe6f495e02850cd0d8118.svg)](https://classroom.github.com/online_ide?assignment_repo_id=7110303&assignment_repo_type=AssignmentRepo)
# cwk1
## SSD CWK1 Repository

INSTRUCTIONS TO GET WEBSITE RUNNING WITH XAMPP & PHPMYADMIN

1. Download the code as a ZIP.
2. Open the ZIP folder & drop all contents inside your htdocs folder (or where ever you changed your web directory to).
3. Start Apache & MySQL using the XAMPP Control Panel.
4. Click the "Admin" button on the same row as MySQL. It should redirect you to your localhost phpmyadmin.
5. Enter your login details (default: login is "root" and no password).
6. Create a new database and call it blog
7. Then goto the import tab and click browse.
8. Select the .SQL file which you had dropped in your web folder on step 2.
9. Click Go.
10. Once the database has been imported you can delete the .SQL file from the folder.
11. Now head to the dbh.inc.php file inside the include folder.
12. Edit the database login details with your own details and save the file.
13. Once all of this is done you can now run the website with full functionality.


Troubleshooting:

On some windows machines like in university it sometimes shows some punctuation as a black diamond with a question mark in the middle. This is down to an encoding issue on the machines. I have set the charset to UTF-8 which is the most up to date encoding charset. However, the university computers can only display the text properly if it is encoded using ISO-8859-1 or windows-1252. 
You can use a chrome extension to enforce a custom encoding if you want to read it properly:
https://chrome.google.com/webstore/detail/set-character-encoding/bpojelgakakmcfmjfilgdlmhefphglae?hl=en#:~:text=Set%20Character%20Encoding&text=Provide%20right%2Dclick%20menu%20to,pages%20on%20the%20same%20site.

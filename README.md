#Elementor Live Users App
Live Preview:
http://206.189.60.96/

You can try how it works.
Users:
- Login: Elena Password: 111111
- Login: Mati Password: 222222
- Login: Meytal Password: 333333

#to run the APP
-use preview: http://206.189.60.96/
- please run from you terminal inside the test folder: php -S localhost:8080 -t server


#NOTES
- User:
    - user name: Simple name just for example. Because we have user page and email can not be user name I simple name as login name for the login form. Unique.
    - user pass: used simple 6 symbols number. 
    TODO: use md5 for password amd jwt token
    - user live info: used 0/1, sure will be better use CSS color animation.
    - date should be formatted

#Status of done
- Welcome message:
    including current username, user see that message on users list page after login.
- Logout link:
    added to top users list page
- Current online users list:
    - user IP not returns the information with php, returns fallback
- The online list should be refreshed every 3s:
    - done: used worker not to overload the browser
- Click on a user - fetch data from server:
    - done: fetching data
- On exit from the page, the user should be marked as offline (not found correct solution): 
    - server not knows when user clicks on browser. 
    - client: js beforeunload method will logout user even he will refresh the page and sessionStorage able check and status if user closed the page and after open new tab, so the live information will not be updated (async with server) 
    

   
    






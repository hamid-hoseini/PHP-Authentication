<!DOCTYPE html>
<html>
    <head>
        <title>My first PHP Website</title>
    </head>
    <body>
        <h2>Login Page</h2>
        <a href="index.php">Click here to go back</a><br/><br/>
        <form action="checkLogin.php" method="POST">
           Enter Username: <input type="text" name="username" required="required" /> <br/>
           Enter password: <input type="password" name="password" required="required" /> <br/>
           <input type="submit" value="Login"/>
        </form>
    </body>
</html>
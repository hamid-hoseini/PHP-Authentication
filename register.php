<!DOCTYPE html>
<html>
<head>
    <title>My first PHP Website</title>
</head>
<body>
<h2>Registration Page</h2>
<a href="index.php">Click here to go back</a><br/><br/>
    <form action="register.php" method="POST">
        Enter Username: <input type="text" name="username" required="required" /> <br/>
        Enter password: <input type="password" name="password" required="required" /> <br/>
        <input type="submit" value="Register"/>
    </form>
</body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $con= mysqli_connect("127.0.0.1","root","mary2016","TicketHistory");

    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
	$username = mysqli_real_escape_string($con, $_POST['username']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
    $bool = true;

	$query = mysqli_query($con, "Select * from Users"); //Query the users table
	while($row = mysqli_fetch_array($query)) //display all rows from query
	{
		$table_users = $row['username']; // the first username row is passed on to $table_users, and so on until the query is finished
		if($username == $table_users) // checks if there are any matching fields
		{
			$bool = false; // sets bool to false
			Print '<script>alert("Username has been taken!");</script>'; //Prompts the user
			Print '<script>window.location.assign("register.php");</script>'; // redirects to register.php
		}
	}
	if($bool){
        $sql = "INSERT INTO Users (username, password) VALUES ('$username','$password')";
        if (!mysqli_query($con,$sql)) {
            die('Error: ' . mysqli_error($con));
        } else {
            Print '<script>alert("Successfully Registered!");</script>'; // Prompts the user
            Print '<script>window.location.assign("register.php");</script>'; // redirects to register.php
            echo "1 record added";
        }
    }
    mysqli_close($con);
}
?>

<?php
	session_start(); //starts the session
	if($_SESSION['user']){ //checks if user is logged in
	}
	else{
		header("location:index.php"); // redirects if user is not logged in
	}
	if($_SERVER['REQUEST_METHOD'] == "GET")
	{
        $con= mysqli_connect("127.0.0.1","root","mary2016","TicketHistory");
        // Check connection
        if (mysqli_connect_errno()) {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
		$list_id = $_GET['list_id'];
		$sql= "DELETE FROM list WHERE list_id='$list_id'";
        if (!mysqli_query($con,$sql)) {
            die('Error: ' . mysqli_error($con));
            mysqli_close($con);
        } else {
            echo "1 record Updated";
            mysqli_close($con);
            header("location: home.php");
        }
	}
?>
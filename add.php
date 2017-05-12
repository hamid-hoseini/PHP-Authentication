<?php
	session_start();
	if($_SESSION['user']){
	}
	else{
		header("location:index.php");
	}

	if($_SERVER['REQUEST_METHOD'] = "POST") //Added an if to keep the page secured
	{
		$con = mysqli_connect("127.0.0.1","root","mary2016","TicketHistory");
        // Check connection
        if (mysqli_connect_errno()) {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
		$details = mysqli_real_escape_string($con, $_POST['details']);
		$time = strftime("%X");//time
		$date = strftime("%B %d, %Y");//date
		$decision ="no";

		foreach($_POST['public'] as $each_check) //gets the data from the checkbox
 		{
 			if($each_check !=null ){ //checks if the checkbox is checked
 				$decision = "yes"; //sets teh value
 			}
 		}
 		$sql = "INSERT INTO List (details, date_posted, time_posted, date_edited, time_edited, public) VALUES ('$details','$date','$time','$date','$time','$decision')";
       if (!mysqli_query($con,$sql)) {
            die('Error: ' . mysqli_error($con));
            header("location:home.php"); //redirects back to hom

        } else {
            echo "1 record added";
        	header("location: home.php");
            //Print '<script>alert("Successfully Registered!");</script>'; // Prompts the user
            //Print '<script>window.location.assign("register.php");</script>'; // redirects to register.php
        }
	}
	else
	{
		header("location:home.php"); //redirects back to hom
	}
?>
<html>
	<head>
		<title>My first PHP website</title>
	</head>
	<?php
	session_start(); //starts the session
	if($_SESSION['user']){ //checks if user is logged in
	}
	else{
		header("location:index.php"); // redirects if user is not logged in
	}
	$user = $_SESSION['user']; //assigns user value
	$id_exists = false;
	?>
	<body>
		<h2>Home Page</h2>
		<p>Hello <?php Print "$user"?>!</p> <!--Displays user's name-->
		<a href="logout.php">Click here to logout</a><br/><br/>
		<a href="home.php">Return to Home page</a>
		<h2 align="center">Currently Selected</h2>
		<table border="1px" width="100%">
			<tr>
				<th>Id</th>
				<th>Details</th>
				<th>Post Time</th>
				<th>Edit Time</th>
				<th>Public Post</th>
			</tr>
			<?php
				if(!empty($_GET['list_id']))
				{
					$list_id = $_GET['list_id'];
					$_SESSION['list_id'] = $list_id;
					$id_exists = true;
                    $con= mysqli_connect("127.0.0.1","root","mary2016","TicketHistory");

                    // Check connection
                    if (mysqli_connect_errno()) {
                      echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    }
                    $sql= "Select * from list Where list_id='$list_id'";
                    $query = mysqli_query($con,$sql);
                    if (!$query) {
                        die('Error: ' . mysqli_error($query));
                    } else {
                        $count = mysqli_num_rows( $query);
                        if($count > 0)
                        {
                            while($row = mysqli_fetch_array($query))
                            {
                                Print "<tr>";
                                    Print '<td align="center">'. $row['list_id'] . "</td>";
                                    Print '<td align="center">'. $row['details'] . "</td>";
                                    Print '<td align="center">'. $row['date_posted']. " - ". $row['time_posted']."</td>";
                                    Print '<td align="center">'. $row['date_edited']. " - ". $row['time_edited']. "</td>";
                                    Print '<td align="center">'. $row['public']. "</td>";
                                Print "</tr>";
                            }
                        }
                        else
                        {
                            $id_exists = false;
                        }
                    }
                    mysqli_close($con);
				}
			?>
		</table>
		<br/>
		<?php
		if($id_exists)
		{
		Print '
		<form action="edit.php" method="POST">
			Enter new detail: <input type="text" name="details"/><br/>
			public post? <input type="checkbox" name="public[]" value="yes"/><br/>
			<input type="submit" value="Update List"/>
		</form>
		';
		}
		else
		{
			Print '<h2 align="center">There is no data to be edited.</h2>';
		}
		?>
	</body>
</html>

<?php
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
        $con= mysqli_connect("127.0.0.1","root","mary2016","TicketHistory");

        // Check connection
        if (mysqli_connect_errno()) {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
		$details = mysqli_real_escape_string($con, $_POST['details']);
		$public = "no";
		$list_id = $_SESSION['list_id'];
		$time = strftime("%X");//time
		$date = strftime("%B %d, %Y");//date

		foreach($_POST['public'] as $list)
		{
			if($list != null)
			{
				$public = "yes";
			}
		}
        $sql= "UPDATE List SET details='$details', public='$public', date_edited='$date', time_edited='$time' WHERE list_id='$list_id'";
        if (!mysqli_query($con,$sql)) {
            die('Error: ' . mysqli_error($con));
//            mysqli_close($con);
        } else {
        	echo "1 record Updated";
        	mysqli_close($con);
            header("location: home.php");
        }

	}
?>
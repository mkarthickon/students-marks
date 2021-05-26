<?php

$conn = mysqli_connect('localhost', 'root', '', 'test');
if(!$conn){
	die('Could not Connect My Sql:' .mysql_error());
}

if(isset($_GET["save"]))
{
	$id 			= $_GET['id'];
	$rollno 		= $_GET['rollno'];
	$name 			= $_GET['name'];
	$email 			= $_GET['email'];
	$mobile 		= $_GET['mobile'];
	$dept 			= $_GET['dept'];
	$subject		= $_GET['subject'];
	$mark_obtain	= $_GET['mark_obtain'];
	$result			= $_GET['result'];
	$grade 			= $_GET['grade'];
	
	if(!empty($mark_obtain))
	{
		$id				= mysqli_real_escape_string($conn,$id);
		$rollno			= mysqli_real_escape_string($conn,$rollno);
		$name			= mysqli_real_escape_string($conn,$name);		
		$email			= mysqli_real_escape_string($conn,$email);
		$mobile			= mysqli_real_escape_string($conn,$mobile);
		$dept			= mysqli_real_escape_string($conn,$dept);
		$subject		= mysqli_real_escape_string($conn,$subject);
		$mark_obtain	= mysqli_real_escape_string($conn,$mark_obtain);
		$result			= mysqli_real_escape_string($conn,$result);
		$grade			= mysqli_real_escape_string($conn,$grade);

		$upd = "Update students set rollno = '$rollno', name = '$name'
				, email = '$email' , mobile = '$mobile' , dept = '$dept' where rollno = '$rollno' ";
													
		mysqli_query($conn, $upd);
		echo mysqli_error($conn);

		$sresult = "Update results set subject='$subject', mark_obtain='$mark_obtain', result='$result', grade='$grade' where rollno ='$rollno' and id = '$id' ";
				
		mysqli_query($conn, $sresult);
		echo mysqli_error($conn);

		echo '<script>alert("Update Successfully")</script>';
		
		header("location: index.php");					
		mysqli_close($conn);
	}
	else
	{
		echo '<script>alert("Mark Obtain Should not be empty")</script>';
	}
}

if(isset($_GET['delete']))
{
	$id 			= $_GET['id'];
	$rollno 		= $_GET['rollno'];
	$name 			= $_GET['name'];
	$email 			= $_GET['email'];
	$mobile 		= $_GET['mobile'];
	$dept 			= $_GET['dept'];
	$subject		= $_GET['subject'];
	
	$sql_dup2 = "select * from results where rollno = '$rollno'";
	$exe_dup2 = mysqli_query($conn,$sql_dup2);
	$check_dup2 = mysqli_num_rows($exe_dup2);
	
	if($check_dup2 > 1)
	{
		$rdeleted = "Delete from results where id = '$id' and rollno = '$rollno' and subject = '$subject' ";
		
		mysqli_query($conn, $rdeleted);
		echo mysqli_error($conn);
			
		echo '<script>alert("Deleted Successfully")</script>';
	}
	else if($check_dup2 == 1)
	{
		$sdelete = "Delete from students where rollno = '$rollno' ";
		mysqli_query($conn, $sdelete);
			echo mysqli_error($conn);
			
		$rdelete = "Delete from results where id = '$id' and rollno = '$rollno' and subject = '$subject' ";
		
		mysqli_query($conn, $rdelete);
		echo mysqli_error($conn);
			
		echo '<script>alert("Deleted Successfully")</script>';			
	}
	header("location: index.php");	
	mysqli_close($conn);
	
	
}
?>
<html>
<head>
<title>EDIT/Delete PAGE</title>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	
	
	<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<style>
.bs-example{
    	margin: 20px;
    }
	
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 10px 15px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  margin: 4px 2px;
  cursor: pointer;
}

.button1 {font-size: 13px;}
.button2 {font-size: 13px;}

</style>
</head>
<script>

function marks(vals) 
{		
	if(vals < 50)
	{
		var result = document.getElementById("result").value = "Fail";
		var grade = document.getElementById("grade").value = "Fail";
	}
	else if(vals >= 50)
	{
		var result = document.getElementById("result").value = "Pass";
		var grade = document.getElementById("grade").value = "Pass";
	}
	if(vals == "")
	{
		var result = document.getElementById("result").value = "";
		var grade = document.getElementById("grade").value = "";
	}
	
	if(vals >= 50 && vals <= 60)
	{
		var grade = document.getElementById("grade").value = "C";
	}
	else if(vals >= 61 && vals <= 70)
	{
		var grade = document.getElementById("grade").value = "B";
	}
	else if(vals >= 71 && vals <= 80)
	{
		var grade = document.getElementById("grade").value = "A";
	}
	else if(vals >= 81 && vals <= 90)
	{
		var grade = document.getElementById("grade").value = "A+";		
	}
	else if(vals >= 90)
	{
		var grade = document.getElementById("grade").value = "S";
	}
}
</script>
<body>
<form method="GET" id= "myForm" enctype="multipart/form-data">
<table class="table">
	<tr style="background-color:#454d55;">
		<td colspan="4" align="Center" style="color:#fff"><b>ICC EDUCATION INTERVIEW TASK</b></td>
	</tr>
	<tr hidden style="background-color:#454d55;">
		<td style="color:#fff">id</td>
		<td><input type="text" name="id" value = "<?php if(isset($_GET['id'])){ echo $_GET['id']; }?>" ></td>
		
	</tr>
	<tr style="background-color:#454d55;">
		<td style="color:#fff">Roll No</td>
		<td><input type="text" name="rollno" value = "<?php if(isset($_GET['rollno'])){ echo $_GET['rollno']; }?>" required></td>
		<td style="color:#fff">Student Name</td>
		<td><input type="text" readonly name="name" value = "<?php if(isset($_GET['name'])){ echo $_GET['name']; }?>"/></td>
	</tr>
	
  <tr style="background-color:#454d55;">
    <td style="color:#fff">Email-id</td>
    <td><input type="email" readonly name="email"  value = "<?php if(isset($_GET['email'])){ echo $_GET['email']; }?>" required /></td>
	<td style="color:#fff">Mobile</td>
    <td><input type="text" readonly maxlength="10" name="mobile" pattern="[0-9]+" value = "<?php if(isset($_GET['mobile'])){ echo $_GET['mobile']; }?>" required /></td>
  </tr>
  
  <tr style="background-color:#454d55;">
    <td style="color:#fff">Department</td>
    <td>
		<select name="dept" id="dept" style="width:180px;background-color:lightgrey;" readonly>
			<option value="cse"   <?php if($_GET['dept'] == "cse"){?> selected="selected"  <?php }?>>CSE</option>
			<option value="civil" <?php if($_GET['dept'] == "civil"){?> selected="selected" <?php }?>>CIVIL</option>
			<option value="eee"   <?php if($_GET['dept'] == "eee"){?> selected="selected" <?php }?>>EEE</option>
			<option value="ece"   <?php if($_GET['dept'] == "ece"){?> selected="selected" <?php }?>>ECE</option>
			<option value="mech"  <?php if($_GET['dept'] == "mech"){?> selected="selected" <?php }?>>MECH</option>
		</select>
	</td>
	<td style="color:#fff">Subject</td>
    <td>
		<select name="subject" id="subject" style="width:180px;background-color:lightgrey;">
		<option value="maths" <?php if($_GET['subject'] == "maths"){?> selected="selected"  <?php }?>>Maths</option>
		<option value="tamil" <?php if($_GET['subject'] == "tamil"){?> selected="selected"  <?php }?>>Tamil</option>
		<option value="computer" <?php if($_GET['subject'] == "computer"){?> selected="selected"  <?php }?>>Computer</option>
		</select>
	</td>
  </tr>
 
  <tr style="background-color:#454d55;">
    <td style="color:#fff">Mark Obtain</td>
    <td><input type="text" name="mark_obtain" onkeyup="marks(this.value);"/></td>
	 <td style="color:#fff">Result</td>
    <td><input type="text"  id="result" name="result" readonly /></td>
  </tr>
  
  <tr style="background-color:#454d55;">
    <td style="color:#fff">Grade</td>
    <td colspan="3"><input type="text" id="grade"  name="grade" readonly /></td>
  </tr>
  <tr style="background-color:#454d55;">
	<td colspan="4" align="center"><input type="submit"  class="button button1" name="save" width="50" value="Update"/>
	<input type="submit" name="delete" class="button button2" value="Delete">
	</td>
  </tr>
  <tr style="background-color:#454d55;">
  <td style="color:#fff"> 
  Conditions
  </td>
  <td colspan="3" style="color:#fff">
  <p>Below 50 - Fail, Above 50 - pass,  50 - 60 Mark - C, 61 - 70 Mark - B, 71 - 80 Mark - A, 81 - 90 Mark - A+, Above 90 Mark Grade - S.</p>
  </td>
  </tr>
</table>
</form>
</body>
</html>

<?php
if(isset($_POST["save"]))
{
	$conn = mysqli_connect('localhost', 'root', '', 'test');
	if(!$conn){
		die('Could not Connect My Sql:' .mysql_error());
	}
	
	$rollno 		= $_POST['rollno'];
	$name 			= $_POST['studentname'];
	$email 			= $_POST['email'];
	$mobile 		= $_POST['mobile'];
	$dept 			= $_POST['dept'];
	$subject		= $_POST['subject'];
	$mark_obtain	= $_POST['mark_obtain'];
	$result			= $_POST['result'];
	$grade 			= $_POST['grade'];
	
	if(!empty($rollno))
	{
		$rollno			= mysqli_real_escape_string($conn,$rollno);
		$name			= mysqli_real_escape_string($conn,$name);		
		$email			= mysqli_real_escape_string($conn,$email);
		$mobile			= mysqli_real_escape_string($conn,$mobile);
		$dept			= mysqli_real_escape_string($conn,$dept);
		$subject		= mysqli_real_escape_string($conn,$subject);
		$mark_obtain	= mysqli_real_escape_string($conn,$mark_obtain);
		$result			= mysqli_real_escape_string($conn,$result);
		$grade			= mysqli_real_escape_string($conn,$grade);
		
		$sql_dup = "select * from students s, results r where s.rollno = r.rollno and s.dept = '$dept' and s.rollno = '$rollno' and r.subject = '$subject' ";
		$exe_dup = mysqli_query($conn,$sql_dup);
		$check_dup = mysqli_fetch_array($exe_dup);
		
		if(empty($check_dup))
		{
			$sql_dup2 = "select * from students where dept = '$dept' and rollno = '$rollno' and name = '$name' and mobile = '$mobile' ";
			$exe_dup2 = mysqli_query($conn,$sql_dup2);
			$check_dup2 = mysqli_fetch_array($exe_dup2);
			
			if(empty($check_dup2))
			{
				$student = "INSERT INTO students (rollno, name, email, mobile, dept) 
						VALUES ('$rollno', '$name', '$email', '$mobile', '$dept')";
						
				mysqli_query($conn, $student);
				echo mysqli_error($conn);
			}
			else if(!empty($check_dup2))
			{
				$upd = "Update students set rollno = '$rollno', name = '$name'
					, email = '$email' , mobile = '$mobile' , dept = '$dept' where rollno = '$rollno' ";
														
				mysqli_query($conn, $upd);
				echo mysqli_error($conn);
			}
					
			$sresult = "INSERT INTO results (rollno, subject, total_mark, mark_obtain, result, grade) 
					VALUES ('$rollno', '$subject', '100', '$mark_obtain', '$result', '$grade')";
					
			mysqli_query($conn, $sresult);
			echo mysqli_error($conn);
		}
		else
		{
			echo '<script>alert("Duplicate Records Not allowed")</script>';			
		}
	}
			
	mysqli_close($conn);
}

?>

<html>
<head>
<title>Registration Form</title>
<style>
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
<form method="post" enctype="multipart/form-data">
<table class="table">
	<tr style="background-color:#454d55;">
		<td colspan="4" align="Center" style="color:#fff"><b>ICC EDUCATION INTERVIEW TASK</b></td>
	</tr>
	<tr style="background-color:#454d55;">
		<td style="color:#fff">Roll No</td>
		<td><input type="text" name="rollno" required></td>
		<td style="color:#fff">Student Name</td>
		<td><input type="text" name="studentname" required /></td>
	</tr>
	
  <tr style="background-color:#454d55;">
    <td style="color:#fff">Email-id</td>
    <td><input type="email" name="email" required /></td>
	<td style="color:#fff">Mobile</td>
    <td><input type="text" maxlength="10" name="mobile" pattern="[0-9]+" name="m" required /></td>
  </tr>
  
  <tr style="background-color:#454d55;">
    <td style="color:#fff">Department</td>
    <td>
		<select name="dept" id="dept" style="width:180px;background-color:lightgrey;">
		<option value="cse">CSE</option>
		<option value="civil">CIVIL</option>
		<option value="eee">EEE</option>
		<option value="ece">ECE</option>
		<option value="mech">MECH</option>
		</select>
	</td>
	<td style="color:#fff">Subject</td>
    <td>
		<select name="subject" id="subject" style="width:180px;background-color:lightgrey;">
		<option value="maths">Maths</option>
		<option value="tamil">Tamil</option>
		<option value="computer">Computer</option>
		</select>
	</td>
  </tr>
 
  <tr style="background-color:#454d55;">
    <td style="color:#fff">Mark Obtain</td>
    <td><input type="text" name="mark_obtain" onkeyup="marks(this.value);" /></td>
	 <td style="color:#fff">Result</td>
    <td><input type="text"  id="result" name="result" readonly /></td>
  </tr>
  
  <tr style="background-color:#454d55;">
    <td style="color:#fff">Grade</td>
    <td colspan="3"><input type="text" id="grade"  name="grade" readonly /></td>
  </tr>
  <tr style="background-color:#454d55;">
	<td colspan="4" align="center"><input type="submit"  class="button button1" name="save" width="50" value="Add New Record"/>
	<input type="reset" id="clear" class="button button2" value="Clear">
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

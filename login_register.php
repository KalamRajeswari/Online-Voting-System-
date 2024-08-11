
<html lang="en">
<head>
    <link rel="stylesheet" href="login_register.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
.error {color: #FF0000;
        margin-left:200px;}
.result1{
    margin-left:200px;
    color:green;
}
.result2{
    margin-left:200px;
    color:red;
}
</style>
<?php
$nameErr = $passErr = $cpassErr = $mobileErr =$dupli="";
$name = $pass = $cpass = $mobile = $result="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
  $pass=test_input($_POST["pass"]);
  $cpass=test_input($_POST["cpass"]);
  if($pass!==$cpass)
        $cpassErr="password and confirm password is not match";
    else
        $cpassErr="";

    $mobile=test_input($_POST["mobile"]);
    $img=test_input($_POST["img"]);
    $group=test_input($_POST["dropdown"]);
    if(empty($nameErr) && empty($cpassErr)){
        $conn=mysqli_connect("localhost","root","","VOTING");
        $sql1="select * from registration;";
        $query1=mysqli_query($conn,$sql1);
        if($query1)
        {
             if (mysqli_num_rows($query1) > 0) {
                while($row = mysqli_fetch_assoc($query1)) {
                 $dname= $row["name"];
                 $dmobile=$row["mobile"];
                 if(($dname==$name)&&($dmobile==$mobile))
                 {
                    $dupli="You already registerd";
                    break;
                 }
            }
         }

        }
        if(empty($dupli)){
        $sql="insert into registration(name,mobile,password,cpassword,profile,category) values('$name','$mobile','$pass','$cpass','$img','$group')";
        $sql2="insert into voter(mobile) values('$mobile')";
        $query2=mysqli_query($conn,$sql2);
        $query=mysqli_query($conn,$sql);
        if($query){
            $result1= "Registartion successfully";}
        else{
            $result2= "Registration is not successfull";
        }
    }
    if($group=="Group"){
        $conn=mysqli_connect("localhost","root","","VOTING");
        $sql3="insert into nominee(name,mobile,profile)values('$name','$mobile','$img')";
        $query3=mysqli_query($conn,$sql3);
    }
    }

}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

?>
<body>
    <center><h1 style="font-family: 'Courier New', Courier, monospace;">Online Voting System</h1></center>
    <hr>
    <div class="register">
    <form action="login_register.php" method="post">
    <div class="row">
    <input type="text" name="name" placeholder="Enter name.." required>
    <input type="text" name="mobile" placeholder="Enter mobile.." pattern="[0-9]{10}" title="mobile number must be 10 digits" required>
    </div>
    <div class="row">
    <input type="password" name="pass" placeholder="Enter password.." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain atleast one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
    <input type="password" name="cpass" placeholder="Confirm Password.." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain atleast one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
    </div>
    <div class="upload">
        Upload Image:<input type="file" name="img" accept=".jpg,.jpeg,.png" required>
    </div>
    <div class="dropdown">
        Select your role:
        <select name="dropdown" required>
            <option>Voter</option>
            <option>Group</option>
        </select>
    </div>
    <button type="submit" name="Register">Register</button>
    <p class="link">Already register?<a href="login_vote.php">Login here</a></p>
    <p class="error"><?php echo $cpassErr;?></p>
    <p class="error"><?php echo $nameErr;?></p>
    <p class="result1"><?php echo $result1;?></p>
    <p class="result2"><?php echo $result2;?></p>
    <p class="result2"><?php echo $dupli;?></p>
    </form>
</div>
</body>
</html>
<?php
    session_start();
?>

<html lang="en">
<head>
    <link rel="stylesheet" href="login_vote.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .error{
        color:red;
        margin-left:80px;
    }
</style>
<?php
$result="";
    if(isset($_POST["login"])){
        $mobile=$_POST["mobile"];
        $_SESSION["mobile"]=$mobile;
        $pass=$_POST["pass"];
        $conn=mysqli_connect("localhost","root","","VOTING");
        $sql1="select * from registration;";
        $query1=mysqli_query($conn,$sql1);
        if($query1)
        {
             if (mysqli_num_rows($query1) > 0) {
                while($row = mysqli_fetch_assoc($query1)) {
                 $dpass= $row["password"];
                 $dmobile=$row["mobile"];
                 if(($dpass==$pass)&&($dmobile==$mobile))
                 {
                    $result="successfully login";
                    header("Location:vot_details.php");
                    break;
                 }
            }
            }
        
        }
        else
        {
            echo "technical issue";
        }
        if(empty($result)){
                $result="You entered incorrect crenditials";
        }
    }
?>
<body>
    <center><h1 style=" font-family: 'Courier New', Courier, monospace;">Online Voting System</h1></center>
    <hr>
    <div class="form">
    <form action="" method="post">
        <div class="row">
        <input type="text" name="mobile" placeholder="enter mobile" required>
        <input type="password" name="pass" placeholder="enter password" required>
        <button type="submit" name="login">Login</button>
        <p class="link">New Voter?<a href="login_register.php">register here</a></p>
        <p class="error"><?php echo $result;?></p>
        </div>
    </form>
    </div>
</body>
</html>

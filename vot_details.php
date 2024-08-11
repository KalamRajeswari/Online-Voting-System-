<?php
    session_start();
?>
<html lang="en">
<head>
    <link rel="stylesheet" href="vot_details.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
.heading{
    display:flex;
    flex-direction:row;
    justify-content:space-around;
}
.h1{
    font-family: 'Courier New', Courier, monospace;
    color:black;
}
.result{
margin-top:15px;
margin-right:20px;
outline:0;
border:0;
border-radius:10px;
padding:15px;
color:black;
font-size:15px;
background-color:pink;
cursor:pointer;
}
</style>
<body>
    <form action="vot_details.php" method="post">
    <div class="heading">
    <div><h1 class='h1'>Online Voting System</h1></div>
    <div><button type="button" name="result" class="result"><a href='vot_result.php'>Result</a></button></div>
    </div>
    <hr> 
    <div class="details">
   <div class="vot_details">
        <?php 
            $conn=mysqli_connect("localhost","root","","VOTING");
            $mobile=$_SESSION["mobile"];
            $sql="select * from registration where mobile='$mobile'";
            $sql1="select * from voter where mobile='$mobile'";
            $query=mysqli_query($conn,$sql);
            $query1=mysqli_query($conn,$sql1);
            if($query)
            {
                $row = mysqli_fetch_assoc($query);
                $row1=mysqli_fetch_assoc($query1);
                $img=$row["profile"];
                $name=$row["name"];
                global $mobile1;
                $mobile1=$row["mobile"];
                $fol="images/";
                $img1=$fol.$img;
                $status=$row1["status"];
                echo 
                "<html>
                    <body>
                    <p>
                    <div style='font-size:12px;'>
                        <img src='$img1' alt='tv'  width='100' height='100'><br><br>
                        <b>Name:</b>$name<br><br>
                        <b>Mobile:</b>$mobile1<br><br>
                        <b>Status:</b><object id='status'>$status</object>
                    </div>
                    </p>
                    </body>
                </html>";
                echo 
                "<script>
                    let res=document.getElementById('status');
                    if(res.value=='Not Voted')
                        res.style.color='red';
                    else
                        res.style.color='green';
                </script>";
            }
        ?>
    </div> 
    <div class="nominee_details">
        <?php
            $conn=mysqli_connect("localhost","root","","VOTING");
            $mobile=$_SESSION["mobile"];
            $sql="select * from nominee;";
            $query=mysqli_query($conn,$sql);
            if($query)
            {
                if (mysqli_num_rows($query) > 0){
                    global $i,$j;
                    $mobile=[];
                    $i=$j=mysqli_num_rows($query);
                while($row = mysqli_fetch_assoc($query)){
                    $img=$row["profile"];
                    $name=$row["name"];
                    $mobile[$i]=$row["mobile"];
                    $vote=$row["vote"];
                    $fol="images/";
                    $img1=$fol.$img;
                    $v="vote";
                    $id=$v.$i;
                    echo 
                    "<html>
                    <style>
                    .button{
                        margin-left:20px;
                        background-color:green;
                        color:white;
                        outline:0;
                        border:0;
                        padding:10px;
                        border-radius:10px;
                        cursor:pointer;
                    }
                    .votes{
                        font-size:12px;
                        width:50%;
                        height:150px;
                    }
                    </style>
                    <body>
                    <p>
                        <div>
                        <img src='$img1' alt='tv'  style='float:right;' width='100' height='100'>
                        <b>Name:</b>$name<br><br>
                        <b>Mobile:</b>$mobile[$i]<br><br>
                        <b>Votes:</b>$vote<br><br>
                        <button class='button' id='$id' name='$id'>Vote</button>
                        <hr>
                        </div>
                    </p>
                    </body>
                    </html>";
                    $i=$i-1;
                 }
                }
                else{
                    echo "
                    <html>
                    <body>
                    <p><h1>NO nominees are available</h1></p>
                    </body>
                    </html>";
                }
            }
            $sql="select * from voter where mobile='$mobile1';";
            $query=mysqli_query($conn,$sql);
            $row=mysqli_fetch_assoc($query);
            $s=$row['status'];
            if($s!='Voted'){
            for($k=$j;$k>0;$k--){
                $id="vote".$k;
                if(isset($_POST["$id"])){
                    $sql1="update voter set status='Voted' where mobile='$mobile1';";
                    $sql2="update nominee set vote=vote+1 where mobile='$mobile[$k]';";
                    $query1=mysqli_query($conn,$sql1);
                    $query2=mysqli_query($conn,$sql2);
                    if($query1 && $query2){
                        echo "successful";
                        echo "<script>
                            function disable(i){
                            let k=0;
                            for(k=i;k>0;k--){
                            id='vote'+k;
                            document.getElementById(id).disabled=true;
                            document.getElementById(id).style.backgroundColor='red';
                            document.getElementById(id).textContent='Voted';
                            }
                        }
                        disable($j);
                        </script>";
                        #header("Location:vot_details.php");
                        break;
                    }
                }
            }
        }
        else{
            echo "<script>
                            function disable(i){
                            let k=0;
                            for(k=i;k>0;k--){
                            id='vote'+k;
                            document.getElementById(id).disabled=true;
                            document.getElementById(id).style.backgroundColor='red';
                            document.getElementById(id).textContent='Voted';
                            }
                        }
                        disable($j);
                        </script>";
        }
            ?>
    </div>
</div>
</form>
</body>
</html>
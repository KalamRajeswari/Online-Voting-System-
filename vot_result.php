
<?php 
        $conn=mysqli_connect("localhost","root","","VOTING");
        $sql="select vote from nominee;";
        $query=mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($query);
        if(mysqli_num_rows($query)>0){
           $ma=max($row);
           $sql1="select * from nominee where vote='$ma';";
           $result=mysqli_query($conn,$sql1);
           $i=mysqli_num_rows($result);
           while($row1 = mysqli_fetch_assoc($result)){
                $name=$row1['name'];
                $img=$row1['profile'];
                $img1='images/'.$img;
                 echo "
                 <html>
                 <style>
                 .result{
                    text-align:center;
                    width:50%;
                    height:50%;
                    background-color:rgba(37, 98, 109, 0.322);
                    color:black;
                    font-size:20px;
                    margin-top:100px;
                    margin-left:300px;
                    font-family: 'Courier New', Courier, monospace;
                }
                </style>
                 <body class='result'>
                 <center>
                 <h1>WINNERS IN THE VOTING ARE:</h1>
                 <img src='$img1' width='100' height='100'>'
                 <p style='color:green'>'$name'</p>
                 </center>
                </body>
                </html>
                    ";
           }
        }
        else{
            echo "
                <html>
                <body>
                <p><h1 style='color:green;'>No Nominees are present</h1></p>
                </body>
                </html>
                ";
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Making_schedule</title>
    <link rel="stylesheet" href="../css/header.css">
</head>
<body>
    <div class="header">
        <div class= "title">
            IMS Making Schedule
        </div>
        <div class="tite_logo">
            <img src="img/IMS_logo.jpg" class="logo_img">
        </div>
        <div class="banner">
            <ul>
                <li><a href="make.php">Making Schedule</a></li>
                <li><a href="makelist.php">Searching Student</a></li>
                <li><a href="teachers_ok.php">Teacher's info</a></li>
                <li><a href="personal.php">All classes</a></li>
            </ul>
        </div>
    </div>
</body>
</html>

<style>
.title{
    position: absolute;
    font-size: 30px;
    margin-top: 4vw;
    margin-left:28vw;
    font-weight: 600;
}
.logo_img{
    position:absolute;
    top:40px;
    left: 50%;
    z-index: 10;
    display: block;
    transform: translateX(-50%);
}

.banner{
    position:absolute;
    top: 150px;
    left: 50%;
    z-index:10;
    display: block;
    border: 1px solid black;
    border-radius: 33px;
    background-color: beige;
    transform: translateX(-50%);

    font-size: 1.3rem;
    line-height: 1rem;
    color:black;

}

.banner ul li {
    display: inline-block;
    
}

.banner ul li a{
    text-decoration: none;
    margin-left: 0.5vw;
    margin-right: 2vw;
    color: black;
    font-weight: 400;
}

.container{
    position: absolute;
    top: 220px;
    left: 50%;
    transform: translateX(-50%);
}

.edit-btn, .delete-btn {
    margin-left: 10px;
    cursor: pointer;
    color: blue;
    text-decoration: underline;
}
</style>

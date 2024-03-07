<?php
include_once("main.php");
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <style>

        .container {
            background-color: #fff;
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            text-align: center;
        }

        form {
            display: inline-block;
            text-align: left;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        select,
        input[type="date"] {
            padding: 8px;
            margin: 5px 0;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Optional: Style for the title */


        .score {
            margin: 3px;
            position: relative;
        }
    </style>
</head>

<body>
    <div class="container">
        <a style="font-size: 25px;">Student Information</a>
        <br>
        <br/>
        <form method="post" id="studentForm" action="makelist.php">
            <label for="name">STUDENT NAME:</label>
            <input type="text" id="name" name="name" required><br>
        
            <label for="course">COURSE:</label>
            <select id="course" name="course">
                <option value="Select">SELECT</option>
                <option value="Premium">PREMIUM</option>
                <option value="Intensive">INTENSIVE</option>
                <option value="Esl-Essential">ESL Essential</option>
                <option value="Power-Speaking">POWER SPEAKING</option>
                <option value="IELTS-Academic">IELTS ACADEMIC</option>
                <option value="IELTS-General">IELTS GENERAL</option>
                <option value="Pre-IELTS-Academic">PRE - IELTS ACADEMIC</option>
                <option value="Pre-IELTS-General">PRE - IELTS GENERAL</option>
                <option value="Pre-Toeic">PRE TOEIC</option>
                <option value="Toeic">TOEIC</option>
                <option value="Business">BUSINESS</option>
                <option value="Parent">PARENT</option>
                <option value="Junior-6">JUNIOR 6</option>
                <option value="Junior-8">JUNIOR 8</option>
                <option value="Junior-9">JUNIOR 9</option>
                <option value="NO-COURSE">NO COURSE</option>
            </select><br>
            
        
            <label for="level">LEVEL:</label>
            <select id="level" name="level">
                <option value="select_leverl">SELECT</option>
                <option value="Beginner-1">Beginner 1</option>
                <option value="Elementary-2">Elementary 2</option>
                <option value="Elementary-3">Elementary 3</option>
                <option value="Pre-Intermediate-4">Pre Intermediate 4</option>
                <option value="Intermediate-5">Intermediate 5</option>
                <option value="Intermediate-6">Intermediate 6</option>
                <option value="Upper-Intermediate-7">Upper Intermediate 7</option>
                <option value="Upper-Intermediate-8">Upper Intermediate 8</option>
                <option value="Advanced-9">Advanced 9</option>
                <option value="Advanced-10">Advanced 10</option>
                <option value="Advanced-11">Advanced 11</option>
                <option value="Master-12">Master 12</option>
                <option value="No-Level">NO LEVEL</option>
            </select><br>

            <div class="score">
                <label for ="reading">Reading score:</label>
                <input type="text" name="reading" required>
                
                <label for = "speaking">Speaking score:</label>
                <input type="text" name="speaking" required>

                <label for ="grammar">Listening score:</label>
                <input type="text" name="grammar" required>
                
                <label for = "vocabulary">Writing score:</label>
                <input type="text" name="vocabulary" required>
                
            </div>

            <label for="startdate">Start Date:</label>
            <input type="date" id="startdate" name="startdate" required><br>

            <label for="enddate">End Date:</label>
            <input type="date" id="enddate" name="enddate" required><br>
        
            <input type="submit" value="Proceed" name="proceed">
        </form>
    </div>
    <script src="../js/make.js"></script>
</body>
</html>
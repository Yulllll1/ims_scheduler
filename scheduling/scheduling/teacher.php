<?php
include_once("main.php");
?>
<html>

<style>


        .container {
            position: absolute;
            display: inline-block;
            margin: auto;
            overflow: hidden;
        }

        table {
            width: 25%;
            position: absolute;
            top:400px;
            left: 50%;
            transform: translateX(-50%);
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"], input[type="submit"] {
            padding: 5px;
            margin-bottom: 5px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .no-results {
            margin-top: 20px;
            color: #ff0000;
        }
    </style>

    <div class="container">
        <h1> Teacher's Name and Room list</h1>
        
        <form method="post">
            <div style='display: inline-block;'>
                <label for="name">Name:</label>
                <input type="text" name="name" required><br>
            </div>
            <div style='display: inline-block;'>
                <label for="room">Room:</label>
                <input type="text" name="room" required><br>
            </div>
            <div style='display: inline-block;'>
                <label for="course">Course:</label>
                <select id="course" name="course">
                    <option value = "ESL">ESL</option>
                    <option value = "Special">SPECIAL</option>
                </select>
            </div>

        <input type="submit" value="Proceed" name="proceed">
    </form>
    </div>
    <script src="../js/teacher.js"></script>

</html>
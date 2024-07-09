<?php
// Include header file
include('include/header.php');
?>

<?php
// Include db connection
include('include/db_connect.php');
?>

<div class="stock-container">
    <div class="stock-container-inner">
        <section id="blood-stock">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Location</th>
                        <th>Blood Bottle</th>
                        <th>Contact Number</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>New York</td>
                        <td>20</td>
                        <td><a href="tel:+1234567890">+1 234 567 890</a></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Los Angeles</td>
                        <td>15</td>
                        <td><a href="tel:+0987654321">+0 987 654 321</a></td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </section>
    </div>
</div>

<?php
   include('include/config.php');
   ?>

<style>
body {
    font-family: Arial, sans-serif;
    background: url('background.jpg') no-repeat center center fixed;
    background-size: cover;
    margin: 0;
    padding: 0;
}

nav {
    background-color: rgba(0, 0, 0, 0.7);
    padding: 10px;
}

nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

nav ul li {
    margin-right: 20px;
}

nav ul li a {
    color: white;
    text-decoration: none;
    padding: 5px 10px;
}

nav ul li a:hover {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 5px;
}

#blood-stock {
    margin: 20px;
    background-color: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background-color: #333;
    color: white;
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

tr:hover {
    background-color: #f1f1f1;
}

a {
    color: blue;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>

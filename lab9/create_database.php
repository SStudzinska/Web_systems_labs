<?php
$servername = 'localhost';
$username = "student";
$password = "student";
$dbname = "user_database";

$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!mysqli_select_db($conn, $dbname)) {
    $sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
    if (mysqli_query($conn, $sql_create_db)) {
        echo "The database has been just created or it already exists\n";
    } else {
        die("Error creating the database: " . mysqli_error($conn));
    }
}

$sql_create_users_table = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

if (mysqli_query($conn, $sql_create_users_table)) {
    echo "Users table is created or it already exists.\n";
} else {
    die("Error creating the users table: " . mysqli_error($conn));
}

$sql_create_info_table = "CREATE TABLE IF NOT EXISTS user_info (
    user_id INT PRIMARY KEY,
    name VARCHAR(50),
    surname VARCHAR(50),
    email VARCHAR(100),
    phone_number VARCHAR(15),
    birthdate DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

if (mysqli_query($conn, $sql_create_info_table)) {
    echo "User_info table is created or it already exists.\n";
} else {
    die("Error creating the user_info table: " . mysqli_error($conn));
}





//adding basic users

$adminUsername = 'admin';
$sql_check_username = "SELECT * FROM users WHERE username = '$adminUsername'";
$result = mysqli_query($conn, $sql_check_username);

if ($result->num_rows == 0) {
    $sql_insert_admin = "INSERT INTO users (username, password) VALUES ('$adminUsername', 'admin')";
    
    if (mysqli_query($conn, $sql_insert_admin) === TRUE) {
        echo "Admin username inserted successfully. ";
    } else {
        echo "Error inserting admin username: " .  mysqli_error($conn);
    }
} else {
    echo "Admin username already exists. ";
}


$sql_insert_admin_info = "INSERT INTO user_info (user_id, name, surname, email, phone_number, birthdate)
                          VALUES ('1', 'Admin', 'Admin', 'admin@example.com', '123456789', '2000-01-01')";

if (mysqli_query($conn, $sql_insert_admin_info) === TRUE) {
    echo "Admin info inserted successfully\n";
} else {
    echo "Error inserting admin info: " .  mysqli_error($conn);
}


$user1Username = 'user';
$sql_check_username1 = "SELECT * FROM users WHERE username = '$user1Username'";
$result = mysqli_query($conn, $sql_check_username1);

if ($result->num_rows == 0) {
    $sql_insert_user = "INSERT INTO users (username, password) VALUES ('$user1Username', 'p@ssword')";
    
    if (mysqli_query($conn, $sql_insert_user) === TRUE) {
        echo "User username inserted successfully. ";
    } else {
        echo "Error inserting user username: " .  mysqli_error($conn);
    }
} else {
    echo "User username already exists";
}

$sql_insert_user1_info = "INSERT INTO user_info (user_id, name, surname, email, phone_number, birthdate)
                          VALUES ('2', 'Jan', 'Kowalski', 'Jan@wp.com', '481234568', '1980-02-12')";

if (mysqli_query($conn, $sql_insert_user1_info) === TRUE) {
    echo "User info inserted successfully. \n";
} else {
    echo "Error inserting user info: " .  mysqli_error($conn);
}

mysqli_close($conn);
?>

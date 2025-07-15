<?php
$host = 'localhost';
$dbname = 'kiplagat_fashion_store';
$username = 'root';
$password = '';

$success_message = "";
$error_message = "";

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");
    
    $sql = "CREATE TABLE IF NOT EXISTS customers (
        id INT(11) NOT NULL AUTO_INCREMENT,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(20) NOT NULL,
        address VARCHAR(255),
        city VARCHAR(50),
        state VARCHAR(50),
        zip_code VARCHAR(10),
        registration_date DATETIME NOT NULL,
        PRIMARY KEY (id)
    )";
    
    $pdo->exec($sql);
    
    $success_message = "Database and tables created successfully! You can now register customers.";
    
} catch (PDOException $e) {
    $error_message = "Error setting up database: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - Kiplagat Fashion Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="images/logo.png" alt="Kiplagat Fashion Store Logo" width="120" height="80">
            </div>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="products.html">Products</a></li>
                    <li><a href="gallery.html">Gallery</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                    <li><a href="register.php">Register</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="content-section">
            <div class="container">
                <h2>Database Setup</h2>
                
                <?php if ($success_message): ?>
                    <div class="message success"><?php echo $success_message; ?></div>
                <?php endif; ?>
                
                <?php if ($error_message): ?>
                    <div class="message error"><?php echo $error_message; ?></div>
                <?php endif; ?>
                
                <div class="form-container">
                    <h3>Database Setup Information</h3>
                    <p>This page sets up the database and tables needed for the Kiplagat Fashion Store website.</p>
                    
                    <h4>What this setup does:</h4>
                    <ul style="text-align: left; margin: 1rem 0;">
                        <li>✓ Creates a database named 'kiplagat_fashion_store'</li>
                        <li>✓ Creates a 'customers' table to store customer registration data</li>
                        <li>✓ Sets up all necessary fields for customer information</li>
                    </ul>
                    
                    <h4>Database Requirements:</h4>
                    <ul style="text-align: left; margin: 1rem 0;">
                        <li>MySQL server running on localhost</li>
                        <li>Username: root</li>
                        <li>Password: (empty - default XAMPP/WAMP setup)</li>
                    </ul>
                    
                    <h4>How to run this setup:</h4>
                    <ol style="text-align: left; margin: 1rem 0;">
                        <li>Make sure you have XAMPP, WAMP, or another MySQL server running</li>
                        <li>Visit this page (setup.php) in your browser</li>
                        <li>The database and tables will be created automatically</li>
                        <li>You can then start registering customers!</li>
                    </ol>
                    
                    <?php if ($success_message): ?>
                        <div style="text-align: center; margin-top: 2rem;">
                            <a href="register.php" class="btn">Register First Customer</a>
                            <a href="customers.php" class="btn" style="margin-left: 1rem;">View Customers</a>
                        </div>
                    <?php else: ?>
                        <div style="text-align: center; margin-top: 2rem;">
                            <p>Refresh this page to run the setup again.</p>
                            <a href="setup.php" class="btn">Refresh Setup</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Kiplagat Fashion Store. All rights reserved.</p>
            <p>Follow us on social media for the latest updates!</p>
        </div>
    </footer>
</body>
</html>

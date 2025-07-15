<?php
$host = 'localhost';
$dbname = 'kiplagat_fashion_store';
$username = 'root';
$password = '';

$customers = [];
$error_message = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query("SELECT * FROM customers ORDER BY registration_date DESC");
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Unknown database') !== false) {
        $error_message = "Database not found. Please run the setup.php file first to create the database.";
    } else {
        $error_message = "Unable to connect to database.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Customers - Kiplagat Fashion Store</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .customer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
            background: white;
        }
        
        .customer-table th,
        .customer-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .customer-table th {
            background-color: #2c3e50;
            color: white;
            font-weight: bold;
        }
        
        .customer-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .customer-table tr:hover {
            background-color: #e8f4f8;
        }
        
        .customer-count {
            background: #3498db;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            display: inline-block;
            margin-bottom: 2rem;
        }
    </style>
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
                <h2>Our Valued Customers</h2>
                
                <?php if ($error_message): ?>
                    <div class="message error"><?php echo $error_message; ?></div>
                    <div class="form-container">
                        <p>To set up the database, please run the setup.php file first.</p>
                        <a href="setup.php" class="btn">Run Database Setup</a>
                    </div>
                <?php else: ?>
                    <div class="form-container">
                        <div class="customer-count">
                            Total Registered Customers: <?php echo count($customers); ?>
                        </div>
                        
                        <?php if (empty($customers)): ?>
                            <p>No customers registered yet. <a href="register.php">Be the first to register!</a></p>
                        <?php else: ?>
                            <table class="customer-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>City</th>
                                        <th>Registration Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($customers as $customer): ?>
                                        <tr>
                                            <td><?php echo $customer['id']; ?></td>
                                            <td><?php echo $customer['first_name'] . ' ' . $customer['last_name']; ?></td>
                                            <td><?php echo $customer['email']; ?></td>
                                            <td><?php echo $customer['phone']; ?></td>
                                            <td><?php echo $customer['city'] ?: 'Not provided'; ?></td>
                                            <td><?php echo date('M j, Y', strtotime($customer['registration_date'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                        
                        <div style="text-align: center; margin-top: 2rem;">
                            <a href="register.php" class="btn">Register New Customer</a>
                        </div>
                    </div>
                <?php endif; ?>
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

<?php
$host = 'localhost';
$dbname = 'kiplagat_fashion_store';
$username = 'root';
$password = '';

$first_name = "";
$last_name = "";
$email = "";
$phone = "";
$address = "";
$city = "";
$state = "";
$zip_code = "";
$success_message = "";
$error_message = "";

if ($_POST) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone)) {
        $error_message = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } else {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $check_email = $pdo->prepare("SELECT id FROM customers WHERE email = ?");
            $check_email->execute([$email]);
            
            if ($check_email->rowCount() > 0) {
                $error_message = "This email address is already registered.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO customers (first_name, last_name, email, phone, address, city, state, zip_code, registration_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                $stmt->execute([$first_name, $last_name, $email, $phone, $address, $city, $state, $zip_code]);
                
                $success_message = "Registration successful! Welcome to Kiplagat Fashion Store, " . $first_name . "!";
                
                $first_name = "";
                $last_name = "";
                $email = "";
                $phone = "";
                $address = "";
                $city = "";
                $state = "";
                $zip_code = "";
            }
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Unknown database') !== false) {
                $error_message = "Database not found. Please run the setup.php file first to create the database.";
            } else {
                $error_message = "Registration failed. Please try again later.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration - Kiplagat Fashion Store</title>
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
                <h2>Customer Registration</h2>
                
                <?php if ($success_message): ?>
                    <div class="message success"><?php echo $success_message; ?></div>
                <?php endif; ?>
                
                <?php if ($error_message): ?>
                    <div class="message error"><?php echo $error_message; ?></div>
                <?php endif; ?>
                
                <div class="form-container">
                    <h3>Join Our Fashion Community</h3>
                    <p>Register with us to receive exclusive offers, style tips, and be the first to know about new arrivals!</p>
                    
                    <form method="POST" action="register.php">
                        <div class="form-group">
                            <label for="first_name">First Name: *</label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name">Last Name: *</label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address: *</label>
                            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number: *</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Street Address:</label>
                            <input type="text" id="address" name="address" value="<?php echo $address; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="city">City:</label>
                            <input type="text" id="city" name="city" value="<?php echo $city; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="state">State:</label>
                            <input type="text" id="state" name="state" value="<?php echo $state; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="zip_code">ZIP Code:</label>
                            <input type="text" id="zip_code" name="zip_code" value="<?php echo $zip_code; ?>">
                        </div>
                        
                        <p style="font-size: 0.9em; color: #666; margin-bottom: 1rem;">
                            * Required fields
                        </p>
                        
                        <button type="submit" class="btn">Register Now</button>
                    </form>
                </div>
                
                <div class="form-container" style="margin-top: 2rem;">
                    <h3>Benefits of Registration</h3>
                    <ul style="text-align: left; margin: 1rem 0;">
                        <li>✓ Exclusive member discounts and special offers</li>
                        <li>✓ Early access to new collections and sales</li>
                        <li>✓ Personalized style recommendations</li>
                        <li>✓ Faster checkout process for future purchases</li>
                        <li>✓ Order history and tracking</li>
                        <li>✓ Birthday surprises and special promotions</li>
                    </ul>
                    
                    <p style="text-align: center; margin-top: 2rem;">
                        <a href="customers.php" class="btn">View All Customers</a>
                    </p>
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

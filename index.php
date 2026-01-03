<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MMU Cloud Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --coffee-primary: #6F4E37; --coffee-secondary: #FFF8E7; }
        body { background-color: var(--coffee-secondary); }
        .navbar { background-color: var(--coffee-primary); }
        .hero-section { background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1497935586351-b67a49e012bf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1351&q=80'); background-size: cover; color: white; padding: 100px 0; text-align: center; }
        .btn-coffee { background-color: var(--coffee-primary); color: white; border: none; }
        .btn-coffee:hover { background-color: #4a332a; color: white; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">☕ Cloud Coffee House</a>
            <div class="ms-auto">
                <a href="#menu" class="nav-link text-white d-inline mx-2">Menu</a>
                <a href="#order" class="nav-link text-white d-inline mx-2">Order Now</a>
                </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold">Welcome, Coffee Lover!</h1>
            <p class="lead">Order your favorite coffee instantly.</p>
            <a href="#order" class="btn btn-coffee btn-lg mt-3">Order Now</a>
        </div>
    </section>

    <section id="menu" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5" style="color: var(--coffee-primary);">Our Menu</h2>
            <div class="row g-4">
                <?php
                $sql = "SELECT * FROM products";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="<?php echo $row['image_url'] ? $row['image_url'] : 'https://via.placeholder.com/600x400'; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold"><?php echo $row['name']; ?></h5>
                            <p class="card-text text-muted"><?php echo $row['description']; ?></p>
                            <h4 class="text-success">$<?php echo $row['price']; ?></h4>
                        </div>
                    </div>
                </div>
                <?php 
                    }
                } else {
                    echo "<p class='text-center'>Menu is being updated...</p>";
                }
                ?>
            </div>
        </div>
    </section>

    <section id="order" class="py-5 bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header text-white text-center" style="background-color: var(--coffee-primary);">
                            <h3>☕ Place Your Order</h3>
                        </div>
                        <div class="card-body p-4">
                            <form action="process_order.php" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Your Name</label>
                                    <input type="text" name="customer_name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Select Coffee</label>
                                    <select name="coffee_name" class="form-select">
                                        <?php
                                        $result->data_seek(0); 
                                        while($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['name'] . "'>" . $row['name'] . " - $" . $row['price'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                                </div>
                                <button type="submit" class="btn btn-coffee w-100 btn-lg">Submit Order</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
<?php
include 'db_connect.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: admin.php");
}


if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    
    $image_path_for_db = 'https://via.placeholder.com/600x400?text=No+Image';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        
        $target_dir = "img/"; 
        

        $file_name = time() . "_" . basename($_FILES["image"]["name"]);
        
        $target_file_path = $target_dir . $file_name;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file_path)) {
            $image_path_for_db = $target_file_path; 
        }
    }
    
    $sql = "INSERT INTO products (name, description, price, image_url) VALUES ('$name', '$desc', '$price', '$image_path_for_db')";
    $conn->query($sql);
    header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>⚙️ Admin Dashboard</h1>
            <a href="index.php" class="btn btn-secondary">Back to User View</a>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">Add New Coffee Item</div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Latte" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Description</label>
                            <input type="text" name="description" class="form-control" placeholder="Rich & Creamy">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" name="price" class="form-control" placeholder="4.50" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Upload Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <button type="submit" name="add" class="btn btn-primary mt-3 w-100">Add to Menu</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">Manage Menu Items</div>
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM products");
                        while ($row = $result->fetch_assoc()):
                        ?>
                        <tr>
                            <td>
                                <img src="<?php echo $row['image_url']; ?>" alt="coffee" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                            </td>
                            <td><?php echo $row['name']; ?></td>
                            <td class="text-truncate" style="max-width: 200px;"><?php echo $row['description']; ?></td>
                            <td>$<?php echo $row['price']; ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="admin.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
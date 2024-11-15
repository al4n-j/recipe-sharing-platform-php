<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    $category = $_POST['category'];
    $user_id = $_SESSION['user_id'];
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imagePath = 'uploads/' . time() . '_' . $imageName;

        // Create uploads directory if it doesn't exist
        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true);
        }

        // Move the uploaded file to the uploads directory
        move_uploaded_file($imageTmpName, $imagePath);
    } else {
        $imagePath = null;
    }
    
    // Insert recipe data into the database
    $sql = "INSERT INTO recipes (user_id, title, description, ingredients, steps, category, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$user_id, $title, $description, $ingredients, $steps, $category, $imagePath])) {
        echo "Recipe submitted successfully!";
    } else {
        echo "Error submitting recipe.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Recipe</title>
    <link rel="stylesheet" href="styles/new_recipe.css">
</head>
<body>
    <div class="form-container">
        <h2>Submit a New Recipe</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            
            <label for="ingredients">Ingredients:</label>
            <textarea id="ingredients" name="ingredients" required></textarea>
            
            <label for="steps">Steps:</label>
            <textarea id="steps" name="steps" required></textarea>
            
            <label for="category">Category:</label>
            <input type="text" id="category" name="category">
            
            <label for="image">Recipe Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            
            <button type="submit">Submit Recipe</button>
        </form>
    </div>
</body>
</html>

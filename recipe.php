<?php 
include 'db.php';
session_start();

$recipe_id = $_GET['id'];
$sql = "SELECT * FROM recipes WHERE recipe_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$recipe_id]);
$recipe = $stmt->fetch();

$sql = "SELECT * FROM reviews WHERE recipe_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$recipe_id]);
$reviews = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['title']); ?></title>
    <link rel="stylesheet" href="styles/recipe.css"> <!-- Include your CSS file -->
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($recipe['title']); ?></h1>
        <?php if ($recipe['image']): ?>
            <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>" class="recipe-image">
        <?php endif; ?>
        <p><?php echo nl2br(htmlspecialchars($recipe['description'])); ?></p>
        <h2>Ingredients</h2>
        <p><?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>
        <h2>Steps</h2>
        <p><?php echo nl2br(htmlspecialchars($recipe['steps'])); ?></p>
        
        <h2>Reviews</h2>
        <?php foreach ($reviews as $review): ?>
            <div class="review">
                <p>Rating: <?php echo $review['rating']; ?> stars</p>
                <p><?php echo htmlspecialchars($review['comment']); ?></p>
            </div>
        <?php endforeach; ?>
        
        <h2>Leave a Review</h2>
        <form method="POST" action="submit_review.php">
            <input type="hidden" name="recipe_id" value="<?php echo $recipe['recipe_id']; ?>">
            <label for="rating">Rating (1-5):</label>
            <input type="number" id="rating" name="rating" min="1" max="5" required><br>
            
            <label for="comment">Comment:</label>
            <textarea id="comment" name="comment" required></textarea><br>
            
            <button type="submit">Submit Review</button>
        </form>
    </div>
</body>
</html>

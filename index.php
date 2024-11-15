<?php 
include 'db.php';
session_start();

$sql = "SELECT * FROM recipes ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$recipes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Sharing Platform</title>
    <link rel="stylesheet" href="styles/index.css">
</head>
<body>
    <div class="container">
        <h1>Recipe Sharing Platform</h1>
        <?php if (isset($_SESSION['username'])): ?>
    <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
    <div class="button-group">
        <a href="new_recipe.php" class="button">Submit a new recipe</a>
        <a href="login.php" class="button">Logout</a>
    </div>
<?php else: ?>
    <p><a href="login.php">Login</a> | <a href="register.php">Register</a></p>
<?php endif; ?>

        
        <h2>Latest Recipes</h2>
        <ul class="recipe-list">
            <?php foreach ($recipes as $recipe): ?>
                <li class="recipe-item">
                    <h3><?php echo htmlspecialchars($recipe['title']); ?></h3>
                    <?php if ($recipe['image']): ?>
                        <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="Recipe Image">
                    <?php endif; ?>
                    <p><?php echo htmlspecialchars($recipe['description']); ?></p>
                    <a href="recipe.php?id=<?php echo $recipe['recipe_id']; ?>">View Recipe</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>

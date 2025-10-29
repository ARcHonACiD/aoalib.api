<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch posts
$result = mysqli_query($conn, "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyBook - Connect and Share</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<header class="bg-white shadow-md p-4 flex justify-between">
    <h1 class="text-3xl text-[#1877f2] font-bold">mybook</h1>
    <div>
        <span class="mr-4 font-semibold text-gray-700">
            <?php echo htmlspecialchars($_SESSION['username']); ?>
        </span>
        <a href="logout.php" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600">Logout</a>
    </div>
</header>

<main class="max-w-3xl mx-auto p-6">
    <div class="bg-white p-5 rounded-xl shadow-lg mb-6">
        <h3 class="font-bold text-lg mb-3">Create Post</h3>
        <form action="post.php" method="POST">
            <textarea name="content" rows="3" placeholder="What's on your mind?" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#1877f2]"></textarea>
            <button type="submit" class="mt-3 bg-[#42b72a] text-white px-6 py-2 rounded-lg hover:bg-green-600">Post</button>
        </form>
    </div>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="bg-white p-5 rounded-xl shadow-lg mb-4">
            <div class="flex items-center mb-3">
                <div class="w-10 h-10 bg-[#1877f2] text-white rounded-full flex items-center justify-center font-bold text-lg">
                    <?php echo strtoupper(substr($row['username'], 0, 1)); ?>
                </div>
                <div class="ml-3">
                    <p class="font-bold text-gray-800"><?php echo htmlspecialchars($row['username']); ?></p>
                    <p class="text-xs text-gray-500"><?php echo $row['created_at']; ?></p>
                </div>
            </div>
            <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
        </div>
    <?php } ?>
</main>

</body>
</html>

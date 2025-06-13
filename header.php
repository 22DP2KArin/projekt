
<?php session_start(); ?>
<header class="bg-white shadow p-4 flex justify-between items-center">
    <a href="shop.php" class="text-xl font-bold">Veikals</a>
    <div class="flex gap-4 items-center">
        <?php if (isset($_SESSION['username'])): ?>
            <span class="text-gray-700">Sveiki, <?= htmlspecialchars($_SESSION['username']) ?>!</span>
            <a href="logout.php" class="text-red-500 hover:underline">iziet</a>
        <?php else: ?>
            <a href="login.php" class="text-blue-500 hover:underline">ieiet</a>
            <a href="register.php" class="text-blue-500 hover:underline">Reģistrācija</a>
        <?php endif; ?>
    </div>
</header>

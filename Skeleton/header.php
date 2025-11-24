<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
?>
<style>
  body {
    margin-top: 60px; 
    font-family: Arial, sans-serif;
  }

  .topbar {
    background-color: #391B25;
    color: white;
    position: fixed;
    top: 0; left: 0;
    width: 100%;
    padding: 12px 30px;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    z-index: 9999;
  }

  .topbar h2 {
    margin: 0;
    font-weight: normal;
    font-size: 18px;
  }

  .topbar a {
    text-decoration: none;
  }

  .logout-btn {
    background-color: #b32121;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .logout-btn:hover {
    background-color: #7a1616;
  }
</style>

<div class="topbar">
  <h2>
    Logged in as: <?php echo htmlspecialchars($_SESSION['username']); ?> (<?php echo htmlspecialchars($_SESSION['role']); ?>)
  </h2>

  <a href="login.php" onclick="return confirm('Are you sure you want to logout?');">
    <button class="logout-btn">Logout</button>
  </a>
</div>

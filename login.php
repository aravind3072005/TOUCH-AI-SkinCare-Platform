<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$errorMessage = '';
if (!empty($_GET['error'])) {
    $errorMessage = htmlspecialchars($_GET['error']);
}
if (!empty($_GET['registered'])) {
    $errorMessage = 'Signup successful! Please log in.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TOUCH - Login</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* Background */
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: url('https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=876&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 876w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=1176&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 1176w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=1476&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 1476w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=1752&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 1752w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=1776&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 1776w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=2076&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 2076w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=2352&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 2352w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=2376&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 2376w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=2676&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 2676w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=2952&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 2952w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=2976&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 2976w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=3276&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 3276w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=3552&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 3552w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=3576&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 3576w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=3876&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 3876w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=4152&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 4152w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=4176&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 4176w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=4476&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 4476w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=4752&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 4752w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=4776&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 4776w, https://images.unsplash.com/photo-1718829510336-87e0e96c4021?q=80&w=4928&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D 4928w') no-repeat center center/cover;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Glass Card */
    .login-card {
        display: flex;
        flex-direction: row;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(15px);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.3);
        max-width: 900px;
        width: 90%;
        animation: fadeIn 1s ease-in-out;
    }

    /* Left: Form */
    .form-section {
        flex: 1;
        padding: 40px;
        color: white;
    }
    .form-section h1 {
        font-size: 28px;
        margin-bottom: 10px;
        color: #fff;
    }
    .form-section p {
        margin-bottom: 20px;
        opacity: 0.8;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
    }
    .form-group input {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 8px;
        outline: none;
    }
    .btn-primary {
        width: 100%;
        padding: 12px;
        background: #e85d75;
        border: none;
        color: white;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-primary:hover {
        background: #d94f68;
    }
    .error-message {
        background: rgba(255, 0, 0, 0.2);
        padding: 8px;
        border-radius: 6px;
        margin-bottom: 10px;
        color: #ffb3b3;
    }

    /* Right: About */
    .about-section {
        flex: 1;
        padding: 40px;
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }
    .about-section h2 {
        font-size: 26px;
        margin-bottom: 15px;
        color: #fff;
    }
    .about-section p {
        line-height: 1.6;
        opacity: 0.9;
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Mobile */
    @media(max-width: 768px) {
        .login-card {
            flex-direction: column;
        }
    }
</style>
</head>
<body>

<div class="login-card">

    <!-- Left: Login Form -->
    <div class="form-section">
        <h1><i class="fas fa-leaf"></i> TOUCH Skincare</h1>
        <p>Welcome back! Please login to your account.</p>
        <?php if (!empty($errorMessage)): ?>
            <div class="error-message"><?= $errorMessage; ?></div>
        <?php endif; ?>
        <form action="login_process.php" method="POST">
            <div class="form-group">
                <label><i class="fas fa-envelope"></i> Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn-primary">Login</button>
        </form>
        <p style="margin-top:15px;">Don't have an account? <a href="signup.php" style="color:#ffb3c1;">Sign Up</a></p>
    </div>

    <!-- Right: About -->
    <div class="about-section">
        <h2>About TOUCH</h2>
        <p>
            At TOUCH, we believe skincare is an art of self-love.  
            Our products combine nature’s purity with science’s precision  
            to bring out your natural glow. Experience care, confidence,  
            and radiance in every touch — because your skin deserves the best.
        </p>
    </div>
</div>

</body>
</html>

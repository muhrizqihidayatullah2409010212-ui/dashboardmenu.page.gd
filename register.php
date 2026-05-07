<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register | Website Cafe Rizqi</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', system-ui, sans-serif;
}

body {
    min-height: 100vh;
    background: radial-gradient(circle at top, #1b1f3b, #0a0c1b);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    color: #fff;
    overflow: hidden;
}

/* Glow background */
.bg {
    position: absolute;
    width: 480px;
    height: 480px;
    background: linear-gradient(45deg, #7a5cff, #00eaff);
    filter: blur(160px);
    opacity: 0.6;
    animation: float 12s ease-in-out infinite alternate;
    pointer-events: none;
}

@keyframes float {
    from { transform: translate(-60px, -60px); }
    to   { transform: translate(60px, 60px); }
}

/* Card */
.card {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 420px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    backdrop-filter: blur(20px);
    border-radius: 22px;
    padding: 40px;
    text-align: center;
    animation: fadeUp 1s ease;
}

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

h2 {
    font-size: 26px;
    margin-bottom: 8px;
}

p {
    font-size: 14px;
    opacity: 0.75;
    margin-bottom: 26px;
}

input {
    width: 100%;
    padding: 14px 16px;
    margin-bottom: 14px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.15);
    background: rgba(255,255,255,0.08);
    color: #fff;
    outline: none;
}

input::placeholder {
    color: rgba(255,255,255,0.6);
}

input:focus {
    border-color: #00eaff;
}

/* Button */
button {
    width: 100%;
    margin-top: 6px;
    padding: 14px;
    border-radius: 30px;
    border: none;
    background: linear-gradient(90deg, #7a5cff, #00eaff);
    color: #000;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
}

button:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0,234,255,0.45);
}

/* Links */
.links {
    margin-top: 18px;
    font-size: 14px;
}

.links a {
    display: block;
    margin-top: 6px;
    color: #00eaff;
    text-decoration: none;
    opacity: 0.85;
}

.links a:hover {
    opacity: 1;
}
</style>
</head>

<body>

<div class="bg"></div>

<div class="card">
    <h2>Register Akun</h2>
    <p>Buat akun baru untuk mengakses menu cafe</p>

    <form method="post" action="proses_register.php">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Daftar</button>
    </form>

    <div class="links">
        <a href="login.php">Sudah punya akun? Login</a>
    </div>
</div>

</body>
</html>

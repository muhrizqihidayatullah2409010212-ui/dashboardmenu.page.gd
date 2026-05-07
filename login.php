<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | Website Rizqi</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter',sans-serif;
}

/* CHAT AI */
.chat-toggle{
    position:fixed;
    bottom:20px;
    right:20px;
    background:#00eaff;
    color:#000;
    padding:10px 16px;
    border-radius:30px;
    cursor:pointer;
    font-weight:600;
    z-index:9999;
    box-shadow:0 5px 15px rgba(0,0,0,0.4);
}

.card{
    position:relative;
    z-index:1;
}
.chat-container{
    transform:translateY(30px) scale(0.95);
    opacity:0;
    transition:0.3s ease;
}

.chat-container.active{
    transform:translateY(0) scale(1);
    opacity:1;
}

.chat-container{
    position:fixed;
    bottom:100px;
    right:25px;
    width:300px; 
    height:380px; 
    
    background:rgba(20,20,20,0.75); 
    backdrop-filter:blur(20px);
    
    border-radius:20px;
    display:none;
    flex-direction:column;
    overflow:hidden;
    
    border:1px solid rgba(255,255,255,.2);
    box-shadow:0 15px 40px rgba(0,0,0,0.6); 
    
    z-index:99999; 
}


.chat-header{
    background:#00eaff;
    color:#000;
    padding:12px;
    font-weight:600;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.chat-body{
    flex:1;
    padding:12px;
    overflow-y:auto;
    font-size:13px;
    display:flex;
    flex-direction:column;
    gap:6px;
}

.chat-msg{
    margin:6px 0;
    padding:8px 10px;
    border-radius:12px;
    max-width:80%;
}

.user{
    background:#00eaff;
    color:#000;
    margin-left:auto;
}

.bot{
    background:rgba(255,255,255,0.15);
}

.chat-input{
    display:flex;
    border-top:1px solid rgba(255,255,255,.2);
    padding:5px;
}

.chat-input input{
    flex:1;
    padding:10px;
    border:none;
    outline:none;
    background:transparent;
    color:#fff;
}

.chat-input button{
    background:#00eaff;
    border:none;
    padding:10px 14px;
    cursor:pointer;
    border-radius:10px;
}
body{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    background:url("images/pagesbg.jpg") no-repeat center/cover;
    position:relative;
}

/* overlay */
body::before{
    content:"";
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.35);
    z-index:0;
}


/* CARD */
.card{
    position:relative;
    z-index:1;
    width:100%;
    max-width:400px;
    padding:35px;

    background:rgba(255,255,255,0.06);
    backdrop-filter:blur(18px);
    -webkit-backdrop-filter:blur(18px);

    border-radius:22px;

    border:1px solid rgba(255,255,255,0.2);
    box-shadow:
        0 10px 30px rgba(0,0,0,0.35),
        inset 0 1px 1px rgba(255,255,255,0.15);

    text-align:center;

    transition: all .3s ease;
    transform-style: preserve-3d;
}

/* HOVER EFFECT */
.card:hover{
    background:rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.35);

    box-shadow:
        0 20px 50px rgba(0,0,0,0.5),
        inset 0 1px 2px rgba(255,255,255,0.25);

    transform: translateY(-5px) scale(1.02);
}
/* BORDER BERJALAN (PINGGIR SAJA) */
.card::before{
    content:"";
    position:absolute;
    inset:0;
    border-radius:22px;
    padding:2px;

    background:linear-gradient(270deg,#00eaff,#7a5cff,#00eaff);
    background-size:300% 300%;
    animation:borderMove 6s linear infinite;

    /* Webkit */
    -webkit-mask:
        linear-gradient(#fff 0 0) content-box,
        linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;

    /* Standard */
    mask:
        linear-gradient(#fff 0 0) content-box,
        linear-gradient(#fff 0 0);
    mask-composite: exclude;

    pointer-events:none;
}

/* SHINE iOS */
.card::after{
    content:"";
    position:absolute;
    inset:0;
    border-radius:22px;

    background:linear-gradient(
        120deg,
        rgba(255,255,255,0.35),
        rgba(255,255,255,0.05) 40%,
        transparent 60%
    );

    pointer-events:none;
}

@keyframes borderMove{
    0%{background-position:0% 50%;}
    100%{background-position:100% 50%;}
}

/* TEXT */
h2{
    margin-bottom:8px;
    font-weight:600;
}

p{
    font-size:14px;
    opacity:0.85;
    margin-bottom:25px;
}

/* INPUT GLASS */
.input-group{
    margin-bottom:15px;
}

.input-group input{
    width:100%;
    padding:14px;
    border-radius:10px;

    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(10px);
    -webkit-backdrop-filter:blur(10px);

    border:1px solid rgba(255,255,255,0.25);
    color:#fff;
    outline:none;
}

.input-group input::placeholder{
    color:rgba(255,255,255,0.7);
}

/* BUTTON */
button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:25px;
    background:#00eaff;
    color:#000;
    font-weight:600;
    cursor:pointer;
}

button:hover{
    opacity:0.9;
}

/* LINKS */
.links{
    margin-top:15px;
    font-size:13px;
}

.links a{
    display:block;
    margin-top:6px;
    color:#7adfff;
    text-decoration:none;
}

.links a:hover{
    text-decoration:underline;
}

/* TABLET */
@media (max-width:768px){
    .left{
        display:none;
    }

    .right{
        width:100%;
        background:url('bg-makanan.jpg') no-repeat center/cover;
        position:relative;
    }

    .right::before{
        content:"";
        position:absolute;
        inset:0;
        background:rgba(0,0,0,0.5);
    }

    .card{
        position:relative;
        z-index:1;
    }
}

/* HP */
@media (max-width:480px){
    .card{
        padding:25px;
    }
}

</style>
</head>

<body>

<div class="card">
    <h2>Selamat Datang</h2>
    <p>Login ke dashboard menu makanan cafe rizqi</p>

    <form method="post" action="proses_login.php">

        <div class="input-group">
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <div class="links">
        <a href="lupa_password.php">Lupa Password?</a>
        <a href="register.php">Belum punya akun? Daftar</a>
    </div>
    
   <!-- CHAT AI -->
<div class="chat-container" id="chatAI">
    <div class="chat-header">
        🤖 Rizqi CAFE
        <span onclick="closeAI()">✖</span>
    </div>

    <div class="chat-body" id="chatBodyAI">
        <div class="chat-msg bot">Halo 👋 aku asisten cafe, bisa bantu pilih menu atau jawab pertanyaan kamu</div>
    </div>

    <div class="chat-input">
        <input type="text" id="chatInputAI" placeholder="Tanya apa aja...">
        <button onclick="sendAI()">Kirim</button>
    </div>
</div>

<div class="chat-toggle" onclick="openAI()">💬 HELP</div>
            
</div>
<script>
function openAI(){
    let chat = document.getElementById("chatAI");
    chat.style.display = "flex";
    setTimeout(()=> chat.classList.add("active"),10);
}

function closeAI(){
    let chat = document.getElementById("chatAI");
    chat.classList.remove("active");
    setTimeout(()=> chat.style.display="none",300);
}

function sendAI(){
    let input = document.getElementById("chatInputAI");
    let msg = input.value.trim();
    let lower = msg.toLowerCase();
    if(msg === "") return;

    let body = document.getElementById("chatBodyAI");

    // anti HTML injection
    function escapeHTML(str){
        return str.replace(/[&<>"']/g, function(m){
            return {
                "&":"&amp;",
                "<":"&lt;",
                ">":"&gt;",
                "\"":"&quot;",
                "'":"&#039;"
            }[m];
        });
    }

    // tampilkan pesan user
    body.insertAdjacentHTML("beforeend",
        `<div class="chat-msg user">${escapeHTML(msg)}</div>`
    );

    input.value="";
    body.scrollTop = body.scrollHeight;

    let reply = "Maaf, aku belum paham 😅";

    function random(arr){
        return arr[Math.floor(Math.random()*arr.length)];
    }

    // ===== LOGIN HELPER =====
    if(lower.includes("login")){
        reply = "Masukkan email dan password kamu lalu klik tombol login 👍";
    }
    else if(lower.includes("password")){
        reply = "Kalau lupa password, klik 'Lupa Password' dan klik token dan buat sandi ubah🔐";
    }
    else if(lower.includes("email")){
        reply = "Gunakan email yang sudah kamu daftarkan sebelumnya 📧";
    }
    else if(lower.includes("daftar") || lower.includes("register")){
        reply = "Klik 'Belum punya akun? Daftar' untuk membuat akun baru 📝";
    }
    else if(lower.includes("gagal") || lower.includes("error")){
        reply = random([
            "Coba cek email atau password kamu lagi ya ❗",
            "Pastikan data login benar 👍",
            "Mungkin akun belum terdaftar 😅"
        ]);
    }
    else if(lower.includes("halo") || lower.includes("hai")){
        reply = random([
            "Halo 👋 butuh bantuan login?",
            "Hai! Aku bantu kamu masuk ke akun ya 😄",
            "Halo, silakan login dulu ya 👍"
        ]);
    }
    else if(lower.includes("terima kasih")){
        reply = "Sama-sama 🙌 semoga berhasil login!";
    }

    // ===== TAMBAHAN BIAR LEBIH HIDUP =====
    else if(lower.includes("menu")){
        reply = random([
            "Menu favorit: kopi aren, matcha, sama mojito 😋",
            "Kamu bisa cek menu minuman setelah login ya 👍",
            "Banyak menu enak di dashboard nanti 😄"
        ]);
    }
    else if(lower.includes("cafe") || lower.includes("rizqi")){
        reply = "Cafe Rizqi siap melayani kamu ☕✨";
    }
    else if(lower.includes("bantu")){
        reply = "Aku bisa bantu login, daftar, atau info menu 👍";
    }

    else{
        reply = "Aku bisa bantu soal login, daftar akun, atau lupa password 👍";
    }

    // efek typing
    body.insertAdjacentHTML("beforeend",
        `<div class="chat-msg bot" id="typing">...</div>`
    );
    body.scrollTop = body.scrollHeight;

    setTimeout(()=>{
        let typing = document.getElementById("typing");
        if(typing){
            typing.outerHTML = `<div class="chat-msg bot">${reply}</div>`;
        }
        body.scrollTop = body.scrollHeight;
    },600);
}

// ENTER KEY SUPPORT (AMAN)
document.addEventListener("DOMContentLoaded", function(){
    document.getElementById("chatInputAI").addEventListener("keypress", function(e){
        if(e.key === "Enter"){
            e.preventDefault();
            sendAI();
        }
    });
});
</script>
                             
</body>
</html>

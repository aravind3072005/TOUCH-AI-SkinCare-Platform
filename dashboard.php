<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TOUCH Cosmetics - AI Skincare Expert</title>
    <style>
        /* Reset & Base */
        *{box-sizing:border-box;margin:0;padding:0}
        html,body{height:100%}
        body{font-family:'Inter',system-ui,-apple-system,sans-serif;line-height:1.6;color:#1a1a1a;background:#fefefe;overflow-x:hidden}
        .container{max-width:1400px;margin:0 auto;padding:0 20px}
        a{color:inherit;text-decoration:none}

        /* Animated Background */
        .bg-animation{position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:0;opacity:0.4}
        .floating-orb{position:absolute;border-radius:50%;filter:blur(80px);animation:float-orbs 20s infinite linear}
        .orb-1{width:200px;height:200px;background:linear-gradient(45deg,#ff6b9d,#c44569);top:20%;left:10%;animation-delay:0s}
        .orb-2{width:300px;height:300px;background:linear-gradient(45deg,#4ecdc4,#2ed573);top:60%;right:10%;animation-delay:-7s}
        .orb-3{width:150px;height:150px;background:linear-gradient(45deg,#ffa726,#ff7043);bottom:30%;left:20%;animation-delay:-14s}
        @keyframes float-orbs{0%{transform:translateY(0px) rotate(0deg)}50%{transform:translateY(-30px) rotate(180deg)}100%{transform:translateY(0px) rotate(360deg)}}

        /* Header */
        header{position:fixed;top:0;left:0;right:0;padding:15px 0;z-index:1000;background:rgba(255,255,255,0.1);backdrop-filter:blur(25px);border-bottom:1px solid rgba(255,255,255,0.18);transition:all .4s ease}
        header.scrolled{background:rgba(255,255,255,0.95);backdrop-filter:blur(40px);box-shadow:0 8px 32px rgba(0,0,0,0.1)}
        nav{display:flex;justify-content:space-between;align-items:center;position:relative;z-index:10}
        .logo{font-size:32px;font-weight:900;background:linear-gradient(135deg,#667eea,#764ba2,#f093fb);-webkit-background-clip:text;background-clip:text;color:transparent;font-style:italic}
        
        .nav-links{display:flex;gap:35px;list-style:none}
        .nav-links a{position:relative;font-weight:600;padding:8px 0;transition:all .3s ease}
        .nav-links a:hover{color:#667eea;transform:translateY(-1px)}

        .nav-icons{display:flex;gap:20px;align-items:center}
        .icon-btn{position:relative;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);border-radius:12px;padding:10px;cursor:pointer;transition:all .3s ease;backdrop-filter:blur(10px)}
        .icon-btn:hover{background:rgba(255,255,255,0.2);transform:translateY(-2px);box-shadow:0 8px 25px rgba(0,0,0,0.1)}

        /* Hero Section */
        .hero{
            min-height:100vh;
            padding-top:80px;
            display:flex;
            align-items:center;
            position:relative;
            background:linear-gradient(135deg,rgba(102,126,234,0.1),rgba(118,75,162,0.1),rgba(240,147,251,0.1)),
                       linear-gradient(45deg,rgba(159, 166, 150, 0.85),rgba(177, 219, 179, 0.6)),
                       url('https://images.unsplash.com/photo-1596462502278-27bfdc403348?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');
            background-size:cover;
            background-position:center;
            overflow:hidden;
        }
        
        .hero-content{display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;position:relative;z-index:2}
        .hero h1{font-size:4.5rem;font-weight:900;line-height:1.1;background:linear-gradient(135deg,#1a1a1a,#667eea,#f093fb);-webkit-background-clip:text;color:transparent;margin-bottom:20px}
        .hero p{font-size:1.3rem;color:#4a4a4a;max-width:500px;margin-bottom:40px}

        .cta{display:flex;gap:16px;flex-wrap:wrap}
        .primary{background:linear-gradient(135deg,#667eea,#764ba2);padding:18px 35px;border-radius:50px;border:none;color:#fff;font-weight:700;font-size:16px;cursor:pointer;transition:all .3s ease}
        .primary:hover{transform:translateY(-3px);box-shadow:0 15px 35px rgba(102,126,234,0.4)}
        .ghost{background:rgba(255,255,255,0.1);border:2px solid rgba(102,126,234,0.3);padding:16px 35px;border-radius:50px;color:#667eea;font-weight:700;font-size:16px;cursor:pointer;backdrop-filter:blur(10px);transition:all .3s ease}
        .ghost:hover{background:rgba(102,126,234,0.1);transform:translateY(-3px)}

        .hero-image{position:relative}
        .hero-image img{width:100%;border-radius:30px;box-shadow:0 30px 60px rgba(0,0,0,0.2);transition:all .4s ease}

        /* AI Chatbot Styles */
        .chatbot-section{padding:120px 0;background:linear-gradient(135deg,rgba(102,126,234,0.03),rgba(240,147,251,0.03))}
        .chatbot-container{max-width:1000px;margin:0 auto;background:rgba(255,255,255,0.95);backdrop-filter:blur(20px);border-radius:30px;box-shadow:0 25px 60px rgba(0,0,0,0.1);overflow:hidden;border:1px solid rgba(255,255,255,0.3)}

        .chatbot-header{background:linear-gradient(135deg,#667eea,#764ba2);padding:25px 30px;color:#fff;display:flex;align-items:center;gap:15px}
        .chatbot-avatar{width:50px;height:50px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px}
        .chatbot-info h3{font-size:1.4rem;margin-bottom:5px}
        .chatbot-info p{opacity:0.9;font-size:0.95rem}
        .status-indicator{width:12px;height:12px;background:#4ecdc4;border-radius:50%;margin-left:auto;animation:pulse 2s infinite}
        @keyframes pulse{0%,100%{opacity:1}50%{opacity:0.5}}

        .chat-messages{height:500px;overflow-y:auto;padding:30px;display:flex;flex-direction:column;gap:20px;scroll-behavior:smooth}
        .message{display:flex;gap:15px;max-width:80%;animation:messageSlide 0.5s ease-out}
        @keyframes messageSlide{0%{opacity:0;transform:translateY(20px)}100%{opacity:1;transform:translateY(0)}}
        
        .message.user{align-self:flex-end;flex-direction:row-reverse}
        .message.bot{align-self:flex-start}
        
        .message-avatar{width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
        .message.user .message-avatar{background:linear-gradient(135deg,#667eea,#764ba2);color:#fff}
        .message.bot .message-avatar{background:linear-gradient(135deg,#4ecdc4,#44a08d);color:#fff}
        
        .message-content{background:#f8f9fa;padding:15px 20px;border-radius:20px;position:relative;box-shadow:0 2px 10px rgba(0,0,0,0.05)}
        .message.user .message-content{background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;border-radius:20px 5px 20px 20px}
        .message.bot .message-content{background:#fff;border:1px solid rgba(0,0,0,0.05);border-radius:5px 20px 20px 20px}

        .typing-indicator{display:none;align-items:center;gap:10px;padding:15px 20px;background:#fff;border-radius:5px 20px 20px 20px;border:1px solid rgba(0,0,0,0.05)}
        .typing-dots{display:flex;gap:4px}
        .typing-dot{width:8px;height:8px;background:#667eea;border-radius:50%;animation:typing 1.4s infinite ease-in-out}
        .typing-dot:nth-child(1){animation-delay:0s}
        .typing-dot:nth-child(2){animation-delay:0.2s}
        .typing-dot:nth-child(3){animation-delay:0.4s}
        @keyframes typing{0%,80%,100%{transform:scale(0);opacity:0.5}40%{transform:scale(1);opacity:1}}

        .chat-input-container{padding:25px 30px;background:rgba(248,249,250,0.8);border-top:1px solid rgba(0,0,0,0.05)}
        .chat-input-wrapper{display:flex;gap:15px;align-items:flex-end;position:relative}
        .chat-input{flex:1;padding:15px 20px;border:2px solid rgba(102,126,234,0.2);border-radius:25px;background:#fff;font-size:16px;resize:none;max-height:120px;min-height:50px;transition:all .3s ease}
        .chat-input:focus{outline:none;border-color:#667eea;box-shadow:0 0 20px rgba(102,126,234,0.1)}
        .chat-send-btn{background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;border:none;border-radius:50%;width:50px;height:50px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .3s ease;font-size:20px}
        .chat-send-btn:hover{transform:scale(1.1);box-shadow:0 10px 30px rgba(102,126,234,0.4)}
        .chat-send-btn:disabled{opacity:0.5;cursor:not-allowed;transform:none}

        .quick-questions{margin-bottom:20px}
        .quick-questions h4{color:#667eea;margin-bottom:15px;font-size:1.1rem}
        .question-chips{display:flex;flex-wrap:wrap;gap:10px}
        .question-chip{background:rgba(102,126,234,0.1);color:#667eea;padding:8px 16px;border-radius:20px;cursor:pointer;font-size:14px;border:1px solid rgba(102,126,234,0.2);transition:all .3s ease}
        .question-chip:hover{background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;transform:translateY(-2px)}

        .product-recommendation{background:linear-gradient(135deg,rgba(102,126,234,0.05),rgba(240,147,251,0.05));border-radius:15px;padding:20px;margin:15px 0;border:1px solid rgba(102,126,234,0.1)}
        .product-rec-header{display:flex;align-items:center;gap:10px;margin-bottom:15px}
        .product-rec-icon{width:30px;height:30px;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px}
        .product-grid-chat{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:15px;margin-top:15px}
        .product-card-mini{background:#fff;border-radius:12px;padding:15px;box-shadow:0 5px 15px rgba(0,0,0,0.08);transition:all .3s ease;border:1px solid rgba(0,0,0,0.05)}
        .product-card-mini:hover{transform:translateY(-5px);box-shadow:0 10px 25px rgba(0,0,0,0.12)}
        .product-card-mini img{width:100%;height:80px;object-fit:cover;border-radius:8px;margin-bottom:10px}
        .product-card-mini h5{font-size:14px;margin-bottom:5px;color:#1a1a1a}
        .product-card-mini .price{color:#667eea;font-weight:700;font-size:16px}

        /* Products Section */
        section{padding:120px 0;position:relative;z-index:5}
        .section-title{text-align:center;font-size:3.5rem;color:#1a1a1a;font-weight:900;margin-bottom:70px}
        .product-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(350px,1fr));gap:40px}
        .product-card{background:rgba(255,255,255,0.9);border-radius:25px;padding:25px;text-align:center;color:#1a1a1a;box-shadow:0 15px 35px rgba(0,0,0,0.08);transition:all .5s ease;backdrop-filter:blur(20px)}
        .product-card:hover{transform:translateY(-15px) scale(1.02);box-shadow:0 25px 60px rgba(0,0,0,0.15)}
        .product-image{position:relative;margin-bottom:20px;border-radius:20px;overflow:hidden}
        .product-card img{width:100%;height:280px;object-fit:cover;transition:all .5s ease}
        .product-card:hover img{transform:scale(1.1)}
        .product-info h4{font-size:1.4rem;margin:15px 0 10px;font-weight:700}
        .product-desc{color:#666;margin-bottom:10px;font-size:14px}
        .price{color:transparent;background:linear-gradient(135deg,#667eea,#f093fb);-webkit-background-clip:text;background-clip:text;font-weight:900;font-size:1.6rem;margin-bottom:20px}
        .actions{display:flex;gap:15px;align-items:center;justify-content:center;flex-wrap:wrap}
        .add-cart{padding:12px 25px;border-radius:15px;border:2px solid rgba(102,126,234,0.3);background:rgba(255,255,255,0.1);color:#667eea;font-weight:700;cursor:pointer;transition:all .3s ease}
        .add-cart:hover{background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;border-color:transparent;transform:translateY(-2px)}

        /* Toast */
        .toast{position:fixed;top:100px;right:30px;background:linear-gradient(135deg,#2ed573,#4ecdc4);color:#fff;padding:15px 25px;border-radius:15px;z-index:9999;transform:translateX(400px);transition:all .4s ease;max-width:300px}
        .toast.show{transform:translateX(0)}
        .toast.error{background:linear-gradient(135deg,#ff6b9d,#c44569)}
        .toast.info{background:linear-gradient(135deg,#667eea,#764ba2)}

        /* Floating Chatbot Button */
        .floating-chat{position:fixed;bottom:30px;right:30px;z-index:1000;background:linear-gradient(135deg,#667eea,#f093fb);color:#fff;border:none;border-radius:50%;width:70px;height:70px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:24px;box-shadow:0 10px 30px rgba(102,126,234,0.4);transition:all .3s ease}
        .floating-chat:hover{transform:scale(1.1);box-shadow:0 15px 40px rgba(102,126,234,0.6)}

        /* Responsive */
        @media (max-width:768px){
            .hero-content{grid-template-columns:1fr;gap:40px;text-align:center}
            .hero h1{font-size:3rem}
            .nav-links{display:none}
            .product-grid{grid-template-columns:1fr;gap:25px}
            .chatbot-container{margin:0 10px;border-radius:20px}
            .chat-messages{height:400px;padding:20px}
            .message{max-width:90%}
            .question-chips{justify-content:center}
        }

        .loading{position:fixed;inset:0;background:rgba(255,255,255,0.95);display:flex;align-items:center;justify-content:center;z-index:9999}
        .spinner{width:60px;height:60px;border:4px solid rgba(102,126,234,0.1);border-left:4px solid #667eea;border-radius:50%;animation:spin 1s linear infinite}
        @keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}
    </style>
</head>
<body>
    <!-- Loading Screen -->
    <div class="loading" id="loadingScreen">
        <div class="spinner"></div>
    </div>

    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
    </div>

    <!-- Header -->
    <header id="siteHeader">
        <div class="container">
            <nav>
                <div class="logo">TOUCH</div>
                <ul class="nav-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#ai-expert">AI Chat</a></li>
                    <li><a href="#analyzer">Photo Analysis</a></li>
                    <li><a href="#products">Products</a></li>
                    <li><a href="#reviews">Reviews</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                <div class="nav-icons">
                    <button class="icon-btn" title="AI Skincare Expert" onclick="scrollToChat()">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" stroke="#667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <button class="icon-btn" title="Shopping Cart">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="9" cy="21" r="1" stroke="#667eea" stroke-width="2"/>
                            <circle cx="20" cy="21" r="1" stroke="#667eea" stroke-width="2"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" stroke="#667eea" stroke-width="2"/>
                        </svg>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <main>
        <section id="home" class="hero">
            <div class="container hero-content">
                <div class="hero-text">
                    <h1>AI-Powered Skincare Expert</h1>
                    <p>Get instant, personalized skincare advice from our AI expert. Ask any question about your skin concerns, product recommendations, routines, and ingredients.</p>
                    <div class="cta">
                        <button class="primary" onclick="scrollToChat()">Chat with AI Expert</button>
                        <button class="ghost" onclick="scrollToProducts()">Browse Products</button>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Skincare Expert" />
                </div>
            </div>
        </section>

        <!-- Reviews Section -->
        <section id="reviews" style="background:linear-gradient(135deg,rgba(102,126,234,0.05),rgba(240,147,251,0.05));padding:120px 0">
            <div class="container">
                <h2 class="section-title">What Our Customers Say</h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:30px">
                    <div style="background:rgba(255,255,255,0.8);padding:30px;border-radius:20px;box-shadow:0 15px 35px rgba(0,0,0,0.08);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.3);transition:all .4s ease" onmouseover="this.style.transform='translateY(-8px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="color:#ffd700;font-size:20px;margin-bottom:15px">★★★★★</div>
                        <p style="font-style:italic;color:#4a4a4a;line-height:1.8;margin-bottom:20px">"The AI skincare expert is incredible! It gave me personalized advice that actually worked. My acne cleared up in just 2 weeks!"</p>
                        <div style="display:flex;align-items:center;gap:15px">
                            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Priya" style="width:50px;height:50px;border-radius:50%;border:3px solid rgba(102,126,234,0.2)">
                            <div>
                                <h5 style="font-weight:600;color:#1a1a1a">Priya Sharma</h5>
                                <span style="color:#888;font-size:14px">Mumbai</span>
                            </div>
                        </div>
                    </div>
                    <div style="background:rgba(255,255,255,0.8);padding:30px;border-radius:20px;box-shadow:0 15px 35px rgba(0,0,0,0.08);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.3);transition:all .4s ease" onmouseover="this.style.transform='translateY(-8px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="color:#ffd700;font-size:20px;margin-bottom:15px">★★★★★</div>
                        <p style="font-style:italic;color:#4a4a4a;line-height:1.8;margin-bottom:20px">"I love how the AI chatbot explains ingredients and routines. It's like having a dermatologist available 24/7!"</p>
                        <div style="display:flex;align-items:center;gap:15px">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Neha" style="width:50px;height:50px;border-radius:50%;border:3px solid rgba(102,126,234,0.2)">
                            <div>
                                <h5 style="font-weight:600;color:#1a1a1a">Neha Singh</h5>
                                <span style="color:#888;font-size:14px">Delhi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter -->
        <section style="background:linear-gradient(135deg,rgba(26,26,26,0.95),rgba(102,126,234,0.1));padding:80px 20px;border-radius:25px;text-align:center;backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.1)">
            <div class="container">
                <h2 style="color:#fff;font-size:3rem;margin-bottom:20px">Get Beauty Insider Access</h2>
                <p style="color:rgba(255,255,255,0.9);max-width:600px;margin:0 auto 30px;font-size:1.1rem">Join our beauty community for exclusive launches, personalized tips, and member-only offers.</p>
                <div style="display:flex;justify-content:center;gap:15px;flex-wrap:wrap;margin-top:30px">
                    <input id="emailInput" type="email" placeholder="Enter your email address" style="padding:16px 24px;border-radius:25px;border:2px solid rgba(255,255,255,0.2);width:350px;max-width:90%;background:rgba(255,255,255,0.1);color:#fff;backdrop-filter:blur(10px)" />
                    <button id="subscribeBtn" onclick="subscribeNewsletter()" style="padding:16px 30px;border-radius:25px;border:none;background:linear-gradient(135deg,#667eea,#f093fb);color:#fff;font-weight:600;cursor:pointer">Join Now</button>
                </div>
            </div>
        </section>

        <footer style="padding:60px 0;text-align:center;background:#1a1a1a;color:#fff">
            <div class="container">
                <div class="logo" style="margin-bottom:20px;font-size:36px">TOUCH</div>
                <p style="color:#888;margin-bottom:20px">AI-Powered Beauty Solutions</p>
                <p style="color:#666">&copy; 2025 TOUCH Cosmetics. Powered by AI for personalized beauty care.</p>
            </div>
        </footer>
    </main>

    <!-- Floating Chat Button -->
    <button class="floating-chat" onclick="scrollToChat()" title="Chat with AI Expert">
        💬
    </button>

    <script>
        // Global Variables
        let conversationHistory = [];
        let isTyping = false;

        // Comprehensive AI Knowledge Base
        const skinCareKnowledge = {
            skinTypes: {
                oily: {
                    characteristics: "Excess sebum production, enlarged pores, shiny T-zone",
                    routine: "Gentle cleanser twice daily, BHA exfoliant 2-3x/week, lightweight moisturizer, broad-spectrum SPF",
                    ingredients: "Salicylic acid, niacinamide, hyaluronic acid, zinc oxide",
                    products: ["Oil-Control Cleanser", "BHA Exfoliant", "Mattifying Moisturizer"]
                },
                dry: {
                    characteristics: "Tight feeling, flaking, rough texture, fine lines",
                    routine: "Gentle cream cleanser, hydrating serum, rich moisturizer, gentle SPF",
                    ingredients: "Hyaluronic acid, ceramides, glycerin, squalane, peptides",
                    products: ["Hydrating Cleanser", "Moisture Serum", "Rich Night Cream"]
                },
                combination: {
                    characteristics: "Oily T-zone with normal to dry cheeks",
                    routine: "Gentle cleanser, targeted treatments, balanced moisturizer, SPF",
                    ingredients: "Niacinamide, hyaluronic acid, gentle AHAs",
                    products: ["Balancing Cleanser", "Dual-Action Serum", "Lightweight Moisturizer"]
                },
                sensitive: {
                    characteristics: "Reactive, redness, stinging, irritation-prone",
                    routine: "Ultra-gentle cleanser, soothing serum, fragrance-free moisturizer, mineral SPF",
                    ingredients: "Centella asiatica, aloe vera, chamomile, zinc oxide",
                    products: ["Gentle Cleanser", "Soothing Serum", "Barrier Repair Cream"]
                }
            },
            concerns: {
                acne: {
                    causes: "Excess oil, clogged pores, bacteria, inflammation, hormones",
                    treatment: "Salicylic acid, benzoyl peroxide, retinoids, consistent routine",
                    routine: "Gentle cleanser, BHA treatment, spot treatment, oil-free moisturizer",
                    tips: "Don't over-cleanse, introduce actives slowly, be patient with results"
                },
                aging: {
                    causes: "UV damage, decreased collagen, free radicals, genetics",
                    treatment: "Retinoids, vitamin C, peptides, sunscreen, AHAs",
                    routine: "Antioxidant serum (morning), retinoid (evening), moisturizer, SPF 30+",
                    tips: "Start retinoids slowly, never skip sunscreen, consistency is key"
                },
                hyperpigmentation: {
                    causes: "Sun damage, post-inflammatory marks, hormonal changes",
                    treatment: "Vitamin C, kojic acid, arbutin, AHAs, hydroquinone",
                    routine: "Vitamin C serum, gentle exfoliant, brightening treatment, SPF",
                    tips: "Sunscreen is crucial, be patient, avoid picking at skin"
                },
                dehydration: {
                    causes: "Weather, over-cleansing, harsh products, lack of moisture",
                    treatment: "Hyaluronic acid, ceramides, gentle products, humidifier",
                    routine: "Cream cleanser, hydrating toner, serum, occlusive moisturizer",
                    tips: "Layer hydrating products, drink water, avoid harsh ingredients"
                }
            },
            ingredients: {
                "retinol": "Anti-aging powerhouse, increases cell turnover, improves texture and fine lines",
                "vitamin c": "Antioxidant, brightens skin, protects against free radicals, boosts collagen",
                "hyaluronic acid": "Humectant, holds 1000x its weight in water, plumps and hydrates",
                "niacinamide": "Regulates oil, minimizes pores, reduces redness, strengthens barrier",
                "salicylic acid": "BHA exfoliant, penetrates pores, reduces acne and blackheads",
                "glycolic acid": "AHA exfoliant, removes dead skin, improves texture and radiance",
                "ceramides": "Lipids that strengthen skin barrier and lock in moisture",
                "peptides": "Amino acid chains that signal collagen production and repair"
            }
        };

        // Initialize App
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.getElementById('loadingScreen').style.opacity = '0';
                setTimeout(() => document.getElementById('loadingScreen').style.display = 'none', 500);
            }, 1500);
            
            initializeChat();
            initializeSkinAnalyzer();
            autoResizeTextarea();
        });

        // Initialize Skin Analyzer
        function initializeSkinAnalyzer() {
            const uploadBox = document.getElementById('skinUploadBox');
            const imageUpload = document.getElementById('skinImageUpload');
            const preview = document.getElementById('skinPreview');
            const analyzeButton = document.getElementById('analyzeSkinButton');
            const buttonText = document.getElementById('analyzeButtonText');
            const resultsSection = document.getElementById('skinResultsSection');

            // Enhanced product database for skin analysis
            const skinProductDatabase = {
                acne: [
                    { 
                        name: "Advanced Acne Control Cleanser", 
                        description: "Salicylic acid formula to prevent breakouts",
                        price: "₹899"
                    },
                    { 
                        name: "Targeted Spot Treatment", 
                        description: "Fast-acting treatment for blemishes",
                        price: "₹599"
                    }
                ],
                pimples: [
                    { 
                        name: "Hydrocolloid Pimple Patches", 
                        description: "Invisible patches that extract impurities",
                        price: "₹399"
                    },
                    { 
                        name: "Tea Tree Oil Spot Gel", 
                        description: "Natural antibacterial spot treatment",
                        price: "₹499"
                    }
                ],
                tan: [
                    { 
                        name: "Vitamin C Brightening Serum", 
                        description: "Powerful antioxidant for even skin tone",
                        price: "₹1299"
                    },
                    { 
                        name: "Detan & Glow Face Pack", 
                        description: "Weekly treatment to restore radiance",
                        price: "₹699"
                    }
                ],
                oily: [
                    { 
                        name: "Oil-Control Moisturizer", 
                        description: "Lightweight, mattifying formula",
                        price: "₹799"
                    },
                    { 
                        name: "Purifying Clay Mask", 
                        description: "Deep-cleansing pore minimizer",
                        price: "₹599"
                    }
                ],
                dry: [
                    { 
                        name: "Hydrating Face Cream", 
                        description: "Rich moisturizer with hyaluronic acid",
                        price: "₹999"
                    },
                    { 
                        name: "Nourishing Face Oil", 
                        description: "Lightweight oil blend for barrier repair",
                        price: "₹1199"
                    }
                ]
            };

            // Upload box interactions
            uploadBox.addEventListener('click', () => {
                imageUpload.click();
            });

            // Drag and drop functionality
            uploadBox.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadBox.style.borderColor = '#667eea';
                uploadBox.style.background = 'linear-gradient(135deg,#edf2f7 0%,#e2e8f0 100%)';
            });

            uploadBox.addEventListener('dragleave', () => {
                uploadBox.style.borderColor = '#cbd5e0';
                uploadBox.style.background = 'linear-gradient(135deg,#f7fafc 0%,#edf2f7 100%)';
            });

            uploadBox.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadBox.style.borderColor = '#cbd5e0';
                uploadBox.style.background = 'linear-gradient(135deg,#f7fafc 0%,#edf2f7 100%)';
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    handleSkinImageUpload(files[0]);
                }
            });

            // Handle file upload
            imageUpload.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    handleSkinImageUpload(file);
                }
            });

            function handleSkinImageUpload(file) {
                if (file.size > 10 * 1024 * 1024) {
                    showToast('File size too large. Please choose an image under 10MB.', 'error');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                    
                    // Hide upload content and show preview
                    uploadBox.querySelector('.upload-content').style.display = 'none';
                    
                    showToast('Image uploaded successfully! Ready for analysis.', 'success');
                };
                reader.readAsDataURL(file);
            }

            // Enhanced analyze function
            analyzeButton.addEventListener('click', function() {
                const file = imageUpload.files[0];

                if (!file) {
                    showToast('Please upload an image first!', 'error');
                    return;
                }

                // Show loading state
                this.style.background = 'linear-gradient(-45deg, #667eea, #764ba2, #667eea, #764ba2)';
                this.style.backgroundSize = '400% 400%';
                this.style.animation = 'gradient 2s ease infinite';
                this.disabled = true;
                buttonText.textContent = '🔬 Analyzing...';

                // Perform AI analysis
                performSkinAnalysis(file).then(results => {
                    displaySkinResults(results);
                    
                    // Reset button
                    this.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                    this.style.animation = '';
                    this.disabled = false;
                    buttonText.textContent = '🔍 Analyze Again';
                    
                    showToast('Analysis complete! Check your results below.', 'success');
                    
                    // Add analysis results to chat
                    addAnalysisToChat(results);
                });
            });

            // Enhanced AI Analysis simulation
            function performSkinAnalysis(image) {
                return new Promise((resolve) => {
                    setTimeout(() => {
                        const conditions = ["acne", "pimples", "tan", "oily", "dry"];
                        const detected = conditions.filter(() => Math.random() > 0.65);
                        const confidenceScore = Math.floor(Math.random() * 15) + 85; // 85-99%
                        
                        resolve({
                            conditions: detected.length > 0 ? detected : ["normal"],
                            confidence: confidenceScore,
                            skinAge: Math.floor(Math.random() * 10) + 20,
                            hydrationLevel: Math.floor(Math.random() * 40) + 60
                        });
                    }, 3000);
                });
            }

            // Enhanced results display
            function displaySkinResults(analysis) {
                const resultsDiv = document.getElementById('skinResults');
                resultsSection.style.display = 'block';
                resultsDiv.innerHTML = "";

                // Analysis summary
                const summaryHTML = `
                    <div style="background:linear-gradient(135deg,rgba(102,126,234,0.1),rgba(240,147,251,0.1));border-radius:20px;padding:30px;margin-bottom:30px;text-align:center">
                        <h4 style="color:#667eea;font-size:1.8rem;margin-bottom:20px">Analysis Summary</h4>
                        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:20px">
                            <div style="background:rgba(255,255,255,0.8);padding:20px;border-radius:15px">
                                <div style="font-size:2rem;color:#667eea;margin-bottom:8px">${analysis.confidence}%</div>
                                <div style="font-size:14px;color:#666">Confidence</div>
                            </div>
                            <div style="background:rgba(255,255,255,0.8);padding:20px;border-radius:15px">
                                <div style="font-size:2rem;color:#f093fb;margin-bottom:8px">${analysis.skinAge}</div>
                                <div style="font-size:14px;color:#666">Skin Age</div>
                            </div>
                            <div style="background:rgba(255,255,255,0.8);padding:20px;border-radius:15px">
                                <div style="font-size:2rem;color:#4ecdc4;margin-bottom:8px">${analysis.hydrationLevel}%</div>
                                <div style="font-size:14px;color:#666">Hydration</div>
                            </div>
                        </div>
                    </div>
                `;

                resultsDiv.innerHTML = summaryHTML;

                if (analysis.conditions.includes("normal")) {
                    const healthyHTML = `
                        <div style="background:linear-gradient(135deg,#4ecdc4,#44a08d);color:white;padding:40px;border-radius:25px;text-align:center;margin:20px 0">
                            <h3 style="font-size:2.2rem;margin-bottom:20px">🌟 Congratulations!</h3>
                            <p style="font-size:1.2rem;margin-bottom:15px">Your skin looks healthy and well-maintained!</p>
                            <p style="opacity:0.9">Continue with your current routine to maintain this beautiful, balanced complexion.</p>
                        </div>
                    `;
                    resultsDiv.insertAdjacentHTML('beforeend', healthyHTML);
                } else {
                    // Show detected conditions
                    analysis.conditions.forEach(condition => {
                        const conditionHTML = `
                            <div style="background:linear-gradient(135deg,#ff6b6b,#ee5a24);color:white;padding:20px 30px;border-radius:18px;margin:20px 0;text-align:center;box-shadow:0 10px 30px rgba(255,107,107,0.3)">
                                <h4 style="font-size:1.4rem;margin-bottom:10px">Detected: ${condition.charAt(0).toUpperCase() + condition.slice(1)} Skin Concerns</h4>
                                <p style="opacity:0.9">${getConditionDescription(condition)}</p>
                            </div>
                        `;
                        resultsDiv.insertAdjacentHTML('beforeend', conditionHTML);
                    });

                    // Show recommended products
                    const productsHTML = `
                        <div style="margin-top:40px">
                            <h4 style="text-align:center;color:#4a5568;font-size:1.8rem;margin-bottom:30px">Recommended Products</h4>
                            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:25px">
                    `;
                    
                    let allProducts = [];
                    analysis.conditions.forEach(condition => {
                        if (skinProductDatabase[condition]) {
                            allProducts = [...allProducts, ...skinProductDatabase[condition]];
                        }
                    });

                    let productsGrid = '';
                    allProducts.forEach(product => {
                        productsGrid += `
                            <div style="background:linear-gradient(135deg,#f093fb,#f5576c);color:white;padding:30px;border-radius:20px;box-shadow:0 15px 40px rgba(240,147,251,0.3);transition:all 0.4s ease;position:relative;overflow:hidden" 
                                 onmouseover="this.style.transform='translateY(-10px)';this.style.boxShadow='0 25px 50px rgba(240,147,251,0.4)'" 
                                 onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 15px 40px rgba(240,147,251,0.3)'">
                                <h5 style="font-size:1.3rem;margin-bottom:15px;font-weight:700">${product.name}</h5>
                                <p style="opacity:0.9;margin-bottom:15px;font-size:0.95rem">${product.description}</p>
                                <div style="font-size:1.4rem;font-weight:800;margin-bottom:20px">${product.price}</div>
                                <div style="display:flex;gap:10px;justify-content:center">
                                    <button style="background:rgba(255,255,255,0.2);color:white;border:1px solid rgba(255,255,255,0.3);padding:10px 20px;border-radius:15px;cursor:pointer;font-weight:600;transition:all 0.3s ease" 
                                            onmouseover="this.style.background='rgba(255,255,255,0.3)'"
                                            onmouseout="this.style.background='rgba(255,255,255,0.2)'"
                                            onclick="addToCart('${product.name}', ${product.price.replace('₹', '')})">Add to Cart</button>
                                    <button style="background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.3);color:white;padding:10px;border-radius:15px;cursor:pointer;transition:all 0.3s ease"
                                            onmouseover="this.style.background='rgba(255,255,255,0.3)'"
                                            onmouseout="this.style.background='rgba(255,255,255,0.2)'"
                                            onclick="this.innerHTML = this.innerHTML === '❤' ? '💖' : '❤'; showToast('💖 Added to wishlist!', 'success')">❤</button>
                                </div>
                            </div>
                        `;
                    });

                    resultsDiv.insertAdjacentHTML('beforeend', productsHTML + productsGrid + '</div></div>');
                }

                // Scroll to results with smooth animation
                setTimeout(() => {
                    resultsSection.scrollIntoView({ 
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 500);
            }

            function getConditionDescription(condition) {
                const descriptions = {
                    'acne': 'Your skin shows signs of acne-prone areas that need gentle but effective treatment.',
                    'pimples': 'Active breakouts detected - targeted spot treatments recommended.',
                    'tan': 'Uneven pigmentation detected - brightening products can help restore radiance.',
                    'oily': 'Excess oil production detected - oil-control products will help balance your skin.',
                    'dry': 'Your skin needs extra hydration - moisturizing products are essential.'
                };
                return descriptions[condition] || 'Specific skin concerns detected that need targeted care.';
            }

            // Add analysis results to chat
            function addAnalysisToChat(analysis) {
                const analysisMessage = `📸 **Photo Analysis Complete!**

**Results Summary:**
• **Confidence:** ${analysis.confidence}%
• **Skin Age:** ${analysis.skinAge} years
• **Hydration Level:** ${analysis.hydrationLevel}%

**Detected Concerns:** ${analysis.conditions.includes('normal') ? 'Healthy skin detected!' : analysis.conditions.join(', ')}

${analysis.conditions.includes('normal') ? 
    'Great news! Your skin appears healthy. Keep up your current routine!' : 
    'Based on your analysis, I recommend focusing on targeted treatments for these areas. Would you like specific product recommendations or routine advice?'
}

Feel free to ask me any questions about your results!`;

                setTimeout(() => {
                    addMessage(analysisMessage, 'bot');
                    conversationHistory.push({ role: 'assistant', content: analysisMessage });
                }, 1000);
            }
        }

        // Navigation Functions
        function scrollToChat() {
            document.getElementById('ai-expert').scrollIntoView({ behavior: 'smooth' });
            document.getElementById('chatInput').focus();
        }

        function scrollToProducts() {
            document.getElementById('products').scrollIntoView({ behavior: 'smooth' });
        }

        // Chat Functions
        function initializeChat() {
            const typingIndicator = document.getElementById('typingIndicator');
            typingIndicator.style.display = 'none';
            
            // Hide quick questions after first interaction
            setTimeout(() => {
                const quickQuestions = document.querySelector('.quick-questions');
                if (conversationHistory.length === 0) {
                    quickQuestions.style.display = 'block';
                }
            }, 1000);
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        function sendQuickQuestion(question) {
            document.getElementById('chatInput').value = question;
            sendMessage();
            // Hide quick questions after first use
            document.querySelector('.quick-questions').style.display = 'none';
        }

        function sendMessage() {
            const input = document.getElementById('chatInput');
            const message = input.value.trim();
            
            if (!message || isTyping) return;
            
            // Add user message
            addMessage(message, 'user');
            input.value = '';
            input.style.height = 'auto';
            
            // Store in conversation history
            conversationHistory.push({ role: 'user', content: message });
            
            // Hide quick questions after first message
            const quickQuestions = document.querySelector('.quick-questions');
            if (quickQuestions) quickQuestions.style.display = 'none';
            
            // Show typing indicator and generate response
            showTypingIndicator();
            setTimeout(() => {
                const response = generateAIResponse(message);
                hideTypingIndicator();
                addMessage(response, 'bot');
                conversationHistory.push({ role: 'assistant', content: response });
            }, 1500 + Math.random() * 2000);
        }

        function addMessage(content, sender) {
            const messagesContainer = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}`;
            
            const avatar = document.createElement('div');
            avatar.className = 'message-avatar';
            avatar.textContent = sender === 'user' ? '👤' : '🤖';
            
            const messageContent = document.createElement('div');
            messageContent.className = 'message-content';
            messageContent.innerHTML = content;
            
            messageDiv.appendChild(avatar);
            messageDiv.appendChild(messageContent);
            
            // Insert before typing indicator
            const typingIndicator = document.getElementById('typingIndicator');
            messagesContainer.insertBefore(messageDiv, typingIndicator);
            
            // Scroll to bottom
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function showTypingIndicator() {
            isTyping = true;
            const indicator = document.getElementById('typingIndicator');
            indicator.style.display = 'flex';
            document.getElementById('chatMessages').scrollTop = document.getElementById('chatMessages').scrollHeight;
        }

        function hideTypingIndicator() {
            isTyping = false;
            document.getElementById('typingIndicator').style.display = 'none';
        }

        // Advanced AI Response Generator
        function generateAIResponse(userMessage) {
            const message = userMessage.toLowerCase();
            
            // Greeting responses
            if (message.includes('hello') || message.includes('hi') || message.includes('hey')) {
                return `Hello! I'm Dr. TOUCH AI, your personal skincare consultant. I'm here to help you achieve your best skin. What specific skin concerns would you like to address today?`;
            }
            
            // Skin type questions
            if (message.includes('skin type') || message.includes('what type')) {
                return `To determine your skin type, observe your skin 30 minutes after cleansing:
                
<strong>🟢 Normal:</strong> Balanced, neither too oily nor dry
<strong>🟡 Oily:</strong> Shiny, enlarged pores, frequent breakouts  
<strong>🔵 Dry:</strong> Tight, flaky, rough texture
<strong>🟠 Combination:</strong> Oily T-zone, normal/dry cheeks
<strong>🔴 Sensitive:</strong> Easily irritated, reactive to products

What does your skin look and feel like after cleansing?`;
            }
            
            // Oily skin responses
            if (message.includes('oily skin') || message.includes('oily')) {
                const info = skinCareKnowledge.skinTypes.oily;
                return `<strong>Oily Skin Care Guide:</strong>

<strong>🎯 Key Strategy:</strong> Balance oil production without over-drying

<strong>📋 Recommended Routine:</strong>
• <strong>Morning:</strong> Gentle cleanser → Niacinamide serum → Oil-free moisturizer → SPF
• <strong>Evening:</strong> Cleanser → BHA treatment (2-3x/week) → Lightweight moisturizer

<strong>🌟 Best Ingredients:</strong>
• Salicylic acid (unclogs pores)
• Niacinamide (controls oil)
• Hyaluronic acid (hydrates without oil)

<strong>❌ Avoid:</strong> Over-cleansing, harsh scrubs, alcohol-based toners

${generateProductRecommendations(['Oil-Control Cleanser', 'BHA Exfoliant', 'Niacinamide Serum'])}

Would you like specific product recommendations or have questions about any of these steps?`;
            }
            
            // Dry skin responses
            if (message.includes('dry skin') || message.includes('dry')) {
                return `<strong>Dry Skin Care Guide:</strong>

<strong>🎯 Key Strategy:</strong> Restore and maintain skin barrier

<strong>📋 Recommended Routine:</strong>
• <strong>Morning:</strong> Cream cleanser → Hydrating serum → Rich moisturizer → SPF
• <strong>Evening:</strong> Oil cleanser → Cream cleanser → Hydrating treatment → Night cream

<strong>🌟 Best Ingredients:</strong>
• Hyaluronic acid (intense hydration)
• Ceramides (barrier repair)  
• Squalane (locks in moisture)
• Glycerin (attracts moisture)

<strong>❌ Avoid:</strong> Harsh cleansers, alcohol, fragrances, over-exfoliating

${generateProductRecommendations(['Hydrating Cleanser', 'Moisture Serum', 'Rich Night Cream'])}

Tip: Apply products on damp skin for better absorption!`;
            }
            
            // Acne responses
            if (message.includes('acne') || message.includes('pimple') || message.includes('breakout')) {
                return `<strong>Acne Treatment Guide:</strong>

<strong>🎯 Root Causes:</strong> Excess oil + clogged pores + bacteria + inflammation

<strong>📋 Effective Routine:</strong>
• <strong>Morning:</strong> Gentle cleanser → Spot treatment → Oil-free moisturizer → SPF
• <strong>Evening:</strong> Cleanser → BHA/Retinoid (alternate) → Moisturizer

<strong>🌟 Proven Ingredients:</strong>
• Salicylic acid 2% (penetrates pores)
• Benzoyl peroxide 2.5% (kills bacteria)
• Retinoids (prevent new breakouts)
• Niacinamide (reduces inflammation)

<strong>⚠️ Important Tips:</strong>
• Start slowly with actives
• Don't pick or squeeze
• Be patient - results take 6-12 weeks
• Always use sunscreen

${generateProductRecommendations(['Acne Control Cleanser', 'BHA Treatment', 'Spot Treatment Gel'])}

What type of acne are you dealing with - blackheads, whiteheads, or inflammatory pimples?`;
            }
            
            // Anti-aging responses
            if (message.includes('anti-aging') || message.includes('wrinkle') || message.includes('fine lines') || message.includes('aging')) {
                return `<strong>Anti-Aging Skincare Guide:</strong>

<strong>🎯 Prevention + Treatment Approach</strong>

<strong>📋 Gold Standard Routine:</strong>
• <strong>Morning:</strong> Vitamin C serum → Moisturizer → SPF 30+
• <strong>Evening:</strong> Cleanser → Retinoid → Moisturizer + Face oil

<strong>🌟 Most Effective Ingredients:</strong>
• <strong>Retinoids:</strong> #1 anti-aging ingredient, stimulates collagen
• <strong>Vitamin C:</strong> Protects from damage, brightens
• <strong>Peptides:</strong> Support collagen production
• <strong>AHA:</strong> Improve texture and radiance

<strong>🛡️ Prevention is Key:</strong>
• Sunscreen DAILY (most important!)
• Antioxidants
• Gentle skincare routine

${generateProductRecommendations(['Vitamin C Serum', 'Retinol Treatment', 'Peptide Moisturizer'])}

<strong>Timeline:</strong> 4-6 weeks for initial improvements, 3-6 months for significant results.

What specific signs of aging are you most concerned about?`;
            }
            
            // Ingredient questions
            const ingredientQuestions = ['retinol', 'vitamin c', 'hyaluronic acid', 'niacinamide', 'salicylic acid'];
            for (let ingredient of ingredientQuestions) {
                if (message.includes(ingredient)) {
                    return generateIngredientResponse(ingredient);
                }
            }
            
            // Routine questions
            if (message.includes('routine') || message.includes('order') || message.includes('steps')) {
                return `<strong>Complete Skincare Routine Order:</strong>

<strong>🌅 Morning Routine:</strong>
1. Cleanser
2. Toner/Essence (optional)
3. Vitamin C Serum
4. Eye cream
5. Moisturizer  
6. Sunscreen (SPF 30+)

<strong>🌙 Evening Routine:</strong>
1. Oil cleanser (if wearing makeup/SPF)
2. Water-based cleanser
3. Treatment (BHA/AHA/Retinoid)
4. Serums (lightest to heaviest)
5. Eye cream
6. Moisturizer
7. Face oil (optional)

<strong>📝 Key Rules:</strong>
• Thinnest to thickest consistency
• Wait 10-15 minutes between actives
• Always patch test new products
• Introduce one new product at a time

What's your current routine? I can help optimize it!`;
            }
            
            // Dark circles
            if (message.includes('dark circles') || message.includes('under eye')) {
                return `<strong>Dark Circles Treatment Guide:</strong>

<strong>🎯 Different Types Need Different Approaches:</strong>

<strong>🟤 Pigmentation-based:</strong>
• Vitamin C, kojic acid, arbutin
• Gentle brightening eye creams
• Consistent sunscreen use

<strong>🔵 Vascular (blue/purple):</strong>  
• Caffeine-based eye creams
• Cold compress
• Improve circulation with gentle massage

<strong>💧 Dehydration lines:</strong>
• Hyaluronic acid eye serums
• Rich, hydrating eye creams
• Drink more water

<strong>📋 Daily Care:</strong>
• Gentle patting (never rubbing)
• SPF around eye area
• Quality sleep (7-9 hours)
• Elevate head while sleeping

${generateProductRecommendations(['Vitamin C Eye Serum', 'Caffeine Eye Cream', 'Hydrating Eye Patches'])}

What do your dark circles look like - brown, blue, or more like bags/puffiness?`;
            }
            
            // Exfoliation questions
            if (message.includes('exfoliat') || message.includes('scrub')) {
                return `<strong>Exfoliation Guide:</strong>

<strong>🧪 Chemical vs Physical:</strong>
• <strong>Chemical (Recommended):</strong> AHA/BHA acids - gentler, more effective
• <strong>Physical:</strong> Scrubs - can be harsh, use sparingly

<strong>📅 Frequency Guide:</strong>
• <strong>Sensitive skin:</strong> 1x per week
• <strong>Normal skin:</strong> 2-3x per week  
• <strong>Oily/acne-prone:</strong> 3-4x per week (BHA)
• <strong>Dry/mature:</strong> 1-2x per week (AHA)

<strong>🌟 Best Chemical Exfoliants:</strong>
• <strong>Salicylic acid (BHA):</strong> Oily, acne-prone skin
• <strong>Glycolic acid (AHA):</strong> Dullness, texture issues
• <strong>Lactic acid (AHA):</strong> Sensitive, dry skin

<strong>⚠️ Important:</strong>
• Start slowly (1x per week)
• Always use sunscreen the next day
• Don't mix with retinoids initially
• Stop if irritation occurs

Over-exfoliation signs: Redness, burning, excessive dryness, more breakouts.`;
            }
            
            // Sunscreen questions
            if (message.includes('sunscreen') || message.includes('spf') || message.includes('sun protection')) {
                return `<strong>Sunscreen Masterclass:</strong>

<strong>🛡️ Why SPF is Non-Negotiable:</strong>
• Prevents 80% of visible aging
• Reduces skin cancer risk
• Prevents dark spots and hyperpigmentation

<strong>📊 SPF Requirements:</strong>
• <strong>Daily minimum:</strong> SPF 30
• <strong>Beach/outdoor:</strong> SPF 50+
• <strong>Amount needed:</strong> 1/4 teaspoon for face
• <strong>Reapply:</strong> Every 2 hours

<strong>🧪 Types:</strong>
• <strong>Chemical:</strong> Absorbs UV rays, lightweight
• <strong>Mineral/Physical:</strong> Reflects UV rays, better for sensitive skin

<strong>💡 Pro Tips:</strong>
• Apply 15 minutes before sun exposure
• Don't forget neck, ears, hands
• Makeup with SPF isn't enough alone
• Choose broad-spectrum protection

${generateProductRecommendations(['Daily Defense SPF 50', 'Tinted Mineral Sunscreen', 'Sport Sunscreen SPF 60'])}

What's your current sunscreen routine? Any specific concerns like white cast or greasiness?`;
            }
            
            // Default response with smart suggestions
            return generateContextualResponse(message);
        }

        function generateIngredientResponse(ingredient) {
            const info = skinCareKnowledge.ingredients[ingredient];
            if (!info) return "I'd be happy to explain that ingredient! Could you be more specific about which one you're asking about?";
            
            const responses = {
                'retinol': `<strong>Retinol - The Gold Standard Anti-Ager:</strong>

<strong>🌟 What it does:</strong>
${info}

<strong>📋 How to use:</strong>
• Start 1x per week, gradually increase
• Apply at night only
• Use pea-sized amount for entire face
• Always follow with moisturizer

<strong>⚠️ Side effects (normal at first):</strong>
• Mild irritation, dryness, peeling
• Increased sun sensitivity

<strong>💡 Pro tips:</strong>
• Start with 0.25-0.5% concentration
• Never mix with vitamin C or AHA/BHA
• Pregnant/nursing women should avoid
• Results visible in 4-12 weeks

${generateProductRecommendations(['Beginner Retinol 0.25%', 'Advanced Retinol 1%', 'Retinol Repair Serum'])}`,

                'vitamin c': `<strong>Vitamin C - The Ultimate Brightener:</strong>

<strong>🌟 Benefits:</strong>
${info}

<strong>📋 Best practices:</strong>
• Use in morning routine
• Apply to clean skin before moisturizer
• Look for L-Ascorbic acid or stable derivatives
• Store in cool, dark place

<strong>🎯 Concentration guide:</strong>
• <strong>Beginners:</strong> 10-15%
• <strong>Experienced:</strong> 15-20%
• <strong>Sensitive skin:</strong> 5-10%

<strong>💡 Pro tips:</strong>
• Patch test first (can cause irritation)
• Don't mix with retinol or BHA initially  
• Results visible in 4-6 weeks
• Always follow with SPF

${generateProductRecommendations(['Vitamin C Brightening Serum', 'Stable Vitamin C Complex', 'Vitamin C + E Antioxidant'])}`,

                'hyaluronic acid': `<strong>Hyaluronic Acid - The Hydration Hero:</strong>

<strong>🌟 Superpower:</strong>
${info}

<strong>📋 How to maximize benefits:</strong>
• Apply to damp skin
• Follow with moisturizer to seal in
• Use morning and/or evening
• Suitable for all skin types

<strong>🎯 Best for:</strong>
• Dehydrated skin
• Fine lines from dryness
• Plumping effect
• All ages and skin types

<strong>💡 Pro tips:</strong>
• Can cause dryness if used wrong (apply on damp skin!)
• Layer under heavier products
• Great under makeup
• Works well with all other ingredients

${generateProductRecommendations(['Pure Hyaluronic Acid Serum', 'Multi-Weight HA Complex', 'HA + B5 Hydrating Gel'])}`,

                'niacinamide': `<strong>Niacinamide - The Multi-Tasker:</strong>

<strong>🌟 Amazing benefits:</strong>
${info}

<strong>📋 Usage guide:</strong>
• Use morning and/or evening
• Apply after cleansing, before moisturizer
• Start with 5% concentration
• Can use with most other ingredients

<strong>🎯 Perfect for:</strong>
• Oily, acne-prone skin
• Large pores
• Redness and sensitivity
• Uneven skin tone

<strong>💡 Pro tips:</strong>
• One of the gentlest actives
• Works well with retinol and vitamin C
• Results visible in 2-4 weeks
• Higher isn't always better (5-10% is ideal)

${generateProductRecommendations(['Niacinamide 10% Serum', 'Niacinamide + Zinc Formula', 'Multi-Active Niacinamide Complex'])}`,

                'salicylic acid': `<strong>Salicylic Acid - The Pore Clearer:</strong>

<strong>🌟 What makes it special:</strong>
${info}

<strong>📋 Proper usage:</strong>
• Start 1-2x per week, build tolerance
• Use evening routine
• Concentration: 0.5-2%
• Always follow with moisturizer

<strong>🎯 Best for:</strong>
• Acne and blackheads
• Oily, congested skin
• Rough, bumpy texture
• Enlarged pores

<strong>⚠️ Important notes:</strong>
• Increases sun sensitivity (use SPF!)
• Can cause dryness initially
• Don't use with other strong actives at first
• Avoid if allergic to aspirin

${generateProductRecommendations(['BHA Exfoliant 2%', 'Salicylic Acid Cleanser', 'Targeted BHA Spot Treatment'])}`
            };
            
            return responses[ingredient] || `${info}\n\nWould you like specific product recommendations or usage tips for ${ingredient}?`;
        }

        function generateContextualResponse(message) {
            // Analyze message for key skincare terms
            const concerns = [];
            if (message.includes('pore') || message.includes('blackhead')) concerns.push('enlarged pores');
            if (message.includes('red') || message.includes('irritat')) concerns.push('sensitivity');
            if (message.includes('dull') || message.includes('glow')) concerns.push('dullness');
            if (message.includes('spot') || message.includes('pigment')) concerns.push('dark spots');
            
            if (concerns.length > 0) {
                return `I understand you're dealing with ${concerns.join(' and ')}. Let me provide targeted advice:

${concerns.map(concern => {
    switch(concern) {
        case 'enlarged pores':
            return `<strong>🎯 Pore Care:</strong>
• Use BHA (salicylic acid) to clean out pores
• Niacinamide helps minimize appearance
• Clay masks 1-2x weekly
• Never skip moisturizer (dehydration makes pores look larger)`;
        case 'sensitivity':
            return `<strong>🌸 Sensitive Skin Care:</strong>
• Use fragrance-free, gentle products
• Patch test everything new
• Avoid alcohol, harsh scrubs, strong acids
• Look for soothing ingredients like centella, aloe`;
        case 'dullness':
            return `<strong>✨ Brightness Boosters:</strong>
• Vitamin C for daily radiance
• Gentle AHA exfoliation 1-2x weekly  
• Hydrating products for plump, glowing skin
• Never skip sunscreen`;
        case 'dark spots':
            return `<strong>🎨 Spot Treatment:</strong>
• Vitamin C, kojic acid, arbutin for brightening
• Consistent sunscreen to prevent darkening
• Be patient - fading takes 3-6 months
• Consider professional treatments for stubborn spots`;
        default:
            return '';
    }
}).join('\n\n')}

What specific products are you currently using? I can help optimize your routine!`;
            }
            
            // General helpful response
            const helpfulResponses = [
                `I'd love to help with your skincare concerns! To give you the best advice, could you tell me:

• What's your main skin concern right now?
• What's your current routine?  
• What's your skin type (oily, dry, combination, sensitive)?
• Any specific products or ingredients you're curious about?

I'm here to provide personalized guidance based on proven dermatological science!`,

                `Here are some fundamental skincare principles that work for everyone:

<strong>📋 The Universal Basics:</strong>
1. <strong>Gentle cleanser</strong> - removes dirt without stripping
2. <strong>Moisturizer</strong> - maintains skin barrier  
3. <strong>Sunscreen SPF 30+</strong> - prevents 80% of aging
4. <strong>Consistency</strong> - results take 4-12 weeks

<strong>🎯 Then Add Based on Concerns:</strong>
• Acne → Salicylic acid or benzoyl peroxide
• Aging → Retinoids and vitamin C
• Dark spots → Vitamin C and gentle AHAs
• Sensitivity → Minimal, fragrance-free routine

What would you like to focus on first?`,

                `I'm here to help you navigate the world of skincare! Whether you need:

• Product recommendations for your skin type
• Help building an effective routine
• Ingredient education and explanations  
• Solutions for specific concerns like acne, aging, or sensitivity
• Advice on when to see a dermatologist

Just ask me anything! What's your biggest skincare question or challenge right now?`
            ];
            
            return helpfulResponses[Math.floor(Math.random() * helpfulResponses.length)];
        }

        function generateProductRecommendations(products) {
            return `<div class="product-recommendation">
                <div class="product-rec-header">
                    <div class="product-rec-icon">💎</div>
                    <h4>Recommended Products</h4>
                </div>
                <div class="product-grid-chat">
                    ${products.map(product => `
                        <div class="product-card-mini">
                            <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="${product}">
                            <h5>${product}</h5>
                            <div class="price">₹${Math.floor(Math.random() * 1000) + 500}</div>
                        </div>
                    `).join('')}
                </div>
                <p style="margin-top:15px;color:#666;font-size:14px">Click on any product to learn more or add to cart!</p>
            </div>`;
        }

        function autoResizeTextarea() {
            const textarea = document.getElementById('chatInput');
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            });
        }

        // Product Functions
        function addToCart(productName, price) {
            showToast(`✅ ${productName} added to cart for ₹${price}!`, 'success');
            
            // Add contextual AI response
            setTimeout(() => {
                const response = `Great choice adding ${productName} to your cart! 

Here are some tips for using this product:
• Start with a patch test if it's your first time
• Introduce gradually into your routine
• Remember to use sunscreen if this contains active ingredients
• Results typically show in 4-6 weeks with consistent use

Need any advice on how to incorporate this into your routine?`;
                
                addMessage(response, 'bot');
            }, 2000);
        }

        function subscribeNewsletter() {
            const email = document.getElementById('emailInput').value;
            if (!email || !email.includes('@')) {
                showToast('Please enter a valid email address', 'error');
                return;
            }
            
            showToast('🎉 Welcome to our beauty community! Check your email for exclusive offers.', 'success');
            document.getElementById('emailInput').value = '';
        }

        // Toast Notifications
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.textContent = message;
            
            document.body.appendChild(toast);
            
            setTimeout(() => toast.classList.add('show'), 100);
            
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    if (document.body.contains(toast)) {
                        document.body.removeChild(toast);
                    }
                }, 400);
            }, 4000);
        }

        // Smooth Scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.getElementById('siteHeader');
            if (window.scrollY > 60) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Enhanced AI Features
        function analyzeSkinFromText(description) {
            const analysis = {
                skinType: 'combination',
                concerns: [],
                recommendations: []
            };
            
            const text = description.toLowerCase();
            
            // Determine skin type
            if (text.includes('oily') || text.includes('greasy') || text.includes('shiny')) {
                analysis.skinType = 'oily';
            } else if (text.includes('dry') || text.includes('flaky') || text.includes('tight')) {
                analysis.skinType = 'dry';
            } else if (text.includes('sensitive') || text.includes('irritated') || text.includes('red')) {
                analysis.skinType = 'sensitive';
            }
            
            // Identify concerns
            if (text.includes('acne') || text.includes('pimple') || text.includes('breakout')) {
                analysis.concerns.push('acne');
            }
            if (text.includes('wrinkle') || text.includes('aging') || text.includes('fine line')) {
                analysis.concerns.push('aging');
            }
            if (text.includes('dark spot') || text.includes('pigmentation')) {
                analysis.concerns.push('hyperpigmentation');
            }
            
            return analysis;
        }

        // Advanced conversation context
        function getConversationContext() {
            return conversationHistory.slice(-5).map(msg => msg.content).join(' ');
        }

        // Seasonal skincare advice
        function getSeasonalAdvice() {
            const month = new Date().getMonth();
            const season = month >= 3 && month <= 5 ? 'spring' : 
                          month >= 6 && month <= 8 ? 'summer' : 
                          month >= 9 && month <= 11 ? 'fall' : 'winter';
            
            const advice = {
                spring: "Spring transition: Lighter moisturizers, increased vitamin C for sun preparation",
                summer: "Summer protection: Higher SPF, antioxidants, hydrating mists for heat",
                fall: "Fall repair: Richer moisturizers, gentle exfoliation, barrier repair",
                winter: "Winter care: Heavy moisturizers, gentle cleansers, humidifier use"
            };
            
            return advice[season];
        }

        // Ingredient interaction checker
        function checkIngredientInteractions(ingredients) {
            const conflicts = {
                'retinol': ['vitamin c', 'aha', 'bha'],
                'vitamin c': ['retinol', 'benzoyl peroxide'],
                'aha': ['retinol', 'bha'],
                'bha': ['retinol', 'aha']
            };
            
            const warnings = [];
            ingredients.forEach(ingredient => {
                if (conflicts[ingredient]) {
                    conflicts[ingredient].forEach(conflicting => {
                        if (ingredients.includes(conflicting)) {
                            warnings.push(`Avoid using ${ingredient} and ${conflicting} together`);
                        }
                    });
                }
            });
            
            return warnings;
        }

        // Product ingredient analysis
        function analyzeProductIngredients(productName) {
            // Simulated ingredient analysis
            const mockIngredients = {
                'serum': ['hyaluronic acid', 'vitamin c', 'niacinamide'],
                'cleanser': ['gentle surfactants', 'glycerin', 'ceramides'],
                'moisturizer': ['hyaluronic acid', 'ceramides', 'squalane']
            };
            
            const type = productName.toLowerCase().includes('serum') ? 'serum' :
                        productName.toLowerCase().includes('cleanser') ? 'cleanser' : 'moisturizer';
            
            return mockIngredients[type] || ['beneficial ingredients'];
        }

        // Welcome message on first load
        setTimeout(() => {
            if (conversationHistory.length === 0) {
                showToast('👋 Welcome! Chat with our AI skincare expert for personalized advice', 'info');
            }
        }, 3000);

        // Mobile responsiveness
        function handleMobileView() {
            if (window.innerWidth <= 768) {
                const chatMessages = document.getElementById('chatMessages');
                if (chatMessages) {
                    chatMessages.style.height = '300px';
                }
            }
        }

        window.addEventListener('resize', handleMobileView);
        handleMobileView();
    </script>

        <!-- AI Skincare Expert Chatbot -->
        <section id="ai-expert" class="chatbot-section">
            <div class="container">
                <h2 class="section-title">AI Skincare Expert</h2>
                <p style="text-align:center;color:#666;font-size:1.2rem;max-width:600px;margin:0 auto 50px">Ask me anything about skincare, ingredients, routines, or product recommendations. I'm here to help you achieve your best skin!</p>
                
                <div class="chatbot-container">
                    <div class="chatbot-header">
                        <div class="chatbot-avatar">🤖</div>
                        <div class="chatbot-info">
                            <h3>Dr. TOUCH AI</h3>
                            <p>Your personal skincare consultant</p>
                        </div>
                        <div class="status-indicator"></div>
                    </div>

                    <div class="chat-messages" id="chatMessages">
                        <div class="message bot">
                            <div class="message-avatar">🤖</div>
                            <div class="message-content">
                                <p>Hello! I'm Dr. TOUCH AI, your personal skincare expert. I can help you with:</p>
                                <ul style="margin:10px 0 10px 20px;color:#666">
                                    <li>Analyzing your skin concerns</li>
                                    <li>Recommending perfect products</li>
                                    <li>Creating custom skincare routines</li>
                                    <li>Explaining ingredient benefits</li>
                                    <li>Troubleshooting skin issues</li>
                                </ul>
                                <p>What would you like to know about your skin today?</p>
                            </div>
                        </div>

                        <div class="quick-questions">
                            <h4>Popular Questions:</h4>
                            <div class="question-chips">
                                <div class="question-chip" onclick="sendQuickQuestion('What skincare routine should I follow for oily skin?')">Oily skin routine</div>
                                <div class="question-chip" onclick="sendQuickQuestion('How do I get rid of acne scars?')">Acne scars</div>
                                <div class="question-chip" onclick="sendQuickQuestion('Best anti-aging ingredients?')">Anti-aging</div>
                                <div class="question-chip" onclick="sendQuickQuestion('How to reduce dark circles?')">Dark circles</div>
                                <div class="question-chip" onclick="sendQuickQuestion('What causes dry skin?')">Dry skin causes</div>
                                <div class="question-chip" onclick="sendQuickQuestion('How often should I exfoliate?')">Exfoliation guide</div>
                            </div>
                        </div>

                        <div class="message bot typing-indicator" id="typingIndicator">
                            <div class="message-avatar">🤖</div>
                            <div class="typing-indicator">
                                <div class="typing-dots">
                                    <div class="typing-dot"></div>
                                    <div class="typing-dot"></div>
                                    <div class="typing-dot"></div>
                                </div>
                                <span style="margin-left:10px;color:#666;font-size:14px">Dr. TOUCH AI is typing...</span>
                            </div>
                        </div>
                    </div>

                    <div class="chat-input-container">
                        <div class="chat-input-wrapper">
                            <textarea 
                                class="chat-input" 
                                id="chatInput" 
                                placeholder="Ask me anything about skincare..."
                                rows="1"
                                onkeypress="handleKeyPress(event)"
                            ></textarea>
                            <button class="chat-send-btn" id="sendBtn" onclick="sendMessage()">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- AI Skincare Analyzer Section -->
        <section id="analyzer" style="padding:120px 0;background:linear-gradient(135deg,rgba(102,126,234,0.05),rgba(240,147,251,0.05))">
            <div class="container">
                <h2 class="section-title">AI Photo Skin Analysis</h2>
                <p style="text-align:center;color:#666;font-size:1.2rem;max-width:600px;margin:0 auto 50px">Upload your photo for instant AI-powered skin analysis and personalized product recommendations</p>
                
                <!-- Analyzer Card -->
                <div style="max-width:900px;margin:0 auto;background:rgba(255,255,255,0.95);backdrop-filter:blur(20px);padding:50px;border-radius:30px;box-shadow:0 25px 60px rgba(0,0,0,0.1);border:1px solid rgba(255,255,255,0.3);position:relative;overflow:hidden">
                    
                    <!-- Upload Section -->
                    <div class="upload-section" style="text-align:center;margin-bottom:40px">
                        <h3 style="color:#4a5568;font-size:1.6rem;margin-bottom:15px">Upload Your Photo</h3>
                        <p style="color:#718096;margin-bottom:30px">Get personalized skincare recommendations in seconds</p>
                        
                        <div id="skinUploadBox" style="border:3px dashed #cbd5e0;padding:60px 30px;border-radius:25px;cursor:pointer;color:#718096;background:linear-gradient(135deg,#f7fafc 0%,#edf2f7 100%);transition:all 0.4s ease;position:relative;overflow:hidden">
                            <div class="upload-content" style="display:flex;flex-direction:column;align-items:center;gap:20px">
                                <div style="font-size:4rem;opacity:0.6">📸</div>
                                <div style="font-size:1.3rem;font-weight:600">Click to upload or drag and drop</div>
                                <div style="font-size:1rem;opacity:0.8">PNG, JPG up to 10MB</div>
                            </div>
                            <input type="file" id="skinImageUpload" accept="image/png, image/jpeg" style="display:none;">
                            <img id="skinPreview" src="#" alt="Preview" style="max-width:300px;max-height:300px;border-radius:20px;display:none;box-shadow:0 15px 40px rgba(0,0,0,0.2)">
                        </div>

                        <div style="margin-top:30px">
                            <button id="analyzeSkinButton" class="primary" style="padding:18px 45px;font-size:1.1rem;border-radius:50px;position:relative;overflow:hidden">
                                <span id="analyzeButtonText">🔬 Analyze My Skin</span>
                            </button>
                        </div>
                    </div>

                    <!-- Results Section -->
                    <div id="skinResultsSection" style="display:none;text-align:center;margin-bottom:40px">
                        <h3 style="color:#4a5568;font-size:2rem;margin-bottom:15px">Your Skin Analysis Results</h3>
                        <div id="skinResults">
                            <!-- Results will be populated here -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section id="products" class="container">
            <h2 class="section-title">Recommended Products</h2>
            
            <div class="product-grid">
                <div class="product-card" data-id="p1">
                    <div class="product-image">
                        <img src="https://naturali.co.in/cdn/shop/files/RADIANT_GLOW_FACE_SERUM-1_copy.webp?v=1737394250&width=1946" alt="Radiant Glow Serum">
                    </div>
                    <div class="product-info">
                        <h4>Radiant Glow Serum</h4>
                        <p class="product-desc">Vitamin C serum for instant glow and brightening</p>
                        <div class="price">₹899</div>
                        <div class="actions">
                            <button class="add-cart" onclick="addToCart('Radiant Glow Serum', 899)">Add to Cart</button>
                        </div>
                    </div>
                </div>

                <div class="product-card" data-id="p2">
                    <div class="product-image">
                        <img src="https://verymiss.in/cdn/shop/files/8904310308400_3.jpg?v=1723550218&width=1946" alt="Velvet Matte Lipstick">
                    </div>
                    <div class="product-info">
                        <h4>Velvet Matte Lipstick</h4>
                        <p class="product-desc">Long-lasting matte finish in stunning shades</p>
                        <div class="price">₹499</div>
                        <div class="actions">
                            <button class="add-cart" onclick="addToCart('Velvet Matte Lipstick', 499)">Add to Cart</button>
                        </div>
                    </div>
                </div>

                <div class="product-card" data-id="p3">
                    <div class="product-image">
                        <img src="https://m.media-amazon.com/images/S/aplus-media-library-service-media/dde4332d-67c0-4706-ac2f-6ab1cd144b83.__CR0,0,970,600_PT0_SX970_V1___.jpg" alt="Daily Defence Sunscreen">
                    </div>
                    <div class="product-info">
                        <h4>Daily Defence Sunscreen</h4>
                        <p class="product-desc">Broad spectrum SPF 50+ protection</p>
                        <div class="price">₹699</div>
                        <div class="actions">
                            <button class="add-cart" onclick="addToCart('Daily Defence Sunscreen', 699)">Add to Cart</button>
                        </div>
                    </div>
                </div>

                <div class="product-card" data-id="p4">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Flawless Foundation">
                    </div>
                    <div class="product-info">
                        <h4>Flawless Coverage Foundation</h4>
                        <p class="product-desc">24-hour wear with natural finish</p>
                        <div class="price">₹1,299</div>
                        <div class="actions">
                            <button class="add-cart" onclick="addToCart('Flawless Coverage Foundation', 1299)">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</body>
</html>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopSphere - Online Shopping</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4CAF50;
            --warning: #ffc107;
            --danger: #dc3545;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            color: #333;
        }
        
        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }
        
        .nav-link:hover {
            color: white !important;
            background-color: rgba(255,255,255,0.1);
        }
        
        .page {
            display: none;
        }
        
        .page.active {
            display: block;
        }
        
        /* Dashboard Cards */
        .dashboard-card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            overflow: hidden;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }
        
        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--primary);
        }
        
        /* Product Cards */
        .product-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .product-img {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .product-card:hover .product-img {
            transform: scale(1.05);
        }
        
        .badge-sale {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 0.9rem;
            padding: 5px 10px;
            background: var(--danger);
        }
        
        /* Cart Styles */
        .cart-item {
            transition: all 0.3s ease;
        }
        
        .cart-item:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        .quantity-btn {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #dee2e6;
            background: white;
        }
        
        .quantity-input {
            width: 50px;
            text-align: center;
            border: 1px solid #dee2e6;
            height: 30px;
        }
        
        .remove-item {
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .remove-item:hover {
            color: var(--danger) !important;
        }
        
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Utility Classes */
        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
            border-bottom: 2px solid rgba(0,0,0,0.1);
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 70px;
            height: 2px;
            background: var(--primary);
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-processing {
            background: #cce5ff;
            color: #004085;
        }
        
        .badge-delivered {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        
        /* Currency */
        .currency {
            position: relative;
            padding-left: 16px;
        }
        
        .currency:before {
            content: 'R';
            position: absolute;
            left: 0;
            top: 0;
            font-size: 0.9em;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.4rem;
            }
            
            .dashboard-card {
                margin-bottom: 20px;
            }
            
            .cart-item-image {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-shopping-bag me-2"></i>ShopSphere</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-page="home"><i class="fas fa-home me-1"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="products"><i class="fas fa-shopping-cart me-1"></i>Products</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="position-relative me-3">
                        <a href="#" class="btn btn-outline-light position-relative" data-page="cart">
                            <i class="fas fa-shopping-cart me-1"></i> Cart
                            <span class="cart-badge">0</span>
                        </a>
                    </div>
                    <a href="#" class="btn btn-light"><i class="fas fa-user me-1"></i> Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Home Page -->
    <div id="home" class="page active">
        <!-- Hero Section -->
        <section class="py-5" style="background: linear-gradient(rgba(67, 97, 238, 0.9), rgba(63, 55, 201, 0.9)), url('https://images.unsplash.com/photo-1607082350899-7e105aa886ae?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80') center/cover;">
            <div class="container py-5 text-white text-center">
                <h1 class="display-4 fw-bold mb-3">Welcome to ShopSphere</h1>
                <p class="lead mb-4">Your one-stop destination for all shopping needs. Buy and sell with confidence.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="btn btn-light btn-lg px-4 py-2" data-page="products"><i class="fas fa-shopping-bag me-2"></i> Shop Now</a>
                    <a href="#" class="btn btn-outline-light btn-lg px-4 py-2"><i class="fas fa-store me-2"></i> Start Selling</a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-center p-4 bg-white rounded shadow-sm">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 d-inline-block mb-3">
                                <i class="fas fa-credit-card fa-2x"></i>
                            </div>
                            <h4 class="mb-3">Secure Payments</h4>
                            <p class="text-muted">Shop with confidence using our secure payment gateway with 256-bit encryption.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-4 bg-white rounded shadow-sm">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 d-inline-block mb-3">
                                <i class="fas fa-shipping-fast fa-2x"></i>
                            </div>
                            <h4 class="mb-3">Fast Delivery</h4>
                            <p class="text-muted">Get your orders delivered within 2-3 business days with our express shipping.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-4 bg-white rounded shadow-sm">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3 d-inline-block mb-3">
                                <i class="fas fa-headset fa-2x"></i>
                            </div>
                            <h4 class="mb-3">24/7 Support</h4>
                            <p class="text-muted">Our dedicated support team is available around the clock to assist you.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Product Showcase -->
        <section class="py-5">
            <div class="container">
                <h2 class="section-title">Featured Products</h2>
                <div class="row g-4">
                    <!-- Product 1 -->
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" class="product-img w-100" alt="Smart Watch">
                                <span class="badge badge-sale position-absolute">SALE</span>
                            </div>
                            <div class="p-3">
                                <h5 class="mb-1">Smart Watch Pro</h5>
                                <p class="text-muted small mb-2">Fitness Tracker with Heart Rate Monitor</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold text-primary currency">1,999.99</span>
                                        <span class="text-muted text-decoration-line-through ms-2 currency">2,399.99</span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-grid mt-3">
                                    <button class="btn btn-primary btn-sm add-to-cart" data-id="1" data-name="Smart Watch Pro" data-price="1999.99" data-image="https://images.unsplash.com/photo-1546868871-7041f2a55e12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"><i class="fas fa-cart-plus me-1"></i> Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 2 -->
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" class="product-img w-100" alt="Wireless Headphones">
                            </div>
                            <div class="p-3">
                                <h5 class="mb-1">Wireless Headphones</h5>
                                <p class="text-muted small mb-2">Noise Cancelling Bluetooth Headset</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold text-primary currency">1,349.99</span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-grid mt-3">
                                    <button class="btn btn-primary btn-sm add-to-cart" data-id="2" data-name="Wireless Headphones" data-price="1349.99" data-image="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"><i class="fas fa-cart-plus me-1"></i> Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 3 -->
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" class="product-img w-100" alt="Smart Home Camera">
                                <span class="badge badge-sale position-absolute">NEW</span>
                            </div>
                            <div class="p-3">
                                <h5 class="mb-1">Smart Home Camera</h5>
                                <p class="text-muted small mb-2">1080p HD Security Camera with Night Vision</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold text-primary currency">999.99</span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-grid mt-3">
                                    <button class="btn btn-primary btn-sm add-to-cart" data-id="3" data-name="Smart Home Camera" data-price="999.99" data-image="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"><i class="fas fa-cart-plus me-1"></i> Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 4 -->
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1585155770447-2f66e2a397b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" class="product-img w-100" alt="Bluetooth Speaker">
                            </div>
                            <div class="p-3">
                                <h5 class="mb-1">Bluetooth Speaker</h5>
                                <p class="text-muted small mb-2">360° Surround Sound Portable Speaker</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold text-primary currency">699.99</span>
                                        <span class="text-muted text-decoration-line-through ms-2 currency">899.99</span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-grid mt-3">
                                    <button class="btn btn-primary btn-sm add-to-cart" data-id="4" data-name="Bluetooth Speaker" data-price="699.99" data-image="https://images.unsplash.com/photo-1585155770447-2f66e2a397b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"><i class="fas fa-cart-plus me-1"></i> Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5">
                    <a href="#" class="btn btn-outline-primary" data-page="products"><i class="fas fa-store me-2"></i> View All Products</a>
                </div>
            </div>
        </section>
    </div>

    <!-- Products Page -->
    <div id="products" class="page">
        <section class="py-5">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title mb-0">All Products</h2>
                    <div class="d-flex gap-2">
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i> Filter by Category
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Electronics</a></li>
                                <li><a class="dropdown-item" href="#">Home & Kitchen</a></li>
                                <li><a class="dropdown-item" href="#">Fashion</a></li>
                                <li><a class="dropdown-item" href="#">Books</a></li>
                                <li><a class="dropdown-item" href="#">Toys</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-sort me-1"></i> Sort by
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Price: Low to High</a></li>
                                <li><a class="dropdown-item" href="#">Price: High to Low</a></li>
                                <li><a class="dropdown-item" href="#">Newest First</a></li>
                                <li><a class="dropdown-item" href="#">Top Rated</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="row g-4">
                    <!-- Product 1 -->
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" class="product-img w-100" alt="Smart Watch">
                                <span class="badge badge-sale position-absolute">SALE</span>
                            </div>
                            <div class="p-3">
                                <h5 class="mb-1">Smart Watch Pro</h5>
                                <p class="text-muted small mb-2">Fitness Tracker with Heart Rate Monitor</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold text-primary currency">1,999.99</span>
                                        <span class="text-muted text-decoration-line-through ms-2 currency">2,399.99</span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-grid mt-3">
                                    <button class="btn btn-primary btn-sm add-to-cart" data-id="1" data-name="Smart Watch Pro" data-price="1999.99" data-image="https://images.unsplash.com/photo-1546868871-7041f2a55e12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"><i class="fas fa-cart-plus me-1"></i> Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 2 -->
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" class="product-img w-100" alt="Wireless Headphones">
                            </div>
                            <div class="p-3">
                                <h5 class="mb-1">Wireless Headphones</h5>
                                <p class="text-muted small mb-2">Noise Cancelling Bluetooth Headset</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold text-primary currency">1,349.99</span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-grid mt-3">
                                    <button class="btn btn-primary btn-sm add-to-cart" data-id="2" data-name="Wireless Headphones" data-price="1349.99" data-image="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"><i class="fas fa-cart-plus me-1"></i> Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 3 -->
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" class="product-img w-100" alt="Smart Home Camera">
                                <span class="badge badge-sale position-absolute">NEW</span>
                            </div>
                            <div class="p-3">
                                <h5 class="mb-1">Smart Home Camera</h5>
                                <p class="text-muted small mb-2">1080p HD Security Camera with Night Vision</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold text-primary currency">999.99</span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-grid mt-3">
                                    <button class="btn btn-primary btn-sm add-to-cart" data-id="3" data-name="Smart Home Camera" data-price="999.99" data-image="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"><i class="fas fa-cart-plus me-1"></i> Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 4 -->
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1585155770447-2f66e2a397b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" class="product-img w-100" alt="Bluetooth Speaker">
                            </div>
                            <div class="p-3">
                                <h5 class="mb-1">Bluetooth Speaker</h5>
                                <p class="text-muted small mb-2">360° Surround Sound Portable Speaker</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold text-primary currency">699.99</span>
                                        <span class="text-muted text-decoration-line-through ms-2 currency">899.99</span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-grid mt-3">
                                    <button class="btn btn-primary btn-sm add-to-cart" data-id="4" data-name="Bluetooth Speaker" data-price="699.99" data-image="https://images.unsplash.com/photo-1585155770447-2f66e2a397b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"><i class="fas fa-cart-plus me-1"></i> Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 5 -->
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" class="product-img w-100" alt="Book">
                                <span class="badge badge-sale position-absolute">NEW</span>
                            </div>
                            <div class="p-3">
                                <h5 class="mb-1">Novel: The Great Adventure</h5>
                                <p class="text-muted small mb-2">Bestselling fiction novel</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold text-primary currency">249.99</span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-grid mt-3">
                                    <button class="btn btn-primary btn-sm add-to-cart" data-id="5" data-name="Novel: The Great Adventure" data-price="249.99" data-image="https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"><i class="fas fa-cart-plus me-1"></i> Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 6 -->
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" class="product-img w-100" alt="Camera">
                            </div>
                            <div class="p-3">
                                <h5 class="mb-1">DSLR Camera</h5>
                                <p class="text-muted small mb-2">Professional 24MP Camera</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold text-primary currency">8,499.99</span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-grid mt-3">
                                    <button class="btn btn-primary btn-sm add-to-cart" data-id="6" data-name="DSLR Camera" data-price="8499.99" data-image="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"><i class="fas fa-cart-plus me-1"></i> Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 7 -->
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" class="product-img w-100" alt="Gaming Console">
                                <span class="badge badge-sale position-absolute">SALE</span>
                            </div>
                            <div class="p-3">
                                <h5 class="mb-1">Gaming Console</h5>
                                <p class="text-muted small mb-2">Next-gen gaming experience</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold text-primary currency">6,999.99</span>
                                        <span class="text-muted text-decoration-line-through ms-2 currency">7,499.99</span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-grid mt-3">
                                    <button class="btn btn-primary btn-sm add-to-cart" data-id="7" data-name="Gaming Console" data-price="6999.99" data-image="https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"><i class="fas fa-cart-plus me-1"></i> Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 8 -->
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1541807084-5c52b6b3adef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" class="product-img w-100" alt="Laptop">
                            </div>
                            <div class="p-3">
                                <h5 class="mb-1">Ultrabook Laptop</h5>
                                <p class="text-muted small mb-2">Thin and light 14" laptop</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold text-primary currency">14,999.99</span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-grid mt-3">
                                    <button class="btn btn-primary btn-sm add-to-cart" data-id="8" data-name="Ultrabook Laptop" data-price="14999.99" data-image="https://images.unsplash.com/photo-1541807084-5c52b6b3adef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"><i class="fas fa-cart-plus me-1"></i> Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Pagination -->
                <nav class="mt-5">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>
    </div>

    <!-- Cart Page -->
    <div id="cart" class="page">
        <section class="py-5">
            <div class="container">
                <h2 class="section-title">Your Shopping Cart</h2>
                
                <div id="cart-empty" class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                    <h3 class="mb-3">Your cart is empty</h3>
                    <p class="text-muted mb-4">Browse our products and add items to your cart</p>
                    <a href="#" class="btn btn-primary" data-page="products"><i class="fas fa-shopping-bag me-2"></i> Shop Now</a>
                </div>
                
                <div id="cart-items-container" class="d-none">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card mb-4">
                                <div class="card-body p-4">
                                    <div id="cart-items">
                                        <!-- Cart items will be loaded here by JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <div class="card-body p-4">
                                    <h5 class="mb-4">Order Summary</h5>
                                    
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Subtotal</span>
                                        <span id="cart-subtotal" class="currency">0.00</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Shipping</span>
                                        <span class="currency">99.00</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Tax</span>
                                        <span id="cart-tax" class="currency">0.00</span>
                                    </div>
                                    
                                    <hr class="my-4">
                                    
                                    <div class="d-flex justify-content-between mb-4">
                                        <h5>Total</h5>
                                        <h5 id="cart-total" class="currency">0.00</h5>
                                    </div>
                                    
                                    <button class="btn btn-primary btn-lg w-100">Proceed to Checkout</button>
                                    <a href="#" class="btn btn-outline-primary btn-lg w-100 mt-3" data-page="products">
                                        <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="py-5 bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h4 class="mb-4"><i class="fas fa-shopping-bag me-2"></i>ShopSphere</h4>
                    <p>Your trusted e-commerce platform for buying and selling quality products with secure transactions and fast delivery.</p>
                    <div class="d-flex mt-4">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <h5 class="mb-4">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none" data-page="home">Home</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none" data-page="products">Products</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Categories</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Sell</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <h5 class="mb-4">Customer</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none" data-page="cart">My Cart</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Orders</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Wishlist</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Tracking</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="mb-4">Newsletter</h5>
                    <p>Subscribe to our newsletter for the latest updates and offers.</p>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Your email address">
                        <button class="btn btn-primary">Subscribe</button>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="text-center">
                <p class="mb-0">&copy; 2025 ShopSphere. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize cart from localStorage
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            // Page navigation
            $('[data-page]').on('click', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                
                // Update active nav link
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
                
                // Show the selected page
                $('.page').removeClass('active');
                $('#' + page).addClass('active');
                
                // If navigating to cart, update cart display
                if (page === 'cart') {
                    updateCartDisplay();
                }
            });
            
            // Add to cart functionality
            $('.add-to-cart').on('click', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const price = parseFloat($(this).data('price'));
                const image = $(this).data('image');
                
                // Check if product already in cart
                const existingItem = cart.find(item => item.id === id);
                
                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    cart.push({
                        id,
                        name,
                        price,
                        image,
                        quantity: 1
                    });
                }
                
                // Save to localStorage
                localStorage.setItem('cart', JSON.stringify(cart));
                
                // Update cart badge
                updateCartBadge();
                
                // Show success message
                showToast('Item added to cart!');
            });
            
            // Update cart badge
            function updateCartBadge() {
                const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
                $('.cart-badge').text(totalItems);
            }
            
            // Show toast notification
            function showToast(message) {
                // Remove existing toasts
                $('.toast').remove();
                
                // Create toast
                const toast = $(`
                    <div class="toast align-items-center text-white bg-success border-0 position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="fas fa-check-circle me-2"></i> ${message}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                `);
                
                // Add to body and show
                $('body').append(toast);
                const toastElement = new bootstrap.Toast(toast[0], { delay: 2000 });
                toastElement.show();
            }
            
            // Update cart display
            function updateCartDisplay() {
                if (cart.length === 0) {
                    $('#cart-empty').removeClass('d-none');
                    $('#cart-items-container').addClass('d-none');
                    return;
                }
                
                $('#cart-empty').addClass('d-none');
                $('#cart-items-container').removeClass('d-none');
                
                // Clear existing items
                $('#cart-items').empty();
                
                // Add cart items
                let subtotal = 0;
                
                cart.forEach(item => {
                    const total = item.price * item.quantity;
                    subtotal += total;
                    
                    const cartItem = $(`
                        <div class="cart-item row mb-4 pb-4 border-bottom">
                            <div class="col-md-3 col-4">
                                <img src="${item.image}" class="img-fluid rounded cart-item-image" alt="${item.name}">
                            </div>
                            <div class="col-md-5 col-8">
                                <div>
                                    <h6 class="mb-1">${item.name}</h6>
                                    <p class="mb-0">R${item.price.toFixed(2)}</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-12 mt-3 mt-md-0">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <button class="quantity-btn decrease-quantity" data-id="${item.id}">-</button>
                                        <input type="number" class="quantity-input mx-2" value="${item.quantity}" min="1" data-id="${item.id}">
                                        <button class="quantity-btn increase-quantity" data-id="${item.id}">+</button>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <h6 class="mb-0 me-3">R${total.toFixed(2)}</h6>
                                        <i class="fas fa-trash text-muted remove-item" data-id="${item.id}"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                    
                    $('#cart-items').append(cartItem);
                });
                
                // Calculate totals
                const tax = subtotal * 0.15; // 15% tax
                const shipping = 99.00;
                const total = subtotal + tax + shipping;
                
                // Update totals
                $('#cart-subtotal').text(subtotal.toFixed(2));
                $('#cart-tax').text(tax.toFixed(2));
                $('#cart-total').text(total.toFixed(2));
                
                // Attach event handlers to cart controls
                $('.decrease-quantity').on('click', function() {
                    const id = $(this).data('id');
                    const item = cart.find(item => item.id === id);
                    
                    if (item.quantity > 1) {
                        item.quantity--;
                        updateCartDisplay();
                        localStorage.setItem('cart', JSON.stringify(cart));
                        updateCartBadge();
                    }
                });
                
                $('.increase-quantity').on('click', function() {
                    const id = $(this).data('id');
                    const item = cart.find(item => item.id === id);
                    
                    item.quantity++;
                    updateCartDisplay();
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartBadge();
                });
                
                $('.quantity-input').on('change', function() {
                    const id = $(this).data('id');
                    const quantity = parseInt($(this).val());
                    const item = cart.find(item => item.id === id);
                    
                    if (quantity > 0) {
                        item.quantity = quantity;
                        updateCartDisplay();
                        localStorage.setItem('cart', JSON.stringify(cart));
                        updateCartBadge();
                    } else {
                        $(this).val(item.quantity);
                    }
                });
                
                $('.remove-item').on('click', function() {
                    const id = $(this).data('id');
                    cart = cart.filter(item => item.id !== id);
                    updateCartDisplay();
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartBadge();
                    showToast('Item removed from cart');
                });
            }
            
            // Initialize cart badge
            updateCartBadge();
            
            // Add animation to dashboard cards on scroll
            const dashboardCards = document.querySelectorAll('.dashboard-card');
            
            const animateOnScroll = () => {
                dashboardCards.forEach(card => {
                    const cardPosition = card.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 1.3;
                    
                    if(cardPosition < screenPosition) {
                        card.style.opacity = 1;
                        card.style.transform = 'translateY(0)';
                    }
                });
            };
            
            // Set initial state for animation
            dashboardCards.forEach(card => {
                card.style.opacity = 0;
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            });
            
            window.addEventListener('scroll', animateOnScroll);
            animateOnScroll(); // Initialize on page load
            
            // Product card animation
            $('.product-card').hover(
                function() {
                    $(this).css('transform', 'translateY(-10px)');
                },
                function() {
                    $(this).css('transform', 'translateY(0)');
                }
            );
        });
    </script>
</body>
</html>

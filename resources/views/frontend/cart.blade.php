<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>متجر إلكتروني عصري</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        /* Modern Shopping Cart Styling with !important */
        :root {
            --primary-color: #3a7bd5 !important;
            --primary-light: #4e8be6 !important;
            --text-color: #333 !important;
            --border-color: #eaeaea !important;
            --shadow: 0 2px 15px rgba(0, 0, 0, 0.08) !important;
            --radius: 8px !important;
        }

        body {
            font-family: 'Tajawal', 'Cairo', sans-serif !important;
            direction: rtl !important;
            background-color: #f9fafc !important;
            color: var(--text-color) !important;
        }

        .cart-container {
            max-width: 900px !important;
            margin: 100px auto !important;
            padding: 30px !important;
            background-color: #fff !important;
            border-radius: var(--radius) !important;
            box-shadow: var(--shadow) !important;
        }

        .cart-container h2 {
            color: var(--text-color) !important;
            font-size: 24px !important;
            font-weight: 700 !important;
            margin-bottom: 25px !important;
            padding-bottom: 15px !important;
            border-bottom: 1px solid var(--border-color) !important;
            text-align: right !important;
        }

        .cart-items {
            margin-bottom: 30px !important;
        }

        .cart-item {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 20px 0 !important;
            border-bottom: 1px solid var(--border-color) !important;
        }

        .product-info {
            display: flex !important;
            align-items: center !important;
            flex: 1 !important;
        }

        .product-info img {
            width: 80px !important;
            height: 80px !important;
            object-fit: cover !important;
            border-radius: var(--radius) !important;
            margin-left: 20px !important;
            border: 1px solid var(--border-color) !important;
        }

        .product-info h4 {
            font-size: 16px !important;
            font-weight: 600 !important;
            margin: 0 0 8px 0 !important;
        }

        .product-info p {
            font-size: 14px !important;
            color: #666 !important;
            margin: 0 !important;
        }

        .remove-item button {
            background-color: transparent !important;
            color: #e74c3c !important;
            border: 1px solid #e74c3c !important;
            border-radius: var(--radius) !important;
            padding: 8px 15px !important;
            font-size: 14px !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
        }

        .remove-item button:hover {
            background-color: #e74c3c !important;
            color: white !important;
        }

        .cart-summary {
            background-color: var(--secondary-color);
            border-radius: var(--radius) !important;
            padding: 20px !important;
            text-align: center !important;
        }

        .cart-summary h3 {
            font-size: 18px !important;
            font-weight: 600 !important;
            margin-bottom: 20px !important;
        }

        .btn {
            display: inline-block !important;
            background-color: var(--primary-color) !important;
            color: white !important;
            padding: 12px 30px !important;
            border-radius: var(--radius) !important;
            text-decoration: none !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            transition: all 0.3s ease !important;
        }

        .btn:hover {
            background-color: var(--primary-light) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
        }

        /* Empty cart message */
        .cart-container>p {
            text-align: center !important;
            padding: 30px 0 !important;
            color: #888 !important;
            font-size: 16px !important;
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .cart-container {
                padding: 20px !important;
                margin: 20px !important;
            }

            .product-info {
                flex-direction: column !important;
                align-items: flex-start !important;
                text-align: right !important;
            }

            .product-info img {
                margin-bottom: 10px !important;
                margin-left: 0 !important;
            }

            .cart-item {
                flex-direction: column !important;
                align-items: flex-start !important;
            }

            .remove-item {
                margin-top: 15px !important;
                align-self: flex-end !important;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="nav-container">
            <div class="logo"><a href="{{route('home')}}" class="no_d">WireMart</a></div>
            <div class="nav-links">
                <a href="#">الرئيسية</a>
                <a href="#">المنتجات</a>
                <a href="#">العروض</a>
                <a href="#">عن المتجر</a>
                <a href="#">تواصل معنا</a>
            </div>
            <div class="nav-icons">
                <div class="nav-icon">
                    <i class="fas fa-search"></i>
                </div>

                @auth
                <div class="nav-icon">
                    <a href="{{route('admin')}}">
                        <i class="fas fa-user"></i>
                    </a>
                </div>
                <div class="nav-icon cart-icon" id="cartIcon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count">0</span>
                </div>
                @endauth
                @guest <!-- إذا كان المستخدم زائرًا (غير مسجل) -->
                <!-- زر تسجيل الدخول -->
                <a href="{{ route('login') }}" class="nav-icon">
                    <i class="fas fa-sign-in-alt"></i>Login
                </a>
                <!-- زر إنشاء حساب -->
                <a href="{{ route('register') }}" class="nav-icon">
                    <i class="fas fa-user-plus"></i>Register
                </a>
                @endguest
            </div>
        </div>
    </header>


    <div class="cart-container">
        <h2>سلة التسوق</h2>

        @if($cartItems->isEmpty())
        <p>سلة التسوق فارغة</p>
        @else
        <div class="cart-items">
            @foreach($cartItems as $cartItem)
            <div class="cart-item">
                <div class="product-info">
                    <img src="{{ $cartItem->product->image_url }}" alt="{{ $cartItem->product->product_name }}">
                    <h4>{{ $cartItem->product->product_name }}</h4>
                    <p>{{ $cartItem->quantity }} × {{ $cartItem->product->regular_price }} ريال</p>
                </div>
                <div class="remove-item">
                    <form action="{{ route('cart.destroy', $cartItem->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">إزالة</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="cart-summary">
            <h3>إجمالي السلة:
                @php
                $total = 0;
                foreach($cartItems as $cartItem) {
                $total += $cartItem->product->regular_price * $cartItem->quantity;
                }
                @endphp
                {{ $total }} ريال
            </h3>
            <a href="{{ route('checkout') }}" class="btn">إتمام الدفع</a>
        </div>
        @endif
    </div>
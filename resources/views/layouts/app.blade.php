<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    @livewireStyles
</head>

<body>
    <header>
        <div class="nav-container">
            <div class="nav-icons">
                @auth
                <livewire:cart-counter />
                <div class="nav-icon">
                    <a href="{{route('customer.history')}}">
                        <i class="fas fa-user"></i>
                    </a>
                </div>
                @endauth
                @guest
                <a href="{{ route('login') }}" class="nav-icon">
                    <i class="fas fa-sign-in-alt"></i>@lang('messages.login')
                </a>
                <a href="{{ route('register') }}" class="nav-icon">
                    <i class="fas fa-user-plus"></i>@lang('messages.register')
                </a>
                @endguest

                <div class="language-dropdown">
                    <button class="language-toggle">
                        <i class="fas fa-globe"></i>
                        <span>@lang('messages.lang')</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="language-options">
                        <li data-lang="ar"> <a href="locale/ar">العربية</a> </li>
                        <li data-lang="en"><a href="locale/en">English</a></li>
                        <li data-lang="fr"><a href="locale/fr">Français</a></li>
                    </ul>
                </div>

            </div>
            <div class="nav-links">
                <a href="{{route('termsshop')}}">@lang('messages.terms')</a>
                <a href="{{ route('aboutshop') }}">@lang('messages.aboutShop')</a>
                <a href="{{ route('all.products') }}">@lang('messages.products')</a>
                <a href="{{ route('home') }}">@lang('messages.home')</a>
            </div>
            <div class="logo"><a href="{{route('home')}}" class="no_d">WireMart</a></div>

        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-top">
            <div class="footer-section">
                <h3 class="footer-title">@lang('messages.followUs')</h3>
                <p class="footer-desc">@lang('messages.followDescription')</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                </div>
                <div class="app-downloads" style="margin-top: 20px;">
                    <p style="margin-bottom: 10px; color: #bbb;">@lang('messages.downloadApp')</p>
                    <div style="display: flex; gap: 10px;">
                        <a href="#" class="app-link">
                            <i class="fab fa-apple"></i> App Store
                        </a>
                        <a href="#" class="app-link">
                            <i class="fab fa-google-play"></i> Google Play
                        </a>
                    </div>
                </div>
            </div>

            <div class="footer-section">
                <h3 class="footer-title">@lang('messages.service')</h3>
                <ul class="footer-links">
                    <li><a href="#">@lang('messages.p-Policy')</a></li>
                    <li><a href="#">@lang('messages.termsOfUse')</a></li>
                    <li><a href="#">@lang('messages.r-Policy')</a></li>
                    <li><a href="#">@lang('messages.faqs')</a></li>
                    <li><a href="#">@lang('messages.paymentMethods')</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3 class="footer-title">@lang('messages.contentUs')</h3>
                <div class="contact-info">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>King Fahd Street, Riyadh, Saudi Arabia</span>
                </div>
                <div class="contact-info">
                    <i class="fas fa-phone-alt"></i>
                    <span>+966 12 345 6789</span>
                </div>
                <div class="contact-info">
                    <i class="fas fa-envelope"></i>
                    <span>info@yourstoremail.com</span>
                </div>
                <div class="contact-info">
                    <i class="fas fa-clock"></i>
                    <span>@lang('messages.workingHours'): 9 AM - 10 PM</span>
                </div>
                <div class="contact-info">
                    <i class="fas fa-headset"></i>
                    <span>@lang('messages.service'): 7 days a week</span>
                </div>
                <div class="newsletter-form">
                    <input type="email" class="newsletter-input" placeholder="@lang('messages.enterEmail')">
                    <button class="newsletter-btn">@lang('messages.sub')</button>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>@lang('messages.allRights')</p>
        </div>
    </footer>




    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <button class="close-cart" id="closeCart">
                <i class="fas fa-times"></i>
            </button>
            <h3> @lang('messages.shoppingCart') </h3>
        </div>
        <div class="cart-items">
            <livewire:cart-items />
        </div>
        <div class="cart-footer">
            <livewire:cart-total />
            <button class="continue-shopping" id="continueShopping">@lang('messages.continueShopping')</button>
        </div>
    </div>
    <div class="cart-overlay" id="cartOverlay"></div>
    <div class="cart-sidebar" id="cartSidebar"></div>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            // تهيئة Alpine هنا إذا لزم الأمر
        });
    </script>
    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // العناصر الرئيسية
            const cartIcon = document.getElementById('cartIcon');
            const cartSidebar = document.getElementById('cartSidebar');
            const closeCart = document.getElementById('closeCart');
            const overlay = document.getElementById('cartOverlay');
            const continueShopping = document.getElementById('continueShopping');

            // دالة لفتح السلة
            const openCart = () => {
                cartSidebar.classList.add('active');
                overlay.style.display = 'block';
                Livewire.emit('cartUpdated');
            };

            // دالة لإغلاق السلة
            const closeCartFunction = () => {
                cartSidebar.classList.remove('active');
                overlay.style.display = 'none';
            };

            // Event Listeners
            cartIcon.addEventListener('click', openCart);
            closeCart.addEventListener('click', closeCartFunction);
            overlay.addEventListener('click', closeCartFunction);
            continueShopping.addEventListener('click', closeCartFunction);

            // تحديث عداد السلة
            Livewire.on('cartUpdated', () => {
                fetch('{{ route("cart.count") }}')
                    .then(response => response.json())
                    .then(data => {
                        const cartCount = document.querySelector('.cart-count');
                        if (cartCount) {
                            cartCount.textContent = data.count;
                        }
                    });
            });

        });
        document.addEventListener('livewire:init', () => {
            // حل مشكلة الـ Snapshot
            Livewire.hook('commit.prepare', ({
                component
            }) => {
                if (!component.snapshot) {
                    component.snapshot = JSON.parse(JSON.stringify(component));
                }
            });

            // إعادة المسح عند الأخطاء
            Livewire.hook('fail', () => {
                setTimeout(() => Livewire.rescan(), 300);
            });
        });

        // حل مشكلة الأزرار المخفية
        document.addEventListener('DOMContentLoaded', () => {
            Livewire.on('productsUpdated', () => {
                document.querySelectorAll('.product-actions').forEach(el => {
                    el.style.display = 'flex';
                });
            });
        });
    </script>

    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            const languageDropdown = document.querySelector('.language-dropdown');
            const languageToggle = document.querySelector('.language-toggle');
            
            if (languageToggle) {
                languageToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    languageDropdown.classList.toggle('active');
                });
            }
            

            document.addEventListener('click', function() {
                languageDropdown.classList.remove('active');
            });
            

            if (languageDropdown) {
                languageDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
            

            const languageOptions = document.querySelectorAll('.language-options li');
            languageOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const selectedLang = this.getAttribute('data-lang');
                    const langText = this.textContent;
                    

                    document.querySelector('.language-toggle span').textContent = langText;
                    

                    console.log('Language changed to:', selectedLang);
 
                    
                    languageDropdown.classList.remove('active');
                });
            });
        });
    </script>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Toastify({
                text: "{{ session('success') }}",
                duration: 5000,
                gravity: "top",
                position: "right",
                backgroundColor: "#8BC34A",
                close: true
            }).showToast();
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Toastify({
                text: "{{ session('error') }}",
                duration: 5000,
                gravity: "top",
                position: "right",
                backgroundColor: "#FF6347",
                close: true
            }).showToast();
        });
    </script>
    @endif

    @if($errors->any())
    @foreach($errors->all() as $error)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Toastify({
                text: "{{ $error }}",
                duration: 5000,
                gravity: "bottom",
                position: "right",
                backgroundColor: "#FF6347",
                close: true
            }).showToast();
        });
    </script>
    @endforeach
    @endif
</body>

</html>
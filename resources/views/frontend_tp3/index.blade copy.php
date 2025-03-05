<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giao diện Tết</title>
    <link rel="stylesheet" href="{{asset('/frontend_tp3/css/style.css')}}">
</head>
<body>
  {{-- <header class="header">
      <div class="logo">
          <img src="logo.png" alt="Logo" />
      </div>
      <div class="search-bar">
          <input type="text" placeholder="Bạn tìm gì..." />
          <button>Tìm kiếm</button>
      </div>
      <div class="actions">
          <a href="#">Đăng nhập</a>
          <a href="#">Giỏ hàng</a>
          <a href="#">Hồ Chí Minh</a>
      </div>
  </header> --}}
  {{-- <header class="header">
    <div class="logo">
        <img src="logo.png" alt="Logo" />
    </div>
    <div class="actions">
        <a href="#">
            <span>📍 Hồ Chí Minh</span>
        </a>
        <a href="#">
            <span>👤 Đăng nhập</span>
        </a>
    </div>
    <div class="search-bar">
        <span class="menu-icon">☰</span>
        <input type="text" placeholder="Bạn tìm gì..." />
        <span class="cart-icon">🛒</span>
    </div>
</header> --}}

<header class="header">
  <div class="top-bar">
      <div class="logo">
          <img src="logo.png" alt="Logo">
          <span class="year">2025</span>
      </div>
      <div class="search-bar">
          <input type="text" placeholder="Bạn tìm gì...">
      </div>
      <div class="actions">
          <a href="#" class="login">Đăng nhập</a>
          <a href="#" class="cart">🛒 Giỏ hàng</a>
          <a href="#" class="location">📍 Hồ Chí Minh</a>
      </div>
    </div>
  </div>
  <nav class="category-menu">
      <a href="#">📱 Điện thoại</a>
      <a href="#">💻 Laptop</a>
      <a href="#">🎧 Phụ kiện</a>
      <a href="#">⌚ Smartwatch</a>
      <a href="#">⏱ Đồng hồ</a>
      <a href="#">📱 Tablet</a>
      <a href="#">🔄 Máy cũ, Thu cũ</a>
      <a href="#">🖥️ PC, Máy in</a>
      <a href="#">📄 Sim, Thẻ cào</a>
      <a href="#">🛠️ Dịch vụ tiện ích</a>
  </nav>
</header>
  <main class="main-content">
      <div class="banner-left">
          <img src="{{asset('/frontend_tp3/img/header-left.png')}}" alt="Tết Đậm Nét" />
      </div>
      <div class="container">
          <section class="product-list">
              <div class="product-item">
                  <img src="product1.jpg" alt="OPPO Reno12 F">
                  <h3>OPPO Reno12 F 5G 12GB/256GB</h3>
                  <p class="price">
                      <span class="discount-price">8.990.000đ</span>
                      <span class="original-price">9.990.000đ</span>
                  </p>
                  <p class="stock">Còn 10/10 suất</p>
                  <button class="buy-btn">Mua ngay</button>
              </div>
              <!-- Lặp lại các sản phẩm khác -->
          </section>
      </div>
      <div class="banner-right">
          <img src="{{asset('/frontend_tp3/img/header-right.png')}}" alt="Trang trí Tết" />
      </div>
  </main>
</body>
</html>
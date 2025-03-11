@extends('frontend_tp3.layouts.master')
@section('topcss')
@endsection
@section('content')
    @include('frontend_tp3.layouts.modpro')
    @include('frontend_tp3.layouts.mod8hotpro')
    @include('frontend_tp3.layouts.mod_4_blog')
    @include('frontend_tp3.layouts.mod_tags')
@endsection
@section('footscript')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const categoryButtons = document.querySelectorAll(".news-category");
            const newsItems = document.querySelectorAll(".news-item");

            // Hàm để kích hoạt danh mục
            const activateCategory = () => {
                // Tìm nút danh mục đang active
                const activeButton = document.querySelector(".news-category.active");
                if (activeButton) {
                    activeButton.click(); // Gọi hàm click để kích hoạt
                } else {
                    // Nếu không có nút active nào, mặc định kích hoạt nút đầu tiên
                    categoryButtons[0].classList.add("active");
                    categoryButtons[0].click();
                }
            };

            // Xử lý sự kiện khi nhấn vào nút danh mục
            categoryButtons.forEach((button) => {
                button.addEventListener("click", () => {
                    // Xóa class 'active' khỏi tất cả các nút
                    categoryButtons.forEach((btn) => btn.classList.remove("active"));

                    // Thêm class 'active' cho nút được nhấn
                    button.classList.add("active");

                    // Lấy danh mục từ nút được nhấn
                    const selectedCategory = button.getAttribute("data-category");

                    // Ẩn tất cả bài viết
                    newsItems.forEach((item) => {
                        if (item.getAttribute("data-category") === selectedCategory) {
                            item.style.display =
                            "block"; // Hiển thị bài viết thuộc danh mục
                        } else {
                            item.style.display = "none"; // Ẩn bài viết không thuộc danh mục
                        }
                    });
                });
            });

            // Kích hoạt danh mục khi tải trang
            activateCategory();
        });
    </script>
@endsection

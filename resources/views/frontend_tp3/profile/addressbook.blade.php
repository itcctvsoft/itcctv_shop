
@extends('frontend_tp3.layouts.master')
@section('topcss')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
@include('frontend_tp3.layouts.breadcrumb')
 

<div class="address-container">
    <aside class="account-menu">
        <ul>
            <li class="menu-item  ">
                <a href="#">
                      Thông tin tài khoản
                </a>
            </li>
            <li class="menu-item active">
                <a href="{{route('front.profile.addressbook')}}">
                     Địa chỉ mua hàng
                </a>
            </li>
            
            <li class="menu-item">
                <a href="#">
                    <i class="icon-cart"></i> Giỏ hàng
                </a>
            </li>
            <li class="menu-item">
                <a href="#">
                    <i class="icon-history"></i> Lịch sử mua hàng
                </a>
            </li>
            <li class="menu-item">
                <a href="#">
                    <i class="icon-heart"></i> Danh sách yêu thích
                </a>
            </li>
        </ul>
    </aside>

    <div class="address-details">
        <h2>Danh sách địa chỉ</h2>
        <!-- Form thêm/sửa địa chỉ -->
        <form id="addressForm" action="{{route('front.address.save')}}" method="post" class="address-form">
            @csrf
            <input type="hidden" id="editIndex" value="-1" />
            <div class="form-group">
                <label for="name">Tên:</label>
                <input type="text" id="name" name="full_name" placeholder="Nhập tên" required />
            </div>
            <div class="form-group">
                <label for="phone">Điện thoại:</label>
                <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại" required />
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ:</label>
                <textarea id="address" name="address" placeholder="Nhập địa chỉ" required></textarea>
            </div>
            <button type="submit" class="btn-submit">Lưu</button>
        </form>

        <!-- Danh sách địa chỉ -->
        <h2>Danh sách địa chỉ</h2>
        <ul class="address-list">
            @foreach ($addressbooks as $adbook)
            <li class="address-item">
                <div class="address-details">
                    <h4>{{ htmlspecialchars($adbook->full_name) }}</h4>
                    <p>📞 {{ htmlspecialchars($adbook->phone) }}</p>
                    <p>🏠 {{ htmlspecialchars($adbook->address) }}</p>
                </div>
                <div class="address-actions">
                    <button class="action-btn edit" 
                            data-id="{{ $adbook->id }}"
                            data-name="{{ $adbook->full_name }}"
                            data-phone="{{ $adbook->phone }}"
                            data-address="{{ $adbook->address }}"
                            onclick="editAddress(this)">
                        Sửa
                    </button>
                    <button class="action-btn delete" 
                            data-id="{{ $adbook->id }}"
                            onclick="deleteAddress(this)">
                        Xóa
                    </button>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>


<!-- Modal chỉnh sửa -->
<!-- Modal chỉnh sửa -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h3>Chỉnh sửa địa chỉ</h3>
        <form id="editAddressForm">
            <input type="hidden" id="editAddressId" />
            <label for="editName">Tên:</label>
            <input type="text" id="editName" class="form-control" required />

            <label for="editPhone">Điện thoại:</label>
            <input type="text" id="editPhone" class="form-control" required />

            <label for="editAddress">Địa chỉ:</label>
            <textarea id="editAddress" class="form-control" rows="3" required></textarea>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="cancelEdit">Hủy</button>
                <button type="submit" class="btn-save">Lưu</button>
            </div>
        </form>
    </div>
</div>




 
@endsection
@section('footscript')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const editModal = document.getElementById("editModal");
        const editAddressForm = document.getElementById("editAddressForm");
        const editAddressId = document.getElementById("editAddressId");
        const editName = document.getElementById("editName");
        const editPhone = document.getElementById("editPhone");
        const editAddress = document.getElementById("editAddress");

        // Hiển thị modal chỉnh sửa
        window.editAddress = function (button) {
            const id = button.getAttribute("data-id");
            const name = button.getAttribute("data-name");
            const phone = button.getAttribute("data-phone");
            const address = button.getAttribute("data-address");
            
            editAddressId.value = id;
            editName.value = name;
            editPhone.value = phone;
            editAddress.value = address;
            editModal.style.display = "flex"; 
            // editModal.style.display = "block";
        };

        // Lưu thay đổi
        editAddressForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const updatedId = editAddressId.value;
            const updatedName = editName.value;
            const updatedPhone = editPhone.value;
            const updatedAddress = editAddress.value;

            // Gửi thông tin cập nhật lên server qua AJAX
            fetch(`/update-address/${updatedId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({
                    full_name: updatedName,
                    phone: updatedPhone,
                    address: updatedAddress
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Cập nhật địa chỉ thành công!");
                    location.reload(); // Reload trang sau khi cập nhật
                } else {
                    alert("Đã xảy ra lỗi khi cập nhật địa chỉ.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });

            editModal.style.display = "none";
        });

        // Đóng modal khi nhấn "Hủy"
        document.getElementById("cancelEdit").addEventListener("click", function () {
            editModal.style.display = "none";
        });

        // Đóng modal khi nhấn bên ngoài modal
        window.addEventListener("click", function (e) {
            if (e.target === editModal) {
                editModal.style.display = "none";
            }
        });

        // Xóa địa chỉ
        window.deleteAddress = function (button) {
            const id = button.getAttribute("data-id");
            if (confirm("Bạn có chắc chắn muốn xóa địa chỉ này?")) {
                fetch(`/delete-address/${id}`, {
                    method: "GET",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Xóa địa chỉ thành công!");
                        location.reload(); // Reload trang sau khi xóa
                    } else {
                        alert(data.msg);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                });
            }
        };
    });



    </script>
@endsection

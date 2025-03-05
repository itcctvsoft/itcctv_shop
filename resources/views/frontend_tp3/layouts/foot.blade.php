 
 <div class="notification" id="notification">
    <span class="notification-icon">✔️</span>
    <span class="notification-text">Đã thêm số lượng 1</span>
</div>
  
  
  {{-- <script src="{{asset('frontend/assets_tp/js/plugins.js')}}"></script>
  <script src="{{asset('frontend/assets_tp/js/theme.js')}}"></script> --}}
  <script src="{{asset('frontend/assets_tp/js/jquery-3.3.1.min.js')}}"></script>
  {{-- <script src="{{asset('frontend/assets_tp/js/notify.min.js')}}"></script> --}}


  <script>
        function showNotification(message) {
            const notification = document.getElementById('notification');
            const notificationText = notification.querySelector('.notification-text');
            
            // Cập nhật nội dung thông báo
            notificationText.textContent = message;
            
            // Hiển thị thông báo
            notification.style.display = 'flex';

            // Ẩn thông báo sau 3 giây
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }

      


</script>
  <script>
    class Sanpham {
      constructor(id, quantity) {
          this.id = id;
          this.quantity = quantity;
      }
  
  }
       
      $('body').on('click','.ti-heart , #btn_add_to_wish' , function() {
            var data_send = new Sanpham($(this).attr("data-id"),0);
              console.log(data_send);
              const dataToSend = {
                  _token: "{{ csrf_token() }}",
                  product: data_send,
              };
              $.ajax({
                  url: "{{route('front.wishlist.add')}}" , // Replace with your actual server endpoint URL
                  method: "POST",
                  contentType: "application/json",
                  data: JSON.stringify(dataToSend),
                  success: function(response) {
                      var msg = response.msg;
                      showNotification(msg);
                  },
                  error: function(error) {
                  console.error("Error add to wishlist:", error);
                  }
              });
      });
      $('body').on('click','.ti-shopping-cart' , function() {
        
        var data_send = new Sanpham($(this).attr("data-id"),1);
        console.log(data_send);
        const dataToSend = {
            _token: "{{ csrf_token() }}",
            product: data_send,
        };
        $.ajax({
            url: "{{route('front.shopingcart.add')}}" , // Replace with your actual server endpoint URL
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(dataToSend),
            success: function(response) {
                var msg = response.msg;
                showNotification(msg);
            },
            error: function(error) {
            console.error("Error add to addtocart:", error);
            }
        });
      });

      $('body').on('click','#btn_add_to_cart' , function() {
        var pro_quantity = $('#pro_quantity').val();

        var data_send = new Sanpham($(this).attr("data-id"),pro_quantity);
        console.log(data_send);
        const dataToSend = {
            _token: "{{ csrf_token() }}",
            product: data_send,
        };
        $.ajax({
            url: "{{route('front.shopingcart.add')}}" , // Replace with your actual server endpoint URL
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(dataToSend),
            success: function(response) {
                var msg = response.msg;
                // add_notify(response.msg,response.status);
                // var return_pros = response.products;
                // //  console.log(return_pros);
                // //modify head shopingcart
                // var innerhtml = "";
                // var total = 0;
                // var dem = 0;
                // if(!return_pros)
                //     return;
                // $('#cart_qty_cls').html(return_pros.length);

                

                // while (dem < 10 && dem < return_pros.length)
                // {
                //    var pp = return_pros[dem];
                //     var imageurls = pp.photo.split(",");
                //     innerhtml += ' <div class="shopping-cart-item flex justify-between !mb-4"> <div class="flex flex-row">'
                //     +'<figure class="!rounded-[.4rem] !w-[7rem]"> <a href="/product/view/' +pp.slug+'"> <img class="!rounded-[.4rem]"   '
                //     +'    src="'+(imageurls.length >0? imageurls[0]:"")+'"/></a> </figure>  <div class="!w-full !ml-[1rem]">'
                //     +'<h3 class="post-title !text-[.8rem] !leading-[1.35] !mb-1"><a href= "/product/view/' +pp.slug+'" class="title_color">'
                //     +pp.title +'</a></h3><p class="price !text-[.7rem]"> <ins class="no-underline text-[#e2626b]"><span class="amount">'
                //     + Intl.NumberFormat().format(pp.price) +'đ</span></ins> x '+pp.quantity +'</p></div></div></div>';
                //     total += pp.price*pp.quantity;
                //     dem += 1;
                //     if(dem == 10 && return_pros.length > 10)
                //     {
                //         innerhtml += '<li>   <a href="#"> Xem thêm ...  </a>    </li>';
                         
                //     }
                // }
                // while (dem < return_pros.length)
                // {
                //     total +=  return_pros[dem].price*return_pros[dem].quantity;
                //     dem++;
                // }
                // var tong_quick_cart = Intl.NumberFormat().format(total) +' đ';
                // $('#head_shoping_cart').html(innerhtml);
                // $('#tong_quick_cart').html(tong_quick_cart);
                showNotification(msg);
            },
            error: function(error) {
            console.error("Error add to addtocart:", error);
            }
        });
      });


      $('#cartEffect').on('click', function () {
        var quantity = $('#quantity').val();
        if(quantity <= 0)
        {
            $('#quantity').val(1);
            quantity = 1;
        }
        var data_send = new Sanpham($(this).attr("data-id"),quantity);
        console.log(data_send);
        const dataToSend = {
            _token: "{{ csrf_token() }}",
            product: data_send,
        };
        $.ajax({
            url: "{{route('front.shopingcart.add')}}" , // Replace with your actual server endpoint URL
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(dataToSend),
            success: function(response) {
                var msg = response.msg;
                showNotification(msg);
            },
            error: function(error) {
            console.error("Error add to addtocart:", error);
            }
        });
    });
  </script>
   <script>
    document.querySelectorAll('.dropdown-toggle').forEach(item => {
      item.addEventListener('click', (e) => {
          e.preventDefault(); // Ngăn điều hướng mặc định
          const submenu = item.nextElementSibling;
          submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
      });
  });

      function toggleMenu() {
          const menu = document.querySelector('.menu');
          menu.classList.toggle('active');
      }
  </script>

 

  @yield('footscript')
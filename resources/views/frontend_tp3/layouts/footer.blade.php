<footer class="footer">
    <div class="footer-container">
        <div class="footer-top">
            <div class="footer-section">
                <div class="footer-title footer-mobile-title">
                    <h4>Thông tin công ty</h4>
                </div>

                <div class="footer-contant">
                    @if (isset($detail) && property_exists($detail, 'logo'))
                        <div class="footer-logo"><img src="{{ $detail->logo }}" alt=""></div>
                    @endif

                    @if (isset($detail) && property_exists($detail, 'company_name'))
                        <h3>{{ $detail->company_name }}</h3>
                    @endif

                    @if (isset($detail) && property_exists($detail, 'memory'))
                        <p>{{ $detail->memory }}</p>
                    @endif
                </div>
            </div>

            <div class="footer-section">
                <h4 class="widget-title text-white !mb-3">THÔNG TIN CHI TIẾT</h4>
                <ul class="contact-list">
                    @if (isset($detail) && property_exists($detail, 'address'))
                        <li><i class="fa fa-map-marker"></i> {{ $detail->address }}</li>
                    @endif

                    @if (isset($detail) && property_exists($detail, 'phone'))
                        <li><i class="fa fa-phone"></i> Điện thoại: {{ $detail->phone }}</li>
                    @endif

                    @if (isset($detail) && property_exists($detail, 'email'))
                        <li><i class="fa fa-envelope"></i> Email: {{ $detail->email }}</li>
                    @endif

                    @if (isset($detail) && property_exists($detail, 'mst'))
                        <li><i class="fa fa-book"></i> Mã số doanh nghiệp: {{ $detail->mst }}</li>
                    @endif

                    @if (isset($detail) && property_exists($detail, 'thoigiandk'))
                        <li><i class="fa fa-book"></i> {{ $detail->thoigiandk }}</li>
                    @endif

                    @if (isset($detail) && property_exists($detail, 'nguoilienhe'))
                        <li><i class="fa fa-book"></i> {{ $detail->nguoilienhe }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</footer>

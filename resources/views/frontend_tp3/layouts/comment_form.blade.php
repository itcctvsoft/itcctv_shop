<div class="section-comment">
    <h3 class="comment-title">Để lại ý kiến của bạn</h3>
    <form action="{{ route('front.comment.save') }}" method="post" class="comment-form">
        <?php 
            $full_name = "";
            $email = "";
            $user = auth()->user();
            if( $user)
            {
                $full_name = $user->full_name;
                $email = $user->email;
            }

        ?>
        @csrf
        {!! NoCaptcha::renderJs() !!}

        @if ($errors->has('g-recaptcha-response'))
            <p class="error-message">{{ $errors->first('g-recaptcha-response') }}</p>
        @endif

        <input type="hidden" name="url" value="{{ 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] }}" />

        <!-- Tên đầy đủ -->
        <div class="form-group">
            <label for="name">Tên đầy đủ</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $full_name }}" placeholder="Nhập tên của bạn*" required>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ $email }}" placeholder="Nhập email của bạn*" required>
        </div>

        <!-- Nội dung -->
        <div class="form-group">
            <label for="content">Nội dung</label>
            <textarea id="content" name="content" class="form-control" rows="4" placeholder="Nhập ý kiến của bạn*" required></textarea>
        </div>

        <!-- Captcha -->
        <div class="form-group captcha">
            {!! NoCaptcha::display() !!}
        </div>

        <!-- Nút gửi -->
        <div class="form-group">
            <button type="submit" class="btn btn-submit">Gửi</button>
        </div>
    </form>
</div>

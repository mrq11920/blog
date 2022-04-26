<x-guest-layout>
    <div class="main-wrapper account-wrapper">
        <div class="account-page">
            <div class="account-center">
                <div class="account-box">
                    <form action="{{ route('register') }}" method="POST" class="form-register">
                        @csrf
                        <!-- <input type="hidden" name="_token" value="xA3gslIaSFLwW146Kcg79oiuEACHpkOGaWj8EVYd"> -->
                        <div class="account-logo">
                            <a href="javascript:void(0)"><img src="http://lowendviet.sudobo.com/uploads/images/1649067937_818048241.jpeg" alt=""></a>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="text" autofocus="" class="form-control" name="email" value="">
                        </div>
                        <!-- <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="password" class="form-control" name="password" value="">
                        </div>
                        <div class="form-group text-left">
                            <input type="checkbox" class="form-check-input ml-0 mt-1" id="remember" name="remember">
                            <label class="form-check-label ml-4" for="remember">Ghi nhớ đăng nhập</label>
                        </div> -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary account-btn">Xác nhận</button>
                        </div>
                        
                        <!-- <div class="form-group text-center">
                            @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                Quên mật khẩu ?
                            </a>
                            @endif
                        </div> -->
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script>

    </script>
</x-guest-layout>
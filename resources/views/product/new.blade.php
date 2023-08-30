<html>
    <body>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
    <!-- header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
            <div class="container-fluid">
                <a class="navbar-brand ps-3" href="#">Step7</a>
                <!-- drop down -->
                <div class="collapse navbar-collapse d-flex flex-row-reverse  pe-3" id="navbarNavDarkDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><x-dropdown-link :href="route('profile.edit')" class="dropdown-item">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();" class="dropdown-item">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- <h1>新規作成</h1> -->
        <div class="m-auto w-25">
            <h3>新規登録画面</h3>
            <form class="border border-dark p-3" action="{{route('product.create')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" >

                <div class="d-flex mb-3 mt-3" style="height:30px;">
                    <p style="width:100px;">商品名:</p>
                    <input style="width:300px;" type="text" name="product_name"><br>
                </div>
                @if($errors->has('product_name'))
                    <li style="color:red;">{{$errors->first('product_name')}}</li>
                @endif

                <div class="d-flex mb-3" style="height:30px;">
                    <p style="width:100px;">価格:</p>
                    <input style="width:300px;" type="text" name="price"><br>
                </div>
                @if($errors->has('price'))
                    <li style="color:red;">{{$errors->first('price')}}</li>
                @endif

                <div class="d-flex mb-3" style="height:30px;">
                    <p style="width:100px;">在庫数:</p>
                    <input style="width:300px;" type="text" name="stock"><br>
                </div>
                @if($errors->has('stock'))
                    <li style="color:red;">{{$errors->first('stock')}}</li>
                @endif

                <div class="d-flex mb-3" style="height:30px;">
                    <p style="width:100px;">コメント:</p>
                    <input style="width:300px;" type="text" name="comment"><br>
                </div>
                @if($errors->has('comment'))
                    <li style="color:red;">{{$errors->first('comment')}}</li>
                @endif

                <div class="d-flex mb-3" style="height:30px;">
                    <p style="width:100px;">商品画像:</p>
                    <input type="file" name="file"><br>
                </div>

                <div class="d-flex mb-3" style="height:30px;">
                    <p style="width:100px;">会社名:</p>
                    <input style="width:300px;" type="text" name="company_name"><br>
                </div>
                @if($errors->has('company_name'))
                    <li style="color:red;">{{$errors->first('company_name')}}</li>
                @endif

                <!-- button -->
                <div class="mt-5 d-flex justify-content-end">
                    <input class="btn btn-danger me-3" type="submit" value="新規登録">
                    <a class="col col-lg-2 btn btn-primary" href="{{route('product.index')}}">戻る</a>
                </div>
            </form>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>
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

        <div class="m-auto" style="width:400px;">
            <h3>詳細画面</h3>
            <div>
                <ul class="border border-dark p-3">
                    <li class="ms-3" style="list-style:none;">
                        <div class="d-flex mb-3 mt-3" style="height:30px;">
                            <p style="width:100px;">ID:</p>
                            <div style="width:300px;">{{$product->id}}</div>
                        </div>
                        <div class="d-flex mb-3 mt-3" style="height:30px;">
                            <p style="width:100px;">商品名:</p>
                            <div style="width:300px;">{{$product->product_name}}</div>
                        </div>
                        <div class="d-flex mb-3 mt-3">
                            <p class="d-flex align-items-center" style="width:100px;">商品画像:</p>
                            <div style="width:300px;"><img style="max-wide:100px; max-height:100px;" src="{{ route('product.getfile',['id'=>$product->id]) }}"></div>
                        </div>
                        <div class="d-flex mb-3 mt-3" style="height:30px;">
                            <p style="width:100px;">メーカー:</p>
                            <div style="width:300px;">{{$product->company->company_name}}</div>
                        </div>
                        <div class="d-flex mb-3 mt-3" style="height:30px;">
                            <p style="width:100px;">価格:</p>
                            <div style="width:300px;">{{$product->price}}</div>
                        </div>
                        <div class="d-flex mb-3 mt-3" style="height:30px;">
                            <p style="width:100px;">在庫数:</p>
                            <div style="width:300px;">{{$product->stock}}</div>
                        </div>
                        <div class="d-flex mb-3 mt-3" style="height:30px;">
                            <p style="width:100px;">コメント:</p>
                            <div style="width:300px;">{{$product->comment}}</div>
                        </div>
                    </li>

                    <!-- button -->
                    <div class="mt-5 d-flex justify-content-end">
                        <a class="col col-lg-2 btn btn-success me-3" href="{{route('product.edit',['id'=>$product->id])}}">編集</a>
                        <a class="col col-lg-2 btn btn-primary" href="{{route('product.index')}}">戻る</a>
                    </div>
                </ul>
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>
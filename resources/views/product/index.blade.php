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


        <!-- 検索機能 -->
        <div class="container">
            <form class="row justify-content-md-center" method="GET" action="{{ route('product.index') }}">
            @csrf
                <input type="text" name="product_name" placeholder="商品名" class="col col-lg-2">
                <select class="col col-lg-2 ms-3" name="company_id">
                        @foreach($companies as $company)
                        <option class="col col-lg-2 ms-3" value="{{$company->id}}">{{$company->company_name}}</option>
                        @endforeach
                </select>
                <input type="submit" value="検索" class="col col-lg-1 ms-3">
            </form>
        </div>


        <!-- main -->
        <div class="m-auto mt-5 w-50">
            <h3 class="title">商品一覧画面</h3>
            <ul class="container text-center m-0 border-top border-end border-start border-dark">
                <li class="border-bottom border-dark row  justify-content-md-center">
                    <div class="d-flex justify-content-start align-items-center mt-2 mb-2">
                        <div class="col col-lg-1">ID</div>
                        <div class="col col-lg-1">商品画像</div>
                        <div class="col col-lg-2">商品名</div>
                        <div class="col col-lg-2">価格</div>
                        <div class="col col-lg-1">在庫数</div>
                        <div class="col col-lg-2">メーカー名</div>
                        <a class="col col-lg-2 btn btn-primary" href="{{route('product.new')}}">新規追加</a>
                    </div>
                </li>
    @foreach( $products as $product)
                <li class="row justify-content-md-center border-bottom border-dark">
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="col col-lg-1 mb-2 mt-2">{{$product->id}}</div>
                        <img class="col col-lg-1 mb-2 mt-2 rounded-3" style=" max-height:100px;" src="{{ route('product.getfile',['id'=>$product->id]) }}">
                        <div class="col col-lg-2 mb-2 mt-2">{{$product->product_name}}</div>
                        <div class="col col-lg-2 mb-2 mt-2">{{$product->price}}</div>
                        <div class="col col-lg-1 mb-2 mt-2">{{$product->stock}}</div>
                        <div class="col col-lg-2 mb-2 mt-2">{{$product->company->company_name}}</div>

                        <div class="col col-lg-2 d-grid gap-2 d-md-block">
                            <a class="btn btn-warning mt-3 ps-4 pe-4" href="{{route('product.show',['id'=>$product->id])}}">詳細</a>

                            <form action="{{route('product.delete')}}" method="post">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="id" value="{{$product->id}}">
                                <input class="btn btn-danger mt-3 ps-4 pe-4" type="submit" value="削除">
                            </form>
                        </div>
                    </div>
                </li>
    @endforeach
            </ul>
        </div>
        <!-- ページネーション -->
        {{ $products->links('vendor.pagination.bootstrap-4') }}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>
<html>
    <body>
        <head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/js/jquery.tablesorter.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/css/theme.default.min.css">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <script>
            $(document).ready(function(){
                table();
            });
            /* 削除 */
            $(function() {
                $('.destroy').on('click',function(){
                    var deleteConfirm = confirm('削除してもいいですか？')
                    if(deleteConfirm == true) {
                        var clickEle = $(this)
                        var productID = clickEle.data('product-id');
                        $.ajax({
                            url: '/destroy/'+ productID,
                            type: 'POST',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .done(function(){
                            clickEle.parents('tr').remove();
                        })
                        .fail(function() {
                            alert('エラー');
                        });
                    } else {
                        (function(e){
                            e.preventDefault()
                        });
                    };
                });
            });
            /* 検索 */
            $(function() {
                $('#searchButton').on('click', function(e) {
                e.preventDefault();
                var product_name = $('#product_name').val();
                var companyId = $('#company_id').val();
                var priceUpper = $('#price_upper').val();
                var priceLower = $('#price_lower').val();
                var stockUpper = $('#stock_upper').val();
                var stockLower = $('#stock_lower').val();

                if (product_name !== "" || companyId !== "" || priceUpper !== "" || priceLower !== "" || stockUpper !== "" || stockLower !== "") {
                    $.ajax({
                        url: '/api/search',
                        type: 'GET',
                        data: {
                            product_name: product_name,
                            company_id: companyId,
                            price_upper: priceUpper,
                            price_lower: priceLower,
                            stock_upper: stockUpper,
                            stock_lower: stockLower,
                        },
                        dataType: 'json',
                    }).done(function(data) {
                        $('#fav-table').empty();
                        $('#fav-table').html(data.parts);
                        table();
                    }).fail(function() {
                        alert('データ取得できませんでした。');
                    });
                } else {
                    alert('検索ワード選択してください。');
                }
            });
        });
        /* ソート機能 */
        function table(){
                    $("#fav-table,#fav-table2").tablesorter({
                    headers: {
                        0: { sorter: false },
                        1: { sorter: false },
                        2: { sorter: false },
                        5: { sorter: false }
                    }
                    });
                }
            </script>
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
            <form id="searchForm" class="row justify-content-md-center">
                <input class="col col-lg-1" type="text" id="product_name" name="product_name" placeholder="商品名">
                <select class="col col-lg-1 ms-3" id="company_id" name="company_id">
                            @foreach($companies as $company)
                            <option  value="{{$company->id}}">{{$company->company_name}}</option>
                            @endforeach
                </select>
                <input class="col col-lg-1 ms-3" id="price_upper"  type="text" name="price_upper" placeholder="価格上限" >
                <input class="col col-lg-1 ms-3" id="price_lower"  type="text" name="price_lower" placeholder="価格下限" >
                <input class="col col-lg-1 ms-3" id="stock_upper"  type="text" name="stock_upper" placeholder="在庫上限">
                <input class="col col-lg-1 ms-3" id="stock_lower"  type="text" name="stock_lower" placeholder="在庫下限">
                <button class="col col-lg-1 ms-3" id="searchButton">検索</button>
            </form>
        </div>



        <!-- main -->
        <div class="m-auto mt-5 w-50">
            <h3 class="title">商品一覧画面</h3>
            <a class="col col-lg-2 btn btn-primary" href="{{route('product.new')}}">新規追加</a>
            <table id="fav-table" class="table table-bordered border">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>商品画像</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>メーカー名</th>
                    </tr>
                </thead>
                <tbody id='products'>
                @foreach( $products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td><img style=" max-height:100px;" src="{{ route('product.getfile',['id'=>$product->id]) }}"></td>
                        <td>{{$product->product_name}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->stock}}</td>
                        <td>{{$product->company->company_name}}</td>

                        <td class="ps-5">
                            <a class="btn btn-warning mt-3 ps-4 pe-4" href="{{route('product.show',['id'=>$product->id])}}">詳細</a>
                            <button data-product-id="{{$product->id}}" class="destroy btn btn-danger mt-3 ps-4 pe-4 ms-3" type="button">削除</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- ページネーション -->
        {{ $products->links('vendor.pagination.bootstrap-4') }}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>
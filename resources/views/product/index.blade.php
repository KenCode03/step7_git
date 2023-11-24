<html>
    <body>
        <head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/js/jquery.tablesorter.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/css/theme.default.min.css">
            <script>
            $(document).ready(function(){
                $("#fav-table,#fav-table2").tablesorter({
                    headers: {
                        0: { sorter: false },
                        1: { sorter: false },
                        2: { sorter: false },
                        5: { sorter: false }
                    }
                });
            });
            /* 削除(非同期) */
            $(function() {
                $('#destroy').on('click',function(e){
                    e.preventDefault();
                    var deleteConfirm = confirm('削除してもいいですか？')
                    if(deleteConfirm == true) {
                        var clickEle = $(this)
                        var productID = clickEle.data('product_id');
                        console.log(productID);
                        $.ajax({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: 'destroy/'+ productID,
                            type: 'POST',
                            dataType: 'json',
                            data: {'id': productID,'_method':'DELETE'}
                        })
                        .done(function(){
                            console.log('成功');
                            clickEle.parents('tr').remove();
                        })
                    } else {
                        (function(e){
                            e.preventDefault()
                        });
                    };
                });
            });
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
            <form class="row justify-content-md-center" method="GET" action="{{ route('product.index') }}">
            @csrf
                <input type="text" name="product_name" placeholder="商品名" class="col col-lg-1">
                <select class="col col-lg-1 ms-3" name="company_id">
                        @foreach($companies as $company)
                        <option  value="{{$company->id}}">{{$company->company_name}}</option>
                        @endforeach
                </select>
                <input class="col col-lg-1 ms-3"  type="text" name="price-upper" placeholder="価格上限" >
                <input class="col col-lg-1 ms-3"  type="text" name="price-lower" placeholder="価格下限" >
                <input class="col col-lg-1 ms-3"  type="text" name="stock-upper" placeholder="在庫上限">
                <input class="col col-lg-1 ms-3"  type="text" name="stock-lower" placeholder="在庫下限">
                <input class="col col-lg-1 ms-3"  type="submit" value="検索">
            </form>
        </div>



        <!-- main -->
        <div class="m-auto mt-5 w-50">
            <h3 class="title">商品一覧画面</h3>
            <a class="col col-lg-2 btn btn-primary" href="{{route('product.new')}}">新規追加</a>
            <table id="fav-table" class="table table-bordered border">
            <!-- <div id="table_sort" class="tablesorter container text-center m-0 border-top border-end border-start border-dark"> -->
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>商品画像</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>メーカー名</th>
                        <!-- <th><a class="col col-lg-2 btn btn-primary" href="{{route('product.new')}}">新規追加</a></th> -->
                    </tr>
                </thead>
    @foreach( $products as $product)
                <!-- <tbody class="row justify-content-md-center border-bottom border-dark"> -->
                    <tr>
                        <td>{{$product->id}}</td>
                        <td><img style=" max-height:100px;" src="{{ route('product.getfile',['id'=>$product->id]) }}"></td>
                        <td>{{$product->product_name}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->stock}}</td>
                        <td>{{$product->company->company_name}}</td>

                        <td class="ps-5">
                            <a class="btn btn-warning mt-3 ps-4 pe-4" href="{{route('product.show',['id'=>$product->id])}}">詳細</a>

                            <!-- <form action="{{route('product.delete')}}" method="post">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="id" value="{{$product->id}}">
                                <input class="btn btn-danger mt-3 ps-4 pe-4" type="submit" value="削除">
                            </form> -->
                            <form  class="id">
                                <input data-product_id="{{$product->id}}" id="destroy" type="submit" value="削除">
                            </form>
                        </td>
                    </tr>
                <!-- </tbody> -->
    @endforeach
        </table>
        </div>
        <!-- ページネーション -->
        {{ $products->links('vendor.pagination.bootstrap-4') }}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <!-- jQuery  -->
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->
    </body>
</html>
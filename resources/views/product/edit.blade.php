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

        <!-- <h1>編集ページ</h1> -->
        <div class="m-auto" style="width:400px;">
            <h3>詳細画面</h3>
            <form class="border border-dark p-3" action="{{route('product.update')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <input type="hidden" name="id" value="{{$product->id}}">
                <div class="d-flex mb-2 mt-3" style="height:30px;">
                    <p style="width:100px;">id:</p>
                    <div style="width:300px;">{{$product->id}}</div><br>
                </div>

                <div class="d-flex mb-2 mt-3" style="height:50px;">
                    <p style="width:100px;">商品名:</p>
                    <div style="width:300px;">
                        <input type="text" name="product_name" value="{{$product->product_name}}"><br>
                        @if($errors->has('product_name'))
                        <li style="color:red; list-style:none;">{{$errors->first('product_name')}}</li>
                        @endif
                    </div>
                </div>

                <div class="d-flex mb-2 mt-3" style="height:50px;">
                    <p style="width:100px;">メーカー:</p>
                    <div style="width:300px;">
                    <select name="company_id">
                        @foreach($companies as $company)
                        <option value="{{$company->id}}">{{$company->company_name}}</option>
                        @endforeach
                    </select>
                        @if($errors->has('company_name'))
                        <li style="color:red; list-style:none;">{{$errors->first('company_name')}}</li>
                        @endif
                    </div>
                </div>

                <div class="d-flex mb-2 mt-3" style="height:50px;">
                    <p style="width:100px;">価格:</p>
                    <div style="width:300px;">
                        <input type="text" name="price" value="{{$product->price}}"><br>
                        @if($errors->has('price'))
                        <li style="color:red; list-style:none;">{{$errors->first('price')}}</li>
                        @endif
                    </div>
                </div>

                <div class="d-flex mb-2 mt-3" style="height:50px;">
                    <p style="width:100px;">在庫数:</p>
                    <div style="width:300px;">
                        <input type="text" name="stock" value="{{$product->stock}}"><br>
                        @if($errors->has('stock'))
                        <li style="color:red; list-style:none;">{{$errors->first('stock')}}</li>
                        @endif
                    </div>
                </div>

                <div class="d-flex mb-2 mt-3" style="height:50px;">
                    <p style="width:100px;">コメント:</p>
                    <div style="width:300px;">
                        <input type="text" name="comment" value="{{$product->comment}}"><br>
                        @if($errors->has('comment'))
                        <li style="color:red; list-style:none;">{{$errors->first('comment')}}</li>
                        @endif
                    </div>
                </div>

                <div class="d-flex mb-2 mt-3" style="height:50px;">
                    <p style="width:100px;">商品画像:</p>
                    <div style="width:300px;">
                        <input type="file" name="file" value="{{$product->file}}"><br>
                        @if($errors->has('file'))
                        <li style="color:red; list-style:none;">{{$errors->first('file')}}</li>
                        @endif
                    </div>
                </div>

                <!-- button -->
                <div class="mt-5 d-flex justify-content-end">
                    <input  class="btn btn-success me-3" type="submit" value="編集">
                    <a class="col col-lg-2 btn btn-primary" href="{{route('product.show',['id'=>$product->id])}}">戻る</a>
                </div>
            </form>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>
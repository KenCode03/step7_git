<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    <!-- <div>
        <label for="id">ID検索</label>
        <input type="text" id="id" name="id" value="">

        <label for="product_name">名前</label>
        <input type="text" id="product_name" name="product_name" value="">
    </div> -->
    <!-- <div id='data'>
        <ul id='products'></ul>
    </div> -->
    <input type="text" id="id" name="id" value="">
    <button id="searchButton">検索</button>
    <div>
        <ul id='products'></ul>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        /* $.getJSON(
            '/api/index',
            function(data) {
                $('#products').empty();
                data.forEach(function(item){
                    $('#products').append(`<li>${item.id}</li>`)
                    $('#products').append(`<li>${item.product_name}</li>`)
                });
                console.log(data);
            }
        ); */
        //検索
        $(function() {
            $('#searchButton').on('click', function() {
                var id = $('#id').val();

                if (id !== "") {
                    $.ajax({
                        url: '/api/search2',
                        type: 'GET',
                        data: { id: id },
                        dataType: 'json',
                    }).done(function(data) {
                        $('#products').empty();
                        $('#products').append(data.parts);
                    }).fail(function() {
                        alert('データ取得できませんでした。');
                    });
                } else {
                    alert('検索するIDを選択してください。');
                }
            });
        });
        /* $(function() {
            $('#id').on('change', function() {
                var id = $(this).val();

                $.ajax({
                    url: '/api/search',
                    type: 'GET',
                    data: { id: id },
                    dataType: 'json',
                }).done(function(data) {
                    var product_name = data[0] ? data[0].product_name : '';

                    $('#product_name').val(product_name);

                }).fail(function() {
                    alert('データ取得できませんでした。');
                });
            });
        }); */
    </script>
</x-app-layout>

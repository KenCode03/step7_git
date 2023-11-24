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
    <button id='ok_button'>OK</button>
    <div id='data'>
        <ul id='products'></ul>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $('#ok_button').click(function() {
            $.getJSON(
                '/api/product',
                function(data) {
                    $('#products').empty();
                    data.forEach(function(item){
                        $('#products').append(`<li>${item.id}</li>`)
                        $('#products').append(`<li>${item.product_name}</li>`)
                    });
                    console.log(data);
                }
            );
        });
    </script>
</x-app-layout>

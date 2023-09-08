<html>
<body>
    <ul>
        @foreach($companies as $company)
        <li>
            <div>{{$company->id}}</div>
            <div class="col col-lg-2 mb-2 mt-2">{{$company->company_name}}</div>
        </li>
        @endforeach
    </ul>
</body>
</html>
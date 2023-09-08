<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    //一覧ページ
    public function table(Request $request){
        $companies = Company::all();

        return view('company.table',[
            'companies'=>$companies,
        ]);
    }
}

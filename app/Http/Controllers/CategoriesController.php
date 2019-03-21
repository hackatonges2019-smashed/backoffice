<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    public function getCategories()
    {
        // $categories = Categories::all();
        $categories = Categories::where('idParent', null)->get();
        // var_dump(json_encode($categories));die;
        return response()->json(json_decode($categories));
    }

    public function getSubCategories($id)
    {
        // $categories = Categories::all();
        $categories = Categories::where('idParent',$id)->get();
        // var_dump(json_encode($categories));die;
        return response()->json(json_decode($categories));
    }

    public function callback(Request $request)
    {
        return response()->json(['code' => $request->get('code')]);
    }
}

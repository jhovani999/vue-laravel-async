<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function list_product() {
        $data = Product::selectRaw('id,name')->get()->toArray();
        return [
            'result' => $data
        ];
    }

    public function create_product(Request $request) {
        $data = Product::insert([
            'name' => $request->get('name'),
            'created_at' => DB::raw('now()'),
            'updated_at' => DB::raw('now()')
        ]);
        return response()->json(['success' => $data]);
    }

    public function update_product(Request $request) {
        $data = Product::where('id', $request['id'])->update([
            'name' => $request->get('name'),
            'updated_at' => DB::raw('now()')
        ]);
      return response()->json(['success' => $data]);
    }

    public function delete_product(Request $request)
    {
        $id = $request->get('id');
        $data = Product::where([['id', '=', $id]])->delete();
        return response()->json(['success' => $data]);
    }

}

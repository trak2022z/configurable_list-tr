<?php

namespace App\Http\Controllers\API;
use App\Models\Shop;
use App\Models\List_;
use Illuminate\Http\Request;

class ShopController extends Controller
{

 
    public function index() {
      
        $shops = auth()->user()->shops()->orderBy('created_at', 'desc')->get();

        foreach($shops as $shop)
            $shop -> assignedLists = count($shop->lists);

        return $shops;

    }

    public function create(Request $request){

        $request->request->add(['user_id' => auth()->user()->id]);
        return Shop::create($request->all());

    }


    public function show($id) {

        if(Shop::find($id)->user_id == auth()->user()->id)
             return Shop::find($id);
        else return 0;
    }

    public function showAssignedLists($id) {

        $lists = Shop::find($id)->lists()->orderBy('created_at', 'desc')->get();
        foreach($lists as $list)
        {
            $list->productsCounted = count($list->products->where('ticked'));
            $list->productsAvalaible = count($list->products);
            
        }
        return $lists;

    }

    public function update(Request $request, $id) {

        $shop = Shop::find($id);
        $shop -> update($request->all());
        return $shop;
    }


    public function delete($id) {

        return Shop::destroy($id);
    }    
   


}

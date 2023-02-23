<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataProvider;


class DataProviderController extends Controller
{
    public function store(Request $request){

        $addDataProvider = new DataProvider();
        $addDataProvider->name = $request->name;
        $addDataProvider->url = $request->url;
        $addDataProvider->save();

        return response()->json($this->prepareResponse($addDataProvider));
    } 

    public function index(){

        $dataProvider = DataProvider::all();
        return response()->json($this->prepareResponse($dataProvider));
    }

    public function view($id){
        $dataProvider = DataProvider::where('id',$id)->first();
        return response()->json($this->prepareResponse($dataProvider));
    }

    public function update(Request $request,$id){
        $dataProviderUpdate = DataProvider::where('id',$id)->first();
        $dataProviderUpdate->name = $request->name;
        $dataProviderUpdate->url = $request->url;
        $dataProviderUpdate->save();
        return response()->json($this->prepareResponse($dataProviderUpdate));
    }

    public function destroy($id){

        $dataProviderDelete = DataProvider::findOrfail($id);
        $dataProviderDelete->delete();

        return response()->json($this->prepareResponse($dataProviderDelete));
    }
}

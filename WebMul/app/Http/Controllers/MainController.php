<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Http::get('http://127.0.0.1:5000/trainingDatas');
        $response = json_decode($response, true);
        return view('training')->with('data', $response);
    }
    public function index4()
    {
        $response = Http::get('http://127.0.0.1:5000/testDatas');
        $response = json_decode($response, true);
        return view('test')->with('data', $response);
    }

    public function index2()
    {
        $response = Http::get('http://127.0.0.1:5000/prediction');
        $response = json_decode($response, true);
        return view('prediction')->with('data', $response);
    }

    public function index3()
    {
        $response = null;
        return view('crawl')->with('data', $response);
    }


    public function upload(Request $request)
    {
        $this->validate($request, ['file' => 'required|mimes:csv,txt']);
        $file = $request->file('file');
        $file->move('filesUpload', $file->getClientOriginalName());

        $response = Http::get('http://127.0.0.1:5000/prediction');
        $response = json_decode($response, true);
        return view('prediction')->with('data', $response);
    }

    public function crawl(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inputQuery' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('crawl')
                ->withErrors($validator)
                ->withInput();
        }

        $response = Http::post(
            'http://127.0.0.1:5000/crawlDatas',
            $request->all()
        );
        
        return view('crawl')->with('data', $response->json());
    }
}

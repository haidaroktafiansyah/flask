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

        $query['inputQuery'] = '(#' . $request->inputQuery . ') lang:id';

        if (isset($request->end) && isset($request->start)) {
            //start
            $since = explode('/', $request->start);
            $since = array_reverse($since);
            $since = implode("-", $since);
            //end
            $end = explode('/', $request->end);
            $end = array_reverse($end);
            $end = implode("-", $end);
            $query['inputQuery'] = $query['inputQuery']   . ' since:' . $since . ' until:' . $end;
        } else {
            if (isset($request->start)) {
                //start
                $since = explode('/', $request->start);
                $since = array_reverse($since);
                $since = implode("-", $since);

                $query['inputQuery'] = $query['inputQuery'] . ' since:' . $since;
            }
            if (isset($request->end)) {
                //end
                $end = explode('/', $request->end);
                $end = array_reverse($end);
                $end = implode("-", $end);

                $query['inputQuery'] = $query['inputQuery'] . ' until:' . $end;
            }
        }
        // dd($query['inputQuery']);
        $response = Http::post(
            'http://127.0.0.1:5000/crawlDatas',
            $query
        );
        // dd($response->json());
        return view('crawl')->with('data', $response->json());
    }
}

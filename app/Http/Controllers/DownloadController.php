<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DownloadController extends Controller
{
    public function do(Request $request)
    {
        $request->validate([
            'url' => 'bail|required|string|url'
        ]);

        $filename = basename($request->url);
        $savePath = storage_path('app/public/' . $filename);

        $response = Http::send(
            'GET',
            $request->url,
            [
                'save_to' => $savePath
            ]
        );

        if ($response->successful()) {
            return response()->download($savePath)->deleteFileAfterSend();
        } else {
            return redirect()->route('home');
        }
    }
}

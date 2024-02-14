<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class SelectController extends Controller
{
    public function processForm(Request $request)
    {
        $selectBoard = $request->input('selectBoard');
        $candidates = implode(",", $request->input('candidates', []));
        $parties = implode(",", $request->input('parties', []));
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $class = implode(",", $request->input('class', []));
        $sentiments = implode(",", $request->input('sentiments', []));


        DB::table('politics_db')->insert([
            'selectBoard' => $selectBoard,
            'candidates' => $candidates,
            'parties' => $parties,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'class' => $class,
            'sentiments' => $sentiments,
        ]);

        return "數據插入成功";
    }
}




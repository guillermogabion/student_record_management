<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecordController extends Controller
{
    //

    public function store(Request $request) {
        $record = new Record;
        $record = $request->all();
        User::insert($record);
    }

    public function update($id, Request $request){
        $record = Record::find(id);
        $record->course = $request->course;
        $record->course_code = $request->course_code;
        $record->unit = $request->unit;
        $record->school_year = $request->school_year;
    
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Record;
class RecordController extends Controller
{
    //

    public function store(Request $request) {
        $record = new Record;
        $record = $request->all();
        $data = Record::insert($record);

        return $data;
    }

    public function update($id, Request $request){
        $record = Record::find(id);
        $record->course = $request->course;
        $record->course_code = $request->course_code;
        $record->unit = $request->unit;
        $record->school_year = $request->school_year;
    
    }
}

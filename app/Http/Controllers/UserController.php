<?php

namespace App\Http\Controllers;
use Dompdf\Dompdf;

use App\Exports\ExportData;

use Maatwebsite\Excel\Facades\Excel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function self()
    {
        $user = User::find(auth()->user()->id);
        $token = $user->createToken('authToken')->accessToken;
        return response(['user' => $user, 'access_token' => $token]);
    }

    public function createAdmin(Request $request){
        $request->merge(['user_type' => 1]);
        $data = new User;
        $data = $request->all();
        $data['password'] = Hash::make($request->input('password'));
        $user = User::insert($data);

        return $user;
    }

    public function index()
    {
        return view('users');
    }
    public function login(Request $request)
    {
        // return $request;
        $login = $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();

        // return $user;
        if (!Auth::attempt($login)) {
            return response(['message' => 'login Credentials are incorrect'], 401);
        }
        $token = $user->createToken('authToken')->accessToken;
        return response(['user' => Auth::user(), 'access_token' => $token]);
    }

    public function addRegister(Request $request) {
        $data = new User;

        $data->stud_no = $request->stud_no;
        $data->last_name = $request->last_name;
        $data->first_name = $request->first_name;
        $data->mid_name = $request->mid_name;
        $data->suffix = $request->suffix;
        $data->program = $request->program;
        $data->dobirth = $request->dobirth;
        $data->sex = $request->sex;
        $data->brgy = $request->brgy;
        $data->town = $request->town;
        $data->province = $request->province;
        $data->parent_first = $request->parent_first;
        $data->parent_last = $request->parent_last;
        $data->parent_mid = $request->parent_mid;
        $data->save();

        return $data;
    }

    public function displayStudent(){
        $data = User::where('user_type', 0)->get();
        return $data;
    }
    public function displayIT(){
        $data = User::with('record')->where('program','LIKE', "BSIT")->where('user_type', 0)->get();
        return $data;
    }
    public function displayED(){
        $data = User::with('record')->where('program','LIKE', "BEED")->where('user_type', 0)->get();
        return $data;
    }
    public function displayCrim(){
        $data = User::with('record')->where('program','LIKE', "BSCRIM")->where('user_type', 0)->get();
        return $data;
    }
    public function displayCS(){
        $data = User::with('record')->where('program','LIKE', "BSCS")->where('user_type', 0)->get();
        return $data;
    }
    public function displayHM(){
        $data = User::with('record')->where('program','LIKE', "BSHM")->where('user_type', 0)->get();
        return $data;
    }

    public function displaySubjects(){
        $data = User::with('record')->where('user_type', 0)->get();
        return $data;
    }

    public function editStudent($id, Request $request) {
        $data = User::find($id);

        $data->stud_no = $request->stud_no;
        $data->last_name = $request->last_name;
        $data->first_name = $request->first_name;
        $data->mid_name = $request->mid_name;
        $data->suffix = $request->suffix;
        $data->program = $request->program;
        $data->dobirth = $request->dobirth;
        $data->sex = $request->sex;
        $data->brgy = $request->brgy;
        $data->town = $request->town;
        $data->province = $request->province;
        $data->parent_first = $request->parent_first;
        $data->parent_last = $request->parent_last;
        $data->parent_mid = $request->parent_mid;
        $data->save();

        return $data;
    }

    public function deleteStudent($id){
        $data = User::where('id', $id)->delete();
        return $data;
    }

    public function export(Request $request)
    {   
        {

            $data = User::with('record')
                ->where('user_type', 0)
                ->whereYear('created_at', '=', $request->year)
               ->get();
    
            $pdf = new Dompdf();
            $pdf->set_paper('landscape');
    
            $html = '<table style="border-collapse: collapse; width: 100%; border-bottom: 1px solid black; padding-bottom: 10px">
                        <thead>
                            <tr>
                                <th style="border: 1px solid black; padding: 10px;">Student No</th>
                                <th style="border: 1px solid black; padding: 10px;">Last Name</th>
                                <th style="border: 1px solid black; padding: 10px;">First Name</th>
                                <th style="border: 1px solid black; padding: 10px;">Middle Name</th>
                                <th style="border: 1px solid black; padding: 10px;">Name Extension</th>
                                <th style="border: 1px solid black; padding: 10px;">Gender</th>
                                <th style="border: 1px solid black; padding: 10px;">Program</th>
                                <th style="border: 1px solid black; padding: 10px;">Course Code</th>
                                <th style="border: 1px solid black; padding: 10px;">Unit</th>
                                <th style="border: 1px solid black; padding: 10px;">Total Unit</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $row) {
                $num_records = count($row['record']);
                $total_unit = 0;
                $html .= '<tr>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['stud_no'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['last_name'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['first_name'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['mid_name'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['suffix'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['sex'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['program'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;">' . $row['record'][0]['course_code'] . '</td>
                            <td style="border: 1px solid black; padding: 10px; text-align: center;">' . $row['record'][0]['unit'] . '</td>
                            <td style="border: 1px solid black; padding: 10px; text-align: center;" rowspan="' . $num_records . '">' . $row['record'][0]['unit'] . '</td>
                        </tr>';
                $total_unit += $row['record'][0]['unit'];
    
                for ($i = 1; $i < $num_records; $i++) {
                    $html .= '<tr><td style="border: 1px solid black; padding: 10px;">' . $row['record'][$i]['course_code'] . '</td><td style="border: 1px solid black; padding: 10px; text-align: center;">' . $row['record'][$i]['unit'] . '</td></tr>';
                    $total_unit += $row['record'][$i]['unit'];
                }
                $html = str_replace('{{total_unit}}', $total_unit, $html);
            }
    
            $html .= '</tbody>
                        <tfoot>
                            <tr>
                                <td colspan="13" style="border-top: 1px solid black;"></td>
                            </tr>
                        </tfoot>
                    </table>';
    
            $pdf->loadHtml($html);
            $pdf->render();
    
            $pdf->stream('filename.pdf');
        }
    }


    public function exportList(Request $request)
    {   
        {
            

            $data = User::where('user_type', 0)
                ->whereYear('created_at', '=', $request->year)
               ->get();
    
            $pdf = new Dompdf();
            $pdf->setPaper('a4', 'landscape');
    
            $html = '<table style="border-collapse: collapse; width: 100%; border-bottom: 1px solid black; padding-bottom: 50px;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid black; padding: 10px;">No</th>
                                <th style="border: 1px solid black; padding: 10px;">Last Name</th>
                                <th style="border: 1px solid black; padding: 10px;">First Name</th>
                                <th style="border: 1px solid black; padding: 10px;">Middle Name</th>
                                <th style="border: 1px solid black; padding: 10px;">Name Extension</th>
                                <th style="border: 1px solid black; padding: 10px;">Student Number</th>
                                <th style="border: 1px solid black; padding: 10px;">Date of Birth</th>
                                <th style="border: 1px solid black; padding: 10px;">Brgy/Street</th>
                                <th style="border: 1px solid black; padding: 10px;">Town</th>
                                <th style="border: 1px solid black; padding: 10px;">Province</th>
                                <th style="border: 1px solid black; padding: 10px;">Parent LastName</th>
                                <th style="border: 1px solid black; padding: 10px;">Parent FirstName</th>
                                <th style="border: 1px solid black; padding: 10px;">Parent Middle Name</th>
                          
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $row) {
                $num_records = count($row->record);
                $html .= '<tr>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['id'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['last_name'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['first_name'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['mid_name'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['suffix'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['stud_no'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['dobirth'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['brgy'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['town'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['province'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['parent_last'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['parent_first'] . '</td>
                            <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['parent_mid'] . '</td>
                        </tr>';
               
            }
    
            $html .= '</tbody>
                        <tfoot>
                            <tr>
                                <td colspan="13" style="border-top: 1px solid black;"></td>
                            </tr>
                        </tfoot>
                    </table>';
    
            $pdf->loadHtml($html);
            $pdf->render();
    
            $pdf->stream('filename.pdf');
        }
    }

    public function exportByProgram(Request $request)
    {   
        {

            $data = User::with('record')
                ->where('user_type', 0)
                ->whereYear('created_at', '=', $request->year)
                ->where('program', '=', $request->program)
               ->get();
    
            $pdf = new Dompdf();
            $pdf->setPaper('a4', 'landscape');
    
            $html = '<table style="border-collapse: collapse; width: 100%; border-bottom: 1px solid black; padding-bottom: 10px">
                        <thead>
                            <tr>
                                <th style="border: 1px solid black; padding: 10px;">Student No</th>
                                <th style="border: 1px solid black; padding: 10px;">Last Name</th>
                                <th style="border: 1px solid black; padding: 10px;">First Name</th>
                                <th style="border: 1px solid black; padding: 10px;">Middle Name</th>
                                <th style="border: 1px solid black; padding: 10px;">Name Extension</th>
                                <th style="border: 1px solid black; padding: 10px;">Gender</th>
                                <th style="border: 1px solid black; padding: 10px;">Program</th>
                                <th style="border: 1px solid black; padding: 10px;">Course Code</th>
                                <th style="border: 1px solid black; padding: 10px;">Unit</th>
                            </tr>
                        </thead>
                        <tbody>';
                        foreach ($data as $row) {
                            $num_records = count($row['record']);
                            $total_unit = 0;
                            
                            $html .= '<tr>
                                        <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['stud_no'] . '</td>
                                        <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['last_name'] . '</td>
                                        <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['first_name'] . '</td>
                                        <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['mid_name'] . '</td>
                                        <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['suffix'] . '</td>
                                        <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['sex'] . '</td>
                                        <td style="border: 1px solid black; padding: 10px;" rowspan="' . $num_records . '">' . $row['program'] . '</td>
                                        <td style="border: 1px solid black; padding: 10px;">' . $row['record'][0]['course_code'] . '</td>
                                        <td style="border: 1px solid black; padding: 10px; text-align: center;">' . $row['record'][0]['unit'] . '</td>
                                        <td style="border: 1px solid black; padding: 10px; text-align: center;" rowspan="' . $num_records . '">' . $total_unit . '</td>
                                        
                                    </tr>';
                                    $total_unit += $row['record'][0]['unit'];// accumulate the sum of units

                                    for ($i = 1; $i < $num_records; $i++) {
                                        $html .= '<tr>
                                            <td style="border: 1px solid black; padding: 10px;">' . $row['record'][$i]['course_code'] . '</td>
                                            <td style="border: 1px solid black; padding: 10px; text-align: center;">' . $row['record'][$i]['unit'] . '</td>
                                        </tr>';
                                        $total_unit += $row['record'][$i]['unit'];
                                    }
                                }
                                $html .= '<td style="border: 1px solid black; padding: 10px; text-align: center;"><strong>' . $total_unit . '</strong></td>';  
                                // $html = str_replace('<td style="border: 1px solid black; padding: 10px; text-align: center;" rowspan="' . $num_records . '">' . $total_unit . '</td>', '<td style="border: 1px solid black; padding: 10px; text-align: center;" rowspan="' . $num_records . '">' . $total_unit . '</td>', $html);
    
            $html .= '</tbody>
                        <tfoot>
                            <tr>
                                <td colspan="13" style="border-top: 1px solid black;"></td>
                            </tr>
                        </tfoot>
                    </table>';
    
            $pdf->loadHtml($html);
            $pdf->render();
    
            $pdf->stream('filename.pdf');
        }

       
    }


}

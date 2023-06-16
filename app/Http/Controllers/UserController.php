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
        $data = User::with('record')
            ->where('user_type', 0)
            ->whereYear('created_at', '=', $request->year)
            ->get();
    
        $pdf = new Dompdf();
        $pdf->set_paper(array(0, 0, 500, 1900)); // Set large page size
        
        $requestYear = $request->year;
        $nextYear = $requestYear + 1;
        $headerHtml = '<div style="text-align: center; padding-top: 5px;">
                        <h2>Tan Ting Bing Memorial Colleges Foundation, Inc.</h2>
                        <h4>Poblacion Norte, San Isidro Northern Samar</h4>
                        <h3>Enrollment List</h3>
                        <span style="font-size: 12px">SY . ' . $requestYear . '-' . $nextYear . '</span><br>
                    </div>';
    
        $html = '<div style="display: flex; flex-direction: row-reverse; flex-wrap: wrap; justify-content: flex-start;">
                    <table style="border-collapse: collapse; width: 100%; border-bottom: 1px solid black; font-size: 8px; padding-bottom: 10px">
                        <thead style="border: 1px solid black; padding: 2px;">
                            <tr>
                                <th style="border: 1px solid black; padding: 2px;">Student No</th>
                                <th style="border: 1px solid black; padding: 2px;">Last Name</th>
                                <th style="border: 1px solid black; padding: 2px;">First Name</th>
                                <th style="border: 1px solid black; padding: 2px;">Middle Name</th>
                                <th style="border: 1px solid black; padding: 2px;">Name Extension</th>
                                <th style="border: 1px solid black; padding: 2px;">Gender</th>
                                <th style="border: 1px solid black; padding: 2px;">Program</th>
                                <th style="border: 1px solid black; padding: 2px;  text-align: right;">Course Code</th>
                                <th style="border: 1px solid black; padding: 2px;  text-align:right ;">Unit</th>
                            </tr>
                        </thead>
                        <tbody>';
    
        foreach ($data as $row) {
            $num_records = count($row['record']);
            $total_unit = 0;
    
            for ($i = 0; $i < $num_records; $i++) {
                $html .= '<tr>';
    
                if ($i === 0) {
                    $html .= '<td style="border: 1px solid black; padding: 2px;" rowspan="' . $num_records . '">' . $row['stud_no'] . '</td>
                              <td style="border: 1px solid black; padding: 2px;" rowspan="' . $num_records . '">' . $row['last_name'] . '</td>
                              <td style="border: 1px solid black; padding: 2px;" rowspan="' . $num_records . '">' . $row['first_name'] . '</td>
                              <td style="border: 1px solid black; padding: 2px;" rowspan="' . $num_records . '">' . $row['mid_name'] . '</td>
                              <td style="border: 1px solid black; padding: 2px;" rowspan="' . $num_records . '">' . $row['suffix'] . '</td>
                              <td style="border: 1px solid black; padding: 2px;" rowspan="' . $num_records . '">' . $row['sex'] . '</td>
                              <td style="border: 1px solid black; padding: 2px;" rowspan="' . $num_records . '">' . $row['program'] . '</td>';
                }
    
                $html .= '<td style="border: 1px solid black; padding: 2px; text-align:right">' . $row['record'][$i]['course_code'] . '</td>
                          <td style="border: 1px solid black; padding: 2px;  text-align:right">' . $row['record'][$i]['unit'] . '</td>
    
                      </tr>';
                $total_unit += $row['record'][$i]['unit'];
            }
    
            // Insert Total Unit column for each student
            $html .= '
                        <td style="border: 1px solid black; padding: 2px; text-align: right;" colspan="8"><strong>Total Unit:</strong></td>
                        <td style="border: 1px solid black; padding: 2px; text-align: center;"><strong>' . $total_unit . '</strong></td>
                    ';
        }
    
        $html .= '</tbody>
                <tfoot>
                    <tr>
                        <td colspan="9" style="border-top: 1px solid black;"></td>
                    </tr>
                </tfoot>
            </table>
        </div>';
    
        $finalHtml = $headerHtml . $html;
    
        $pdf->set_option('isHtml5ParserEnabled', true);
        $pdf->set_option('isRemoteEnabled', true);
        $pdf->set_option('isPhpEnabled', true);
        $pdf->set_option('autoScriptToSize', true);
        $pdf->loadHtml($finalHtml);
        $pdf->render();
    
        $pdf->stream('filename.pdf');
    }
        
    

    


    public function exportList(Request $request)
    {   
        {
            

            $data = User::where('user_type', 0)
                ->whereYear('created_at', '=', $request->year)
               ->get();
    
               $requestYear = $request->year;
               $nextYear = $requestYear + 1;
               $pdf = new Dompdf();
               $pdf->setPaper('a4', 'landscape');
               $headerHtml = '<div style="text-align: center; padding-top: 5px; ">
                                <span style="font-size: 12px">Tan Ting Bing Memorial Colleges Foundation, Inc.</span><br>
                                <span style="font-size: 12px">Poblacion Norte, San Isidro Northern Samar</span><br>
                                <span style="font-size: 12px">Insurance List</span><br>
                                <span style="font-size: 12px">SY . ' . $requestYear . '-' . $nextYear . '</span><br>

                            </div>';
                
               $html = '<table style="font-size: 10px; border-collapse: collapse; width: 100%; border-right: 1px solid black; border-bottom: 1px solid black; padding-bottom: 50px;">
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
   
               foreach ($data as $user) {
                   $html .= '<tr style="border: 1px solid black;">
                                   <td style="border: 1px solid black; padding: 10px;">' . $user['id'] . '</td>
                                   <td style="border: 1px solid black; padding: 10px;">' . $user['last_name'] . '</td>
                                   <td style="border: 1px solid black; padding: 10px;">' . $user['first_name'] . '</td>
                                   <td style="border: 1px solid black; padding: 10px;">' . $user['mid_name'] . '</td>
                                   <td style="border: 1px solid black; padding: 10px;">' . $user['suffix'] . '</td>
                                   <td style="border: 1px solid black; padding: 10px;">' . $user['stud_no'] . '</td>
                                   <td style="border: 1px solid black; padding: 10px;">' . $user['dobirth'] . '</td>
                                   <td style="border: 1px solid black; padding: 10px;">' . $user['brgy'] . '</td>
                                   <td style="border: 1px solid black; padding: 10px;">' . $user['town'] . '</td>
                                   <td style="border: 1px solid black; padding: 10px;">' . $user['province'] . '</td>
                                   <td style="border: 1px solid black; padding: 10px;">' . $user['parent_last'] . '</td>
                                   <td style="border: 1px solid black; padding: 10px;">' . $user['parent_first'] . '</td>
                                   <td style="border: 1px solid black; padding: 10px;">' . $user['parent_mid'] . '</td>
                               </tr>';
   
               }
   
               $html .= '</tbody>
                           <tfoot>
                               <tr>
                                   <td colspan="13" style="border-top: 1px solid black;"></td>
                               </tr>
                           </tfoot>
                       </table>
                       <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="width: 33.33%; border: none;">
                                    <span style="text-align: left; font-size: 12px;">Prepared By :</span>
                                    <br>
                                    <span style="font-size: 12px;">__________________________</span>
                                    <br>
                                    <div style="text-align: left;">
                                        <span style="font-size: 12px; padding : 20px">Registrar</span>
                                    </div>
                                </td>
                                <td style="width: 33.33%; border: none;">
                                    <span style="text-align: left; font-size: 12px;">Noted By :</span>
                                    <br>
                                    <span style="font-size: 12px;">__________________________</span>
                                    <br>
                                    <div style="text-align: left; ">
                                        <span style="font-size: 12px; padding : 20px">HEI President</span>
                                    </div>
                                </td>
                                <td style="width: 33.33%; border: none;">
                                    <span style="text-align: left; font-size: 12px;">Date :</span>
                                </td>
                            </tr>
                        </table>
                            ';

               $finalHtml = $headerHtml . $html;
   
               $pdf->loadHtml($finalHtml);
               $pdf->render();
   
               $pdf->stream('studentInsurance.pdf');
        }
    }

    public function exportByProgram(Request $request)
    {
        $data = User::with('record')
            ->where('user_type', 0)
            ->whereYear('created_at', '=', $request->year)
            ->where('program', $request->program)
            ->get();
    
        $pdf = new Dompdf();
        $pdf->set_paper(array(0, 0, 500, 1900)); // Set large page size
        
        $requestYear = $request->year;
        $nextYear = $requestYear + 1;
        $headerHtml = '<div style="text-align: center; padding-top: 5px;">
                        <h2>Tan Ting Bing Memorial Colleges Foundation, Inc.</h2>
                        <h4>Poblacion Norte, San Isidro Northern Samar</h4>
                        <h3>Enrollment List</h3>
                        <span style="font-size: 12px">SY . ' . $requestYear . '-' . $nextYear . '</span><br>
                    </div>';
    
        $html = '<div style="display: flex; flex-direction: row-reverse; flex-wrap: wrap; justify-content: flex-start;">
                    <table style="border-collapse: collapse; width: 100%; border-bottom: 1px solid black; font-size: 8px; padding-bottom: 10px">
                        <thead style="border: 1px solid black; padding: 2px;">
                            <tr>
                                <th style="border: 1px solid black; padding: 2px;">Student No</th>
                                <th style="border: 1px solid black; padding: 2px;">Last Name</th>
                                <th style="border: 1px solid black; padding: 2px;">First Name</th>
                                <th style="border: 1px solid black; padding: 2px;">Middle Name</th>
                                <th style="border: 1px solid black; padding: 2px;">Name Extension</th>
                                <th style="border: 1px solid black; padding: 2px;">Gender</th>
                                <th style="border: 1px solid black; padding: 2px;">Program</th>
                                <th style="border: 1px solid black; padding: 2px;  text-align: right;">Course Code</th>
                                <th style="border: 1px solid black; padding: 2px;  text-align:right ;">Unit</th>
                            </tr>
                        </thead>
                        <tbody>';
    
        foreach ($data as $row) {
            $num_records = count($row['record']);
            $total_unit = 0;
    
            for ($i = 0; $i < $num_records; $i++) {
                $html .= '<tr>';
    
                if ($i === 0) {
                    $html .= '<td style="border: 1px solid black; padding: 2px;" rowspan="' . $num_records . '">' . $row['stud_no'] . '</td>
                              <td style="border: 1px solid black; padding: 2px;" rowspan="' . $num_records . '">' . $row['last_name'] . '</td>
                              <td style="border: 1px solid black; padding: 2px;" rowspan="' . $num_records . '">' . $row['first_name'] . '</td>
                              <td style="border: 1px solid black; padding: 2px;" rowspan="' . $num_records . '">' . $row['mid_name'] . '</td>
                              <td style="border: 1px solid black; padding: 2px;" rowspan="' . $num_records . '">' . $row['suffix'] . '</td>
                              <td style="border: 1px solid black; padding: 2px;" rowspan="' . $num_records . '">' . $row['sex'] . '</td>
                              <td style="border: 1px solid black; padding: 2px;" rowspan="' . $num_records . '">' . $row['program'] . '</td>';
                }
    
                $html .= '<td style="border: 1px solid black; padding: 2px; text-align:right">' . $row['record'][$i]['course_code'] . '</td>
                          <td style="border: 1px solid black; padding: 2px;  text-align:right">' . $row['record'][$i]['unit'] . '</td>
    
                      </tr>';
                $total_unit += $row['record'][$i]['unit'];
            }
    
            // Insert Total Unit column for each student
            $html .= '
                        <td style="border: 1px solid black; padding: 2px; text-align: right;" colspan="8"><strong>Total Unit:</strong></td>
                        <td style="border: 1px solid black; padding: 2px; text-align: center;"><strong>' . $total_unit . '</strong></td>
                    ';
        }
    
        $html .= '</tbody>
                <tfoot>
                    <tr>
                        <td colspan="9" style="border-top: 1px solid black;"></td>
                    </tr>
                </tfoot>
            </table>
        </div>';
    
        $finalHtml = $headerHtml . $html;
    
        $pdf->set_option('isHtml5ParserEnabled', true);
        $pdf->set_option('isRemoteEnabled', true);
        $pdf->set_option('isPhpEnabled', true);
        $pdf->set_option('autoScriptToSize', true);
        $pdf->loadHtml($finalHtml);
        $pdf->render();
    
        $pdf->stream('filename.pdf');
    }
        


}

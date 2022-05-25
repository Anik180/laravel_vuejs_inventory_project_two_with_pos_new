<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class SalaryController extends Controller
{
    public function paid(Request $request,$id)
    {
    	$validateData = $request->validate([
         'month' => 'required',
       ]);

    	$month = $request->month;
    	$check = DB::table('salaries')->where('employee_id',$id)->where('month',$month)->first();

    	if ($check) {
    		return response()->json('Salary Already Paid');
    	}else{
        $data = array();
    	$data['employee_id'] = $id;
    	$data['amount'] = $request->sallery;
    	$data['date'] = date('d/m/Y');
    	$data['month'] = $month;
    	$data['year'] = date('Y');
    	DB::table('salaries')->insert($data);
    	}


    	
    }
    public function allSalary()
    {
    	$salary = DB::table('salaries')->select('month')->groupBy('month')->get();
    	return response()->json($salary);
    }
    public function viewSalary($id)
    {
      $month = $id;
      $view = DB::table('salaries')
              ->join('employees','salaries.employee_id','employees.id')
              ->select('employees.name','salaries.*')
              ->where('salaries.month',$month)
              ->get();
              return response()->json($view);
    }

    public function editSalary($id)
    {
    	  	$edit = DB::table('salaries')
  			->join('employees','salaries.employee_id','employees.id')
  			->select('employees.name','employees.email','salaries.*')
  			->where('salaries.id',$id)
  			->first();
  			return response()->json($edit);
    }

    public function updateSalary(Request $request,$id)
    {
    	$data = array();
       	$data['employee_id'] = $request->employee_id;
    	$data['amount'] = $request->amount;
    	$data['date'] = date('d/m/Y');
    	$data['month'] = $request->month;
    	$data['year'] = date('Y');
        DB::table('salaries')->where('id',$id)->update($data);
    }
}

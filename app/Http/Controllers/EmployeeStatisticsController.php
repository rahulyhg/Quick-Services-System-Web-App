<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Lava;
use DB;

class EmployeeStatisticsController extends Controller {
    
    public function sales()
    {
        $employeeTable = Lava::DataTable();
        
        $employeeTable->addStringColumn('Sales')
            ->addNumberColumn('Percent');
            
        $sales = DB::table('transaction_details')
                ->where('type','=','sale')
                ->join('transactions','transaction_details.transaction_id','=','transactions.id')
                ->join('employees','transactions.employee_id','=','employees.id')
                ->groupBy('transactions.employee_id')
                ->select(DB::RAW('count(employees.name) as freq, employees.name'))
                ->orderBy('freq','desc')
                ->get();
        
        
        //dd($sales);
       
        foreach($sales as $sale){
            
           $employeeTable->addRow(array($sale->name,intval($sale->freq))); 
        }
        
        $chart = Lava::PieChart('Sales');
        $chart->datatable($employeeTable);
        
        
        return view('pages.viewEmployeeSalesStatistics',['chart' => $chart]);
    }
    
    public function listSales()
    {
            
        $sales = DB::table('employees')
                ->leftJoin('transactions','employees.id','=','transactions.employee_id')
                ->leftJoin('transaction_details', function($join){
                    $join->on('transactions.id','=','transaction_details.transaction_id')
                            ->where('transaction_details.type','=','sale');
                })
                ->join('stations','employees.station_id','=','stations.id')
                ->join('locations','employees.location_id','=','locations.id')
                ->select(DB::RAW('sum(transaction_details.total_price) as total_sales_value, '
                        . 'sum(transaction_details.quantity) as total_products_sold, employees.name,'
                        . 'employees.id, stations.name as station_name, locations.name as location_name'))
                ->groupBy('employees.id')
                ->orderBy('total_products_sold','desc')
                ->get();      
        
        return view('pages.listEmployeeSalesStatistics',['employees' => $sales]);
    }
    
     public function salesIncome()
    {
        $employeeTable = Lava::DataTable();
        
        $employeeTable->addStringColumn('Sales')
            ->addNumberColumn('Percent');
            
        $sales = DB::table('transaction_details')
                ->where('type','=','sale')
                ->join('transactions','transaction_details.transaction_id','=','transactions.id')
                ->join('employees','transactions.employee_id','=','employees.id')
                ->groupBy('transactions.employee_id')
                ->select(DB::RAW('sum(transaction_details.total_price) as freq, employees.name'))
                ->orderBy('freq','desc')
                ->get();
        
        
        //dd($sales);
       
        foreach($sales as $sale){
            
           $employeeTable->addRow(array($sale->name,intval($sale->freq))); 
        }
        
        $chart = Lava::PieChart('Sales');
        $chart->datatable($employeeTable);
        
        
        return view('pages.viewEmployeeSalesStatistics',['chart' => $chart]);
    }
    
    public function services()
    {
        $employeeTable = Lava::DataTable();
        
        $employeeTable->addStringColumn('Services')
            ->addNumberColumn('Percent');
            
        $services = DB::table('services')
                ->join('employees','services.employee_id','=','employees.id')
                ->groupBy('services.employee_id')
                ->select(DB::RAW('count(employees.name) as freq, employees.name'))
                ->orderBy('freq','desc')
                ->get();
        
        
        //dd($sales);
       
        foreach($services as $service){
            
           $employeeTable->addRow(array($service->name,intval($service->freq))); 
        }
        
        $chart = Lava::PieChart('Services');
        $chart->datatable($employeeTable);
        
        
        return view('pages.viewEmployeeServicesStatistics',['chart' => $chart]);
    }
    
}

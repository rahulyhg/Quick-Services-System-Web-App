<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\ServiceType;
use App\DefaultReminderPreference;

class DefaultReminderPreferencesController extends Controller {
    
    public function index()
    {
        $preferences = DefaultReminderPreference::all();
        $preferences->load('type');
       
        return view('pages.listDefaultReminderPreferences', ['preferences' => $preferences]);
    }
    
    public function add()
    {
        $types = ServiceType::all();
        
        return view('pages.addDefaultReminderPreference', ['serviceTypes' => $types]);
    }
    
    public function store(Request $request)
    {
        $preference = DefaultReminderPreference::create($request->all());
        $preference->save();
        
        return redirect('services/preferences');
    }
    
}

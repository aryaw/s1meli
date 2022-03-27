<?php

namespace Site\Controllers;

use App\Jobs\GenerateSuggestionImage;
use Cms\Valentine\Http\Models\ActivityModel;
use Cms\Valentine\Http\Models\HistoryModel;
use Cms\Valentine\Http\Models\LocationModel;
use Cms\Valentine\Http\Models\PeriodModel;
use Cms\Valentine\Http\Models\ResultModel;
use Cms\Valentine\Http\Models\SuggestionModel;
use Cms\Valentine\Http\Models\TimeModel;
use Cms\Valentine\Http\Models\WinnerModel;
use Illuminate\Http\Request;
use Site\Libraries\Valentine;
use Sentinel;
use Validator;
use Session;
use Storage;

class ValentineController
{		    

    public function index(Request $request){
        $valentine = new Valentine();
        $rescan = ($request->get('rescan') && $request->get('rescan') == 'true') ? true : false;        
        $suggestion = $valentine->getSuggestion();
        $locations = LocationModel::orderBy('id','asc')->get();
        $times = TimeModel::orderBy('id','asc')->get();
        $activities = ActivityModel::orderBy('id','asc')->get(); 
        
        // generate disini aja
        if(!$suggestion->image){
            GenerateSuggestionImage::dispatch($suggestion);
        }

        return view('site::valentine.index', [
            'title' => '',
            'suggestion' => $suggestion,
            'locations' => $locations,
            'times' => $times,
            'activities' => $activities,
            'rescan' => ($rescan) ? 'true' : 'false',
        ]);
    }

    public function result(Request $request){
        $valentine = new Valentine();
        $session = $valentine->getSession();
        
        // flow baru, bisa berkali2
        if(Sentinel::getUser()){
            $valentineResult = ResultModel::where('user_id', Sentinel::getUser()->id)->first();
            if($valentineResult){
                $historyId = $valentine->getSessionHistory();
                $history = HistoryModel::where('id',$historyId)
                    ->where('session',$session)
                    ->with(['suggestion']) 
                    ->first();
                if($history && $history->suggestion){
                    return redirect()->route('site.planmydate.thanks', ['slug'=>$history->suggestion->slug]);
                }                
            }
        }

        // check session
        if(!$session){
            return redirect()->route('site.planmydate');
        }
        
        // check period
        $period = PeriodModel::whereRaw(' ? BETWEEN start AND end ', [date('Y-m-d')])->first();        
        if(!$period){
            $request->session()->flash('message', 'Periode event tidak ditemukan');
            return redirect()->route('site.notification');
        }        

        // get suggestion based on session history
        $historyId = $valentine->getSessionHistory();
        $history = HistoryModel::where('id',$historyId)
            ->where('session',$session) 
            ->first(); 
        if($history){
            $suggestion = SuggestionModel::where('id',$history->suggestion_id)
                ->with(['location','time','activity'])
                ->first();
            return view('site::valentine.result', [
                'title' => '',
                'suggestion' => $suggestion,
                'journey_type' => $period->journey_type,
            ]);
        }

        return redirect()->route('site.planmydate');
    }

    public function submit(Request $request){
        $post = $request->post();
        $rules = [ 'reason' => 'nullable' ];
        $period = PeriodModel::whereRaw(' ? BETWEEN start AND end ', [date('Y-m-d')])->first();
        if($period){
            if($period->journey_type == 'before'){
                ##$rules = [ 'reason' => 'required|min:10|max:250' ]; flow baru
            }            
        }else{
            return redirect()->route('site.index');
        }
        $validate = Validator::make($post, $rules);
        if ($validate->fails()) {
            $errors = $validate->messages();            
            $post['error'] = $errors->all();
            return redirect()->route('site.planmydate.result')
                ->withErrors($validate)
                ->withInput($post);        	
        } else {
            $valentine = new Valentine();        
            $session = $valentine->getSession();
            $historyId = $valentine->getSessionHistory();

            // update history status to submit
            $history = HistoryModel::where('id',$historyId)
                ->where('session',$session) 
                ->first();
            if($history){
                $history->status = 'submit';
                $history->save();

                // update suggestion status to used
                $suggestion = SuggestionModel::where('id', $history->suggestion_id)->first();
                if($suggestion){
                    $suggestion->status = 'used';
                    $suggestion->hold_time = NULL;
                    $suggestion->used_time = date('Y-m-d H:i:s');
                    $suggestion->save();
                    
                    // ini gak jadi
                    $slug = slugify(Sentinel::getUser()->name);
                    $result = ResultModel::where('slug', $slug)->first();
                    if($result){
                        $slug = $slug.'-'.time();
                    }

                    // save experience
                    ResultModel::create([
                        'suggestion_id' => $suggestion->id,
                        'period_id' => $period->id,
                        'user_id' => Sentinel::getUser()->id,
                        'reason' => '',
                        'slug' => $slug,
                        #'reason' => $post['reason'],
                    ]);

                    ##$valentine->removeSession(); remove dulu, ganti flow
                                        
                    return redirect()->route('site.planmydate.thanks',['slug'=>$suggestion->slug]);
                }
            }
        }                      

    }

    public function thanks($slug, Request $request){        
        if($request->get('fbclid')){
            return redirect()->route('site.index');
        }

        $suggestion = SuggestionModel::where('slug', $slug)->first();
        if(!$suggestion){
            abort(404);
        }

        $location = ($suggestion->location) ? $suggestion->location->name : '';
        $time = ($suggestion->time) ? $suggestion->time->name : '';
        $activity = ($suggestion->activity) ? $suggestion->activity->name : '';
        $suggestionText = generateExperience($activity, $time, $location);

        return view('site::valentine.thanks', [
            'title' => '',
            'suggestion' => $suggestion,
            'suggestion_text' => $suggestionText,
            'meta_description' => $suggestionText,
            'meta_image' => ($suggestion->image) ? Storage::url($suggestion->image) : '',
        ]);
    }

    public function winner(){
        $winners = WinnerModel::with(['result','result.suggestion','result.user'])->get();

        return view('site::valentine.winner', [
            'title' => 'Winner',
            'winners' => $winners,
        ]);  
    }

}
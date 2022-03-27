<?php

namespace Cms\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Http\Controllers\Controller;
use Cms\Setting\Facades\SettingFacade;

use Cms\Setting\Http\Models\SettingModel;
use File;
use Storage;

class SettingController extends Controller
{		

	public function index()
	{
        #Setting::setting('admin.title');

        $groups = SettingModel::select('group')->groupBy('group')->get();
        $settingModel = SettingModel::get();
        $settings = [];
        foreach($settingModel as $setting){
            $settings[$setting->group][] = $setting;
        }

		return view('setting::index', [
            'groups' => $groups,
            'settings' => $settings,
            'setting_types' => config('app.constants.setting_types'),
        ]);
	}

	public function store(Request $request){		
        $post = $request->input();                    
        
        $validate = Validator::make($post, [
            'key' => [
                'required',
                'max:190',
                function ($attribute, $value, $fail) use($request) {
                    $group = $request->post('group');
                    $key = $this->transformKey($group, $value);                    
                    $setting = SettingModel::where('key',$key)->first();
                    if ($setting) {
                        $fail($attribute.' already exists.');
                    }
                },
            ],
            'name' => 'required|max:250',
            'type' => 'required|max:190',
            'group' => 'required|max:190',
        ]);

        if ($validate->fails()) {
            $errors = $validate->messages();
            $post['error'] = $errors->all();

            return redirect()->route('cms.setting.view')
                ->withErrors($validate)
                ->withInput($post);        	
        } else {
        	SettingModel::create([
        		'key' => $this->transformKey($post['group'],$post['key']),
                'name' => $post['name'],
                'type' => $post['type'],
                'group' => $post['group'],
        	]);
            $request->session()->flash('message', __('cms.create_success'));
            return redirect()->route('cms.setting.view');
        }
	}

    private function transformKey($group, $value){
        return strtolower($group).'.'.$value;                    
    }


	public function update(Request $request){
        $settings = SettingModel::get();
        $post = $request->all();
        $niceNames = [];

        foreach($settings as $setting){
            $rule = 'nullable';
            if($setting->type == 'image'){
                $rule .= '|max:3000|mimetypes:image/jpeg,image/png,image/jpg,image/gif';
            }
            $rules['settings.'.$setting->id] = $rule;
            $niceNames['settings.'.$setting->id] = '';
        }        
        $validate = Validator::make($post, $rules);                
        $validate->setAttributeNames($niceNames);
        if ($validate->fails()) {
            $errors = $validate->messages();
            $post['error'] = $errors->all();
            return redirect()->route('cms.setting.view')
                ->withErrors($validate)
                ->withInput($post);         
        } else {
            $postSettings = $post['settings'];
            foreach($settings as $setting){                
                $value = '';
                if($setting->type == 'image'){
                    $value = $setting->value;
                }

                if(isset($postSettings[$setting->id])){
                    $value = $postSettings[$setting->id];
                    if($setting->type == 'image'){                        
                        if ($postSettings[$setting->id]->isValid()) {
                            $date = strtotime(date('Y-m'));
                            $image = $postSettings[$setting->id]->store('admin/settings/'.$date);
                            if($image){
                                $value = $image;                                
                                Storage::delete($setting->value);
                            }
                        }
                    }
                }

                $setting->value = $value;
                $setting->save();

                // do empty cache
                SettingFacade::forgetSetting();
            }  

            $request->session()->flash('message', __('cms.update_success'));
            return redirect()->route('cms.setting.view');
        }        
	}
    
    public function delete($id, Request $request){
        $setting = SettingModel::find($id);
        if(!$setting){
            abort(404);
        }else{
            if($setting->is_deletable == 'no'){
                $request->session()->flash('error', 'Cannot delete default app value');
            }else{
                $setting->delete();
                $request->session()->flash('message', __('cms.delete_success'));
            }
            
            return redirect()->route('cms.setting.view');
        }
    }
}


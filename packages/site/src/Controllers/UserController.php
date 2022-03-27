<?php

namespace Site\Controllers;

use Illuminate\Http\Request;
use Mail;
use Validator;
use Activation;
use App\Mail\ForgotPassword;
use App\Mail\UserActivation;
use Cms\User\Http\Models\LoginTypeModel;
use Cms\User\Http\Models\UserModel;
use Reminder;
use Sentinel;
use Socialite;
use Log;
use Site\Libraries\Valentine;
use Config;
use DB;

class UserController
{		

	public function register(){
		return view('site::register');
	}

	public function doRegister(Request $request){	
		$post =$request->post();	
		$rules = [
			'email' => 'required|email|gmail_check|min:3|max:90',            
			'password' => 'required|min:5|max:190',
			'first_name' => 'required|regex:/^[a-zA-Z0-9\s]+$/|min:2|max:50',
			##'password_confirmation' => 'required|same:password',
			##'last_name' => 'required|min:2|max:190',
			#'recaptcha_response' => 'required|google_recaptcha'
		];
		$messages = [
			'gmail_check' => 'Email sudah terdaftar.',
			'google_recaptcha' => 'Recaptcha response failed',
			'regex' => 'first name hanya boleh berisi huruf dan angka'
		];

		$validator = Validator::make($post, $rules, $messages);
		if ($validator->fails()) {
			$errors = $validator->messages();
            $post['error'] = $errors->all();
            return redirect()->route('site.register')
                ->withErrors($validator)
                ->withInput($post);  
		}else{
			$role = Sentinel::findRoleBySlug('user');
			if(!$role){
				$role = Sentinel::getRoleRepository()->createModel()->create([
					'name' => 'User',
					'slug' => 'user',
				]);
			}

			// email gmail
			$emailGmail = '';
			$arrEmail = explode('@', strtolower($post['email']));
			if(isset($arrEmail[1])){
				if($arrEmail[1]=='gmail.com' || $arrEmail[1]=='googlemail.com'){
					$validString = str_replace('.', '', $arrEmail[0]);
					$emailGmail = $validString.'@'.$arrEmail[1];
				}
			}

			$user = Sentinel::register(array(
				'email'    => strtolower($post['email']),
				'password' => $post['password'],
				'name' => isset($post['last_name']) ? ($post['first_name'].' '.$post['last_name']) : $post['first_name'],
				'first_name' => $post['first_name'],
				'last_name' => isset($post['last_name']) ? $post['last_name'] : '',
				'email_gmail' => strtolower($emailGmail),
			));

			if($user){
				// add login type
				LoginTypeModel::create([
					'user_id' => $user->id,
					'type' => 'default',						
					'name' => $user->name,
					'first_name' => $user->first_name,
					'last_name' => $user->last_name,
				]);

				// add to user role
				$role->users()->attach($user);

				// create sentinel user activation
				$activation = Activation::create($user);

				// Send Email 
				$url = route('site.activate', ['token' => $activation->code]);
				Mail::to($user->email)->queue(new UserActivation($url));
				$fail = Mail::failures();
				if ($fail) {
					$error = $fail[0];
					Log::error('UserController.doRegister(): '.json_encode($error[0]));
				}

				$request->session()->flash('message', __('app.register_success'));
            	return redirect()->route('site.notification');
			}			
		}	
	}

	public function hoam($email){
		if(preg_match('(@yahoo|@outlook)', $email) === 1) {
			return true;
		}
		return false;		
	}

	public function login(Request $request)
	{		
		$status = false;
		$redirect = route('site.planmydate');
		$error = '';
		$validationErrors = [];
		try{			
			$post = $request->post();
			$rules = array(
	            'email' => 'required',
	            'password' => 'required',
	        );
			$validator = Validator::make($post, $rules);
			$validator->after(function ($validator) use($post){
				if(!empty($post['email'])){					
					$user = UserModel::where('email', $post['email'])->first();
					if($user){
						$loginType = LoginTypeModel::where('type','default')
							->where('user_id', $user->id)
							->first();
						if(!$loginType){
							$validator->errors()->add('password', 'Email sudah terdaftar tetapi menggunakan login media sosial');
						}
					}
				}
			});
	        if ($validator->fails()) {
	            $errors = $validator->errors();
	            $idArays = [            	
	            	'email' => 'inputLoginEmail',
	            	'password' => 'inputLoginPassword',
	            ];
	            foreach($rules as $k=>$v){
	                if($errors->has($k)){
	                	$field = (isset($idArays[$k])) ? $idArays[$k] : $k;
	                    $validationErrors[] = ['field'=>$field,'message'=>$errors->get($k)[0]];
	                }
	            }
	        }else{
	        	$credentials = [
				    'login'    => $post['email'],
				    'password' => $post['password'],
				];				

				$user = Sentinel::authenticate($credentials);
				if($user){
					Sentinel::login($user);
					$status = true;

					$valentine = new Valentine();
        			$session = $valentine->getSession();  
					if($session){
						$redirect = route('site.planmydate.result');						
					}
				}else{
					$validationErrors[] = ['field'=>'inputLoginPassword','message'=>'Email atau password salah'];
				}
	        }
        } catch(\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e){
            $error = $e->getMessage();
        } catch(\Cartalyst\Sentinel\Checkpoints\ThrottlingException $e){
            $error = $e->getMessage();
        } catch(\Exception $e){
        	$error = $e->getMessage();
        }

        return response()->json([
        	'validation_errors' => $validationErrors,
        	'error' => $error,
        	'status' => $status,
        	'redirect' => $redirect,
        ]);

	}

    public function logout(Request $request)
    {
		Sentinel::logout();
		$request->session()->flush();
		return redirect('/');
    }
    
    public function activate($token, Request $request)
    {
		$activation = Activation::createModel()->where('code', $token)->first();
		$result = 'Activation Not found';
		
        if($activation){
            $user = Sentinel::findById($activation->user_id);            
            if ($activation = Activation::completed($user))
            {
                $result = 'Akun Anda Sudah Aktif. Silahkan <a href="'.route('site.index').'"><u>login</u></a>.';
            }
            else{
                // Activation not found or not completed
                #$activate = Activation::complete($user, $token);

                // baru (package nya ada expired date activation nya, belum tau cara setnya. sementara gini dulu)
                $activationModel = Activation::createModel();
                $activation = $activationModel::where('user_id', $user->id)
                    ->where('code', $token)
                    ->where('completed', false)                    
                    ->first();                    
                        
                if($activation){
                    // baru
                    $activation->fill([
                        'completed'    => true,
                        'completed_at' => date('Y-m-d H:i:s'),
                    ]);
                    $activation->save();

					$result = 'Akun berhasil diaktifkan. Silahkan <a href="'.route('site.index').'"><u>login</u></a>.';
					##$request->session()->flash('login_message', $result);
					##return redirect()->route('site.index');
                }else{
                    $result = "Akun Gagal Diaktifkan.";
                }
            }            
		}		
        return view('site::notification', ['message'=>$result]);
    }
    
    public function redirectToProvider($provider, Request $request)
    {   
		$error = false;

		// check exception
		try{
			$credentials = [
				'login'    => 'user@gmail.com',
				'password' => 'asdfasdf',
			];				
			Sentinel::authenticate($credentials);

			// tes pake environment package
			/* if($provider == 'facebook'){
				config(['services.facebook.client_id' => envi('facebook_client_id')]);
				config(['services.facebook.client_secret' => envi('facebook_client_secret')]);
				$config = config('services.facebook');
				return Socialite::buildProvider(\Laravel\Socialite\Two\FacebookProvider::class, $config)->redirect();					
			}else if($provider == 'google'){
				config(['services.google.client_id' => envi('google_client_id')]);
				config(['services.google.client_secret' => envi('google_client_secret')]);
				$config = config('services.google');
				return Socialite::buildProvider(\Laravel\Socialite\Two\GoogleProvider::class, $config)->redirect();
			} */			
			#return redirect()->route('site.index');
		}catch(\Cartalyst\Sentinel\Checkpoints\ThrottlingException $e){			
			$error = true;            
		}	
		
		if(!$error){
			return Socialite::driver($provider)->redirect();
		}else{
			$request->session()->flash('message', $e->getMessage());
			return redirect()->route('site.notification');
		}
	}

	// akalin delete throttle :)
	private function removeThrottle($ip){
		if($ip){
			DB::table('throttle')->where('ip', $ip)->delete();
		}		
	}

    public function handleProviderCallback($provider, Request $request)
    {	
		if(in_array($provider, ['facebook','google'])){

			if($provider=='facebook'){
                $socialite = Socialite::driver($provider)
                    ->fields([
                        'name', 
                        'first_name', 
                        'last_name', 
                        'email',
                        'gender',
					])
					->stateless()
                    ->user();
            }else{
                $socialite = Socialite::driver($provider)->stateless()->user();
			}
            
			if($socialite && $socialite->user && $socialite->email){
				$userSocialite = $socialite->user;

				// check id
				$conditions = [];
				if($provider == 'facebook'){
					$user = UserModel::where('facebook_id', $socialite->id)->first();
					$conditions['first_name'] = isset($userSocialite['first_name']) ? $userSocialite['first_name'] : '';
					$conditions['last_name'] = isset($userSocialite['last_name']) ? $userSocialite['last_name'] : '';
				}else if($provider == 'google'){
					$user = UserModel::where('google_id', $socialite->id)->first();
					$conditions['first_name'] = isset($userSocialite['given_name']) ? $userSocialite['given_name'] : '';
					$conditions['last_name'] = isset($userSocialite['family_name']) ? $userSocialite['family_name'] : '';
				}

				// planmydate session 				
				$valentine = new Valentine();
        		$session = $valentine->getSession();  

				// if exists then login
				if(isset($user) && $user){
					Sentinel::login($user);
					$this->removeThrottle($request->getClientIp());
					if($session){
						return redirect()->route('site.planmydate.result');
					}
					return redirect()->route('site.index');
				}else{					
					$user = UserModel::where('email', $socialite->email)
						->with(['activation'])
						->first();
					// email not found then do register
					if(!$user){						
						// gmail email check
						$emailGmail = '';
						$arrEmail = explode('@', $socialite->email);
			            if(isset($arrEmail[1])){
			                if($arrEmail[1]=='gmail.com' || $arrEmail[1]=='googlemail.com'){
			                    $validString = str_replace('.', '', $arrEmail[0]);
			                    $emailGmail = $validString.'@'.$arrEmail[1];
			                    $user = UserModel::where('email_gmail', $emailGmail)->first();
			                    if($user){
			                    	$request->session()->flash('message', 'gmail email sudah digunakan');
			                        return redirect()->route('site.notification');
			                    }
			                }
			            }

						// register data
			            $dataRegister = [
							'email'    => $socialite->email,
							'name' => $userSocialite['name'],
						    'password' => $socialite->email.time(),
						    'email_gmail' => $emailGmail,
						];
			            if($provider == 'facebook'){							
							$dataRegister['facebook_id'] = $socialite->id;
							$dataRegister['first_name'] = isset($userSocialite['first_name']) ? $userSocialite['first_name'] : '';
							$dataRegister['last_name'] = isset($userSocialite['last_name']) ? $userSocialite['last_name'] : '';
						}else if($provider == 'google'){
							$dataRegister['google_id'] = $socialite->id;
							$dataRegister['first_name'] = isset($userSocialite['given_name']) ? $userSocialite['given_name'] : '';
							$dataRegister['last_name'] = isset($userSocialite['family_name']) ? $userSocialite['family_name'] : '';							
						}

						$register = Sentinel::registerAndActivate($dataRegister);
						if($register){
							// add login type
							LoginTypeModel::create([
								'user_id' => $register->id,
								'social_id' => $socialite->id,
								'type' => strtolower($provider),
								'name' => $register->name
							] + $conditions);

							// add to user role
							$role = Sentinel::findRoleBySlug('user');
							$role->users()->attach($register);
							
							// do login						
							Sentinel::login($register);
							$this->removeThrottle($request->getClientIp());
							if($session){
								return redirect()->route('site.planmydate.result');
							}
							return redirect()->route('site.index');							
						}						
					}else{ // email already register but register as other type login

						// cek kalo pake email register biasa belum di aktivasi, pake sosmed langsung diaktifin
						if($user->activation && !$user->activation->completed){
							$sentinelUser = Sentinel::findById($user->id);
							$activation = Activation::completed($sentinelUser);
							if (!$activation){
								$activationModel = Activation::createModel();
								$activation = $activationModel::where('user_id', $user->id)
									->where('completed', false)                    
									->first();                    
										
								if($activation){
									$activation->fill([
										'completed'    => true,
										'completed_at' => date('Y-m-d H:i:s'),
									]);
									$activation->save();
								}else{
									$request->session()->flash('message', 'Terjadi error saat aktivasi akun.');
									return redirect()->route('site.notification');
								}
							}
						}

						$loginType = LoginTypeModel::where('user_id', $user->id)
							->where('type', $provider)
							->first();
						if(!$loginType){
							LoginTypeModel::create([
								'user_id' => $user->id, 
								'social_id' => $socialite->id,
								'type' => strtolower($provider),
								'name' => $userSocialite['name'],								
							] + $conditions);
						}else{
							$loginType->social_id = $socialite->id;
							$loginType->save();
						}

						if($provider == 'facebook'){
							$user->facebook_id = $socialite->id;
						}else if($provider == 'google'){
							$user->google_id = $socialite->id;
						}
						$user->save();
						Sentinel::login($user);
						$this->removeThrottle($request->getClientIp());
						if($session){
							return redirect()->route('site.planmydate.result');
						}
						return redirect()->route('site.planmydate');

						/* if($user->activation && $user->activation->completed){
						}else{ // return account not activated, sebelumnya register biasa blum activasi trus social media login
							$request->session()->flash('message', 'Akun Anda belum diaktifkan');
							return redirect()->route('site.notification');
						} */
					}
				}	
			}else{				
				$request->session()->flash('social_login_error', "Akun {$provider} Anda tidak menyediakan akses email");
				return redirect()->route('site.register');				
			}
		}
	}
	
	

	public function forgotPassword(){
		return view('site::forgot_password');
	}
    
    public function doForgotPassword(Request $request)
    {
		$post = $request->post();
		$rules = [
			'email' => 'required|email|email_check_forgot'
		];
		$messages = [
			'email_check_forgot'=>'Email not found'
		];		
		$validator = Validator::make($post, $rules, $messages);
		if ($validator->fails()) {
			$errors = $validator->messages();
            $post['error'] = $errors->all();
            return redirect()->route('site.forgot_password')
                ->withErrors($validator)
                ->withInput($post);  
		}else{
			$user = Sentinel::findByCredentials(['login' => $post['email']]);
			if($user){
				$reminder = Reminder::exists($user);
				if(!$reminder){
					$reminder = Reminder::create($user);
				}
				if($reminder){
					$url = route('site.reset.form', ['token' => $reminder->code]);
					Mail::to($user->email)->queue(new ForgotPassword($url));
					$fail = Mail::failures();
					if ($fail) {
						$error = $fail[0];
						Log::error('UserController.doForgotPassword(): '.json_encode($error[0]));
					}
				}
				
				$request->session()->flash('success', 'Success');
            	return redirect()->route('site.forgot_password');
			}			
		}	
	}
	
    public function resetPasswordForm($code)
    {
        $reminderModel = Reminder::createModel();
        $reminder = $reminderModel::where('code',$code)->first();
        if(!$reminder){            
            return view('site::notification', ['message'=>'Invalid link']);
        }
        if($reminder && $reminder->completed == 1){     
			#return redirect()->route('site.index');
            return view('site::notification', ['message'=>'Completed.']);
        }
        return view('site::reset_password', ['code'=>$code]);
    }

    public function resetPassword($code, Request $request)
    {
    	$post = $request->post();  
    	$rules = [
            'password' => 'required|min:5|max:190',
            'password_confirmation' => 'required|same:password',
        ];
    	$validator = Validator::make($post, $rules);
        if ($validator->fails()) {
        	return redirect()->route('site.reset.form', [$code])
                ->withErrors($validator)
                ->withInput($post);
        }else{
        	$reminderModel = Reminder::createModel();
            $reminder = $reminderModel::where('code',$code)->first();
            if($reminder && $reminder->completed == 1){
				$request->session()->flash('login_message', 'Reset password berhasil');
                return redirect()->route('site.index');
            }else{
            	// akalin expired
                $user = Sentinel::findById($reminder->user_id);
                $update = Sentinel::update($user, ['password' => $post['password']]);
                if($update){
                    $reminder->completed = 1;
                    $reminder->completed_at = date("Y-m-d H:i:s");
                    $reminder->save();
                }
                $request->session()->flash('login_message', 'Reset password berhasil');
                return redirect()->route('site.index');
            }
        }
    }



}
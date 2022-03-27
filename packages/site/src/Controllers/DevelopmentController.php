<?php

namespace Site\Controllers;

use App\Mail\UserActivation;
use Illuminate\Http\Request;
use Mail;
use Cms\User\Http\Models\UserModel;
use Cms\Valentine\Http\Models\ActivityModel;
use Cms\Valentine\Http\Models\LocationModel;
use Cms\Valentine\Http\Models\PeriodModel;
use Cms\Valentine\Http\Models\SuggestionModel;
use Cms\Valentine\Http\Models\TimeModel;
use Cms\Valentine\Libraries\SuggestionGenerator;
use Storage;
use Socialite;
use Intervention\Image\Facades\Image;

class DevelopmentController
{	

    /**
	 * For Development
	 */
	public function session(Request $request){		
		dd($request->session()->all());
	}
	public function sessionDestroy(Request $request){
		$request->session()->flush();
	}
	public function tes(){
		/*$role = Sentinel::getRoleRepository()->createModel()->create([
		    'name' => 'Adminstrator',
		    'slug' => 'administrator',
		])

		$credentials = [
		    'email'    => 'admin@venom.com',
		    'password' => '43lW9rj2!',
		];

		$user = Sentinel::registerAndActivate($credentials);

		$role = Sentinel::findRoleByName('Adminstrator');

		$role->users()->attach($user);*/
		return view('site::tes');
	}

	public function email(){
		$user = UserModel::find(2);
		$url = route('site.activate', ['token' => 'FZkqLraGdVhzLHSkj2fFZ5laVcthxEWP']);
		
		Mail::to($user->email)
			->queue(new UserActivation($url));

		$fail = Mail::failures();					
		if ($fail) {						
			dd($fail);
		}else{
			dd('success');
		}
	}
	
	public function image(){
		$generator = new SuggestionGenerator();
		$suggestion = SuggestionModel::find(21748);
		$activity = ActivityModel::find(1);
		$time = TimeModel::find(2);
		$location = LocationModel::find(2);
		$gen = $generator->generateImage($suggestion, $activity, $time, $location);
		dd($gen);
		dd('die 1');
		$imageBackground = public_path('img/love.png');
		#$img = Image::make($imageBackground)->save(public_path('storage/valentine/location/temp.png'));
		#dd(public_path('storage/valentine/location/temp.png'));
		$fontFile = public_path('css/c5fc2b05949b051c07482453e8e0c1e6.ttf');
		$text = 'Nonton konser saat Matahari terbenam di belakang mobil';
		$height = 822;
		$width = 1277;
		$yText = ($height / 3) + 20;
		$filename = public_path('storage/frame/public.png');
		
		$delimiter = '||';
		$wrapString = wordwrap($text, 30, $delimiter);
		$wrapArray = explode($delimiter, $wrapString);		
		
		$img = Image::make($imageBackground);
		foreach($wrapArray as $txt){
			$img->text($txt, ($width/2), $yText, function($font) use($fontFile){ 
				$font->file($fontFile);
				$font->size(24);  
				$font->color('#FFFFFF');
				$font->align('center');
				$font->valign('top');
				#$font->angle(0);  
			});
			$yText += 30;			
		}
		
		$img->save($filename);

		// image
		$x3 = (int) ($width/2);
		$y3 = (int) ($height / 2) + 70;
		
		$x1 = (int) ($width/2) - 100;
		$y1 = (int) $y3 - 100;
		
		$x2 = (int) ($width/2) - 100;
		$y2 = $y1;

		$imgValue = 100;

		// image 1
		$imageResize1 = Image::make(public_path('storage/frame/activity.png'))
			->resize($imgValue, null, function ($constraint) {
				$constraint->aspectRatio();
			});
		$img = Image::make($filename)
			->insert($imageResize1, 'top-left', $x1, $y1)
			->save($filename);
			

		// image 2
		$imageResize2 = Image::make(public_path('storage/frame/time.png'))
			->resize($imgValue, null, function ($constraint) {
				$constraint->aspectRatio();
			});
		$img = Image::make($filename)
			->insert($imageResize2, 'top-right', $x2, $y2)
			->save($filename);

		// image 3	
		$imageResize3 = Image::make(public_path('storage/frame/location.png'))
			->resize($imgValue, null, function ($constraint) {
				$constraint->aspectRatio();
			});	
		$img = Image::make($filename)
			->insert($imageResize3, 'top', $x3, $y3)
			->save($filename);

		$img = Image::make($filename)->resize(600, null, function($constraint){
			$constraint->aspectRatio();
		})
		->save();
		

	   	dd('die');
		#dd(public_path('storage/frame/c5fc2b05949b051c07482453e8e0c1e6.ttf'));


		
						
		/* $img = Image::configure(['driver' => 'gd'])
			->make(asset('storage/frame/bg1.png'))
			->text($text, 100, 100, function($font) use($fontFile){
				$font->size(50);
				$font->file($fontFile);
				$font->color('#FFFFFF');
			})
			->save($filename); */
				
		/* $width = 140; 
		$height = 140; 
		$bottom_image = imagecreatefrompng(asset('storage/frame/bg.png')); 
		$location = imagecreatefrompng(asset('storage/frame/location.png')); 
		imagesavealpha($location, true); 
		imagealphablending($location, false); 
		imagecopyresampled($bottom_image, $location, 290, 125, 0, 0, $width,$height, $width, $height);
		header('Content-type: image/png');
		imagepng($bottom_image);
		imagedestroy($bottom_image); */

		/* return response('Hello World', 200)
                  ->header('Content-Type', 'image/png'); */

		#header('Content-type: image/png');		
		/* $png_image = imagecreate(1080, 1920);
		imagecolorallocate($png_image, 15, 142, 210);		
		#imagecreatefrompng(Storage::disk('public')->get('frame/IG_STORY_TEMPLATE.png'));		
		imagecreatefrompng(asset('storage/frame/IG_STORY_TEMPLATE.png'));
		imagepng($png_image);
		imagedestroy($png_image);
		#return response()->header('Content-Type', 'image/png');
		return response('Hello World', 200)
                  ->header('Content-Type', 'image/png'); */
	}


	public function canvas(){
		return view('site::dev.canvas');
	}
	
	public function socialite(){
		#dd(envi('facebook_client_id'));
		config(['services.facebook.client_id' => envi('facebook_client_id')]);
		config(['services.facebook.client_secret' => envi('facebook_client_secret')]);
		$config = config('services.facebook');
		return Socialite::buildProvider(\Laravel\Socialite\Two\FacebookProvider::class, $config)->redirect();
	}


	private function setEnvironmentValue($values = [])
	{

		$envFile = app()->environmentFilePath();
		$str = file_get_contents($envFile);
		dd($str);

		if (count($values) > 0) {
			foreach ($values as $envKey => $envValue) {

				$str .= "\n"; // In case the searched variable is in the last line without \n
				$keyPosition = strpos($str, "{$envKey}=");
				$endOfLinePosition = strpos($str, "\n", $keyPosition);
				$oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

				// If key does not exist, add it
				if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
					$str .= "{$envKey}={$envValue}\n";
				} else {
					$str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
				}

			}
		}

		$str = substr($str, 0, -1);
		if (!file_put_contents($envFile, $str)) return false;
		return true;

	}

	public function datetime(){		
		dd(now());
	}

	public function info(){
		dd(Storage::url('valentine/location/1577836800/opeciIxUborjuhe7mDhUOV9bMlgBAXmdmm8vnkVt.png'));
		$period = PeriodModel::whereRaw(' ? BETWEEN start AND end ', [date('Y-m-d')])->first();
        dd($period);
		phpinfo();
	}

}
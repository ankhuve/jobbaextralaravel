<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

    protected $redirectPath = '/hitta';
    protected $request;

    /**
     * Create a new authentication controller instance.
     *
     * @param Request $request
     * @internal param \Illuminate\Contracts\Auth\Guard $auth
     * @internal param \Illuminate\Contracts\Auth\Registrar $registrar
     */
	public function __construct(Request $request)
	{
        $this->request = $request;
		$this->middleware('guest', ['except' => 'getLogout']);
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'cv' => 'max:3072|mimes:doc,docx,pdf,rtf,txt',
//            'role' => 'required|integer|in:1',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data)
    {
        // ladda upp CV om vi har något
        if (array_key_exists('cv', $data)) {
            $fileName = $this->handleCVUpload($this->request);
            $data['cv_path'] = $fileName;
        } else{
            $data['cv_path'] = null;
        }

        return User::create([
            'email' => $data['email'],
            'name' => $data['name'],
            'role' => 1, // TEMP: sätt registrering till endast användare för tillfället
            'password' => bcrypt($data['password']),
            'cv_path' => $data['cv_path'],
        ]);
    }

    /**
     *
     * Handle a CV upload request.
     *
     * @param Request $request
     * @return bool
     * @internal param Request $request
     */
    public function handleCVUpload(Request $request)
    {
        if ($request->file('cv')->isValid()) {

            $pathToCVFolder = 'user-cvs/';

            // prepare for upload
            $file = $request->file('cv');
            $userName = str_slug($request->get('name'));
            $disk = Storage::disk('s3');
            $ext = $file->guessExtension();
            $fileName = $userName . '-' . time() . '-CV.' . $ext;

            // Ladda upp filen
            $disk->put($pathToCVFolder . $fileName, file_get_contents($file->getRealPath()));

            return $fileName;

        } else{
            // failed to validate upload, broken file?
            return null;
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->create($request->all());
//        Auth::login($this->create($request->all()));

        return redirect($this->redirectPath())->with('message',
            '<h3>Tack för att du registrerade dig!</h3> 
            Du är nu registrerad i vår databas och är synlig för företag som letar efter just dig.
            <br>Lycka till med jobbsökandet!
            <br><br>Förresten, du vet väl att du alltid kan <a class="text-info" href="' . action('ContactController@create') . '">kontakta oss</a> om du har några frågor?');
    }

}
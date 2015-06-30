<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        $client = new Client(['base_uri' => 'http://api.arbetsformedlingen.se/af/v0/']);
        $searchOptions = array();

        $results = $client->get('platsannonser/soklista/lan', [
            'headers' => [
                'Accept'          => 'application/json',
                'Accept-Language' => 'sv-se,sv'
            ]
        ])->getBody()->getContents();
        $results = json_decode($results);
        array_push($searchOptions, $results);

        $results = $client->get('platsannonser/soklista/yrkesomraden', [
            'headers' => [
                'Accept'          => 'application/json',
                'Accept-Language' => 'sv-se,sv'
            ]
        ])->getBody()->getContents();
        $results = json_decode($results);
        array_push($searchOptions, $results);

//        dd($searchOptions);
        view()->share('searchOptions', $searchOptions);
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}

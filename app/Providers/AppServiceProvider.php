<?php namespace App\Providers;

use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use stdClass;

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

		try{
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

            $results->soklista->sokdata = $this->addCustomJobTypes($results->soklista->sokdata);

			array_push($searchOptions, $results);
			view()->share('searchOptions', $searchOptions);
		} catch(\Exception $e){
			view()->share('afApiError', $e);
		}
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

    private function addCustomJobTypes(array $afJobTypesArray)
    {
        $customJobTypes = array();

        // Övrigt
        $type = new stdClass();
        $type->id = '9000';
        $type->namn = 'Övrigt';
        array_push($customJobTypes, $type);

        // Add all the custom job types
        foreach ($customJobTypes as $type){
            array_push($afJobTypesArray, $type);
        }

        $afJobTypesArray = array_values(array_sort($afJobTypesArray, function ($value) {
            return $value->namn;
        }));

        return $afJobTypesArray;
    }

}

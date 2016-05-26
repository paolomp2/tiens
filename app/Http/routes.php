<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controllers([
	//'users' => 'UserController',
	'auth' => 'Auth\AuthController',
	//'password' => 'Auth\PasswordController',
]);

Route::post('/auth_ps', ['as'=>'auth_ps', 'uses' => 'authController@login']);

/**
 *  SUB DOMINIOS PAISES
 */	
Route::get('/peru', 'indexController@peru_auth');
Route::get('/chile', 'indexController@chile_auth');
Route::get('/ecuador', 'indexController@ecuador_auth');
Route::get('/bolivia', 'indexController@bolivia_auth');
Route::get('/colombia', 'indexController@colombia_auth');
Route::get('/mexico', 'indexController@mexico_auth');
Route::get('/venezuela', 'indexController@venezuela_auth');

/**
 * LOGOUT
 */
Route::get('/logout','indexController@logout');
Route::get('/seleccione_pais', 'indexController@select_country');

Route::group(['middleware' => 'auth'], function (){

	/**
	 * PAGINA INICIO
	 */
	Route::get('/', 'indexController@index');

	Route::get('/institucion', 'indexController@institution');

	Route::get('/noticias', 'indexController@news');
	Route::get('/noticias/{id}', 'indexController@newsShow');

	Route::get('/galerias', 'indexController@gallery');
	Route::get('/galeria/{id}', 'indexController@galleryShow');

	Route::get('/agenda', 'indexController@events');
	Route::get('/agenda/{id}', 'indexController@eventShow');
	Route::get('/leones_capacitadores', 'indexController@lions_trainers');

	Route::get('/capacitaciones', 'indexController@trainings');
	Route::get('/capacitaciones/{id}', 'indexController@trainingsShow');
	Route::get('/capacitacionesCat/{id}', 'indexController@trainingsCat');

	Route::get('/tiens_tv', 'indexController@movie');
	Route::get('/tiens_tv/cat/{id}', 'indexController@movieCat');
	Route::get('/tiens_tv/{id}', 'indexController@movieShow');
	
	Route::post('/find', ['as'=>'find', 'uses' => 'indexController@find']);
	Route::get('/buscar/{name}', ['as'=>'buscar', 'uses' => 'indexController@buscar']);

	Route::get('/notificaciones', 'indexController@notification');
	Route::get('/not_dif_betwen_timezone/{timestamp}', 'indexController@not_dif_betwen_timezone');	
	Route::get('/notification_popup/{dif_hour}', ['as'=>'notification_popup', 'uses' => 'indexController@notification_popup']);

	Route::get('/ayuda', 'indexController@help');

	Route::get('/8_pasos', 'indexController@eight_step');

	Route::group(['middleware' => 'adminCountry'], function (){

		/**
		 * ADMINISTRACION
		 */
		Route::resource("banner", "bannerController");
		Route::get('/banner/{id}/inactive', ['uses' =>'bannerController@inactive']);
		Route::get('/banner/{id}/untrashed', ['uses' =>'bannerController@untrashed']);

		Route::resource("news", "newsController");
		Route::get('/news/{id}/inactive', ['uses' =>'newsController@inactive']);
		Route::get('/news/{id}/untrashed', ['uses' =>'newsController@untrashed']);

		Route::resource("event", "eventController");
		Route::get('/event/{id}/inactive', ['uses' =>'eventController@inactive']);
		Route::get('/event/{id}/untrashed', ['uses' =>'eventController@untrashed']);

		Route::resource("gallery", "galleryController");
		Route::get('/gallery/{id}/inactive', ['uses' =>'galleryController@inactive']);
		Route::get('/gallery/{id}/untrashed', ['uses' =>'galleryController@untrashed']);

		Route::resource("movie", "movieController");
		Route::get('/movie/{id}/inactive', ['uses' =>'movieController@inactive']);
		Route::get('/movie/{id}/untrashed', ['uses' =>'movieController@untrashed']);
		Route::post('movie/store_movie','movieController@store_movie');

		Route::resource("lion", "lionController");
		Route::get('/lion/{id}/inactive', ['uses' =>'lionController@inactive']);
		Route::get('/lion/{id}/untrashed', ['uses' =>'lionController@untrashed']);

		Route::resource("trainer", "trainerController");
		Route::get('/trainer/{id}/inactive', ['uses' =>'trainerController@inactive']);
		Route::get('/trainer/{id}/untrashed', ['uses' =>'trainerController@untrashed']);

		Route::resource("training", "trainingController");
		Route::get('/training/{id}/inactive', ['uses' =>'trainingController@inactive']);
		Route::get('/training/{id}/untrashed', ['uses' =>'trainingController@untrashed']);

		Route::post('document/store','documentController@store');
		Route::get('/document/{id}/delete','documentController@delete');
		

		Route::resource("content", "contentController");

		Route::resource("event_category", "event_categoryController");
		Route::get('/event_category/{id}/inactive', ['uses' =>'event_categoryController@inactive']);
		Route::get('/event_category/{id}/untrashed', ['uses' =>'event_categoryController@untrashed']);

		Route::resource("gallery_category", "gallery_categoryController");
		Route::get('/gallery_category/{id}/inactive', ['uses' =>'gallery_categoryController@inactive']);
		Route::get('/gallery_category/{id}/untrashed', ['uses' =>'gallery_categoryController@untrashed']);

		Route::resource("video_category", "video_categoryController");
		Route::get('/video_category/{id}/inactive', ['uses' =>'video_categoryController@inactive']);
		Route::get('/video_category/{id}/untrashed', ['uses' =>'video_categoryController@untrashed']);

		Route::resource("training_category", "training_categoryController");
		Route::get('/training_category/{id}/inactive', ['uses' =>'training_categoryController@inactive']);
		Route::get('/training_category/{id}/untrashed', ['uses' =>'training_categoryController@untrashed']);

	});
});


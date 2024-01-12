<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Storage;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

class DropboxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('dropbox', function(){
        //   $appKey = env('DROPBOX_APP_KEY');
        //   $appSecret = env('DROPBOX_APP_SECRET');
        //   $appRefresh = env('DROPBOX_REFRESH_TOKEN');
          $client = new Client();
          $adapter = new DropboxAdapter($client);
          return new Filesystem($adapter, ['case_sensitive' => false]);
        });
        //$client = new DropboxClient();

        //new Filesystem(new DropboxAdapter($client));

    }
}
//
        // Storage::extend('dropbox', function ($app, $config) {
        //     $client = new DropboxClient($config['authorizationToken'] // Hacemos referencia al hash
        //     );
        //     return new Filesystem(new DropboxAdapter($client));
        // });
        // Storage::extend('dropbox', function ($app, $config) {
        //     $client = new DropboxClient(// Hacemos referencia al hash
        //     );
        //     return new Filesystem(new DropboxAdapter($client));
        // });
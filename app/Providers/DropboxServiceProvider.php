<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;
use App;
use Illuminate\Support\Facades\Storage;

class DropboxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(){
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        $key = '7pWPAq6AZdAAAAAAAAABDGNl3XLWmZvG5v5EErKMemEB4b9fuR7EYBP06eZ5zOa7';
        Storage::extend('dropbox', function () use($key) {
            $client = new DropboxClient($key);
            return new Filesystem(new DropboxAdapter($client));
        });
    }
}

<?php

namespace App\Providers;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use ProtoneMedia\LaravelFFMpeg\FFMpeg\FFProbe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('file_length', function ($attribute, $value, $parameters) {

            // validate the file extension
            if (!empty($value->getClientOriginalExtension()) && (($value->getClientOriginalExtension() == 'mp4') || ($value->getClientOriginalExtension() == 'mov') || ($value->getClientOriginalExtension() == 'mp3'))) {

                $ffprobe = FFProbe::create([
                    'ffmpeg.binaries'  => '/usr/local/bin/ffmpeg',
                    'ffprobe.binaries' => '/usr/local/bin/ffprobe'
                ]);
                $duration = $ffprobe
                    ->format($value->getRealPath()) // extracts file information
                    ->get('duration');

                return (round($duration) > $parameters[0]) ? false : true;
            } else {
                return false;
            }
        });
    }
}


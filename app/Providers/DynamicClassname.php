<?php
namespace App\Providers;
use App\Frequency;
use App\Round; // write model name here 
use Illuminate\Support\ServiceProvider;
class DynamicClassname extends ServiceProvider
{
    public function boot()
    {
        view()->composer('*',function($view){
            $view->with('frequencyname_array', Frequency::all());
        });
    }

    public function boot2()
    {
        view()->composer('*',function($view){
            $view->with('roundname_array', Round::all());
        });
    }

}

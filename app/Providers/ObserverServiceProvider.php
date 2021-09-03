<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Custom\Observers\BaseObserver;
use Illuminate\Support\Str;

class ObserverServiceProvider extends ServiceProvider
{
    protected $events;

    protected $exceptions = ['.', '..'];

    public function boot()
    {
        $this->load(app_path('Custom/Observers'));
        $this->schedule();
    }

    public function schedule(): void
    {
        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, BaseObserver::class)) {
                $class::schedule();
            }
        }
    }

    protected function load($dir): void
    {
        foreach (scandir($dir) as $file) {
            $path = $dir . '/' . $file;
            if (!in_array($file, $this->exceptions, true)) {
                if (is_dir($path)) {
                    $this->load($path);
                }
                if (Str::endsWith($file, '.php')) {
                    require_once($path);
                }
            }
        }
    }
}

<?php

namespace Modules\Bot\App\Providers;

use SergiX44\Nutgram\Nutgram;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Blade;
use Modules\Bot\Handlers\StartCommand;
use Modules\Bot\Handlers\StartHandler;
use Illuminate\Support\ServiceProvider;
use Modules\Bot\Handlers\TariffHandler;
use Modules\UserManagement\App\Models\User;
use Modules\Bot\Conversations\TariffConversation;
use Modules\Bot\Conversations\TicketConversation;
use Modules\Bot\Conversations\BalanceConversation;
use Modules\TariffsAndPromotions\App\Services\TariffService;


class BotServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Bot';

    protected string $moduleNameLower = 'bot';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/migrations'));
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {

        $bot=$this->app->make(Nutgram::class);
        $bot->onCommand('start', [StartHandler::class, 'start']);

        $bot->onContact([StartHandler::class, 'savePhone']);

        // $bot->onText('Тарифы', [\Modules\Bot\Handlers\MenuHandler::class, 'tariffs']);

        // $bot->onText('/^.+$/', function(Nutgram $bot, string $text){
        //     $bot->sendMessage("Fallback text: $text");
        // });
       // 3) If user picks "Тарифы" from main menu -> start TariffConversation
        $bot->onText('Тарифы', TariffConversation::class);

        $bot->onText('Тикет', TicketConversation::class);

        $bot->onText('Мой Баланс', BalanceConversation::class);

        // // 4) If user picks "Акции" from main menu -> start PromotionConversation
        // $bot->onText('Акции', function(Nutgram $bot) {
        //     $bot->startConversation(PromotionConversation::class);
        // });

        // Add other main menu items or fallback
        // $bot->run();


    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/'.$this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'lang'));
        }
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $this->publishes([module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower.'.php')], 'config');
        $this->mergeConfigFrom(module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);
        $sourcePath = module_path($this->moduleName, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->moduleNameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

        $componentNamespace = str_replace('/', '\\', config('modules.namespace').'\\'.$this->moduleName.'\\'.config('modules.paths.generator.component-class.path'));
        Blade::componentNamespace($componentNamespace, $this->moduleNameLower);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->moduleNameLower)) {
                $paths[] = $path.'/modules/'.$this->moduleNameLower;
            }
        }

        return $paths;
    }
}

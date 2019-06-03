<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Recalculate extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recalculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate all entities';
    public $user = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle($repeat = false) {
        $this->recalculate(\App\Models\Comment::class);
        $this->recalculate(\App\Models\StoryComment::class);
        $this->recalculate(\App\Models\Story::class);
        $this->recalculate(\App\Models\Item::class);
        $this->recalculate(\App\Models\Collection::class);
        $this->recalculate(\App\Models\User::class);
        $this->recalculate(\App\Models\Category::class);
        $this->globalCounters();
    }

    protected function globalCounters() {
        \Setting::set('approved_items', \App\Models\Item::where('status', 2)->count());
        \Setting::set('items', \App\Models\Item::count());
        \Setting::set('members', \App\Models\User::count());
        \Setting::save();
    }

    protected function recalculate($className) {
        $models = $className::all();
        if ($models) {
            $this->output->note($className);
            $bar = $this->output->createProgressBar(count($models));
            foreach ($models as $model) {
                if (method_exists($className, 'recalculate')) {
                    $model->recalculate();
                    $model->save();
                }
                $bar->advance();
            }
            $bar->finish();
            $this->output->newLine();
            $this->output->newLine();
        }
    }

}

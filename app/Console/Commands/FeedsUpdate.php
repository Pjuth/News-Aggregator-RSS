<?php

namespace App\Console\Commands;

use App\Feed;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FeedsUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feeds:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all feed files.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $feeds = Feed::all();

        foreach ($feeds as $feed) {
            $name = $feed->name . '-' . $feed->category . '.xml';
            if (Storage::disk('local')->has($name)) {
                Storage::disk('local')->delete($name);
            }
            Storage::disk('local')->put($name, file_get_contents($feed->url));
        }
    }
}

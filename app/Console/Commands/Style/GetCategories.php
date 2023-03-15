<?php

namespace App\Console\Commands\Style;

use App\Models\Category;
use Illuminate\Console\Command;
use Style;

class GetCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'al-style:get-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $alStyleCategories = Style::getCategories();
        foreach (json_decode($alStyleCategories) as $item) {
            $cat = Category::where('foreign_id', $item->id)->first();
            if(!$cat) {
                $category = new Category();
                $category->foreign_id   = $item->id;
                $category->name         = $item->name;
                $category->left         = $item->left;
                $category->right        = $item->right;
                $category->level        = $item->level;
                $category->save();
            }
        }

        $this->info("The process is finished.");
    }
}

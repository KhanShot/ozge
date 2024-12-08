<?php

namespace App\Console\Commands;

use App\Models\Products;
use Illuminate\Console\Command;

class ResetProductProbability extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset probability to default for all products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Illuminate\Log\log()->info('ResetProductProbability: Start');
        $startTime = microtime(true);
        $productProbabilities = [
            1 => 69, //NOTHING
            3 => 3, //	Airpods max
            6 => 4, //Airpods
            7 => 4, // 5000 тг
            9 => 4, //Помада
            10 => 10, //5 %
            11 => 3, //Уход набор
            13 => 3, //Тущь
        ];

        foreach ($productProbabilities as $id => $probability) {
            Products::query()
                ->where('id', $id)
                ->update(['probability' => $probability]);
        }
        $executionTime = microtime(true) - $startTime;
        \Illuminate\Log\log()->info('ResetProductProbability: Completed in ' . $executionTime . ' seconds');
    }
}

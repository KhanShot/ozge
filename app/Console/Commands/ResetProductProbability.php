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
            1 => 55,
            3 => 4,
            6 => 5,
            7 => 5,
            9 => 6,
            10 => 15,
            11 => 5,
            13 => 5,
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

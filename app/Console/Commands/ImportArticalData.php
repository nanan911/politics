<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;
use Carbon\Carbon;

class ImportArticalData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-artical-data {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import article data from CSV file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error('The specified file does not exist.');
            return;
        }

        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = array_combine($header, $row);

            Article::create([
                // 求方便，先寫死
                'source_id' => 1,
                'title' => $data['title'],
                'content' => $data['content'],
                'sentiment' => $data['sentiment'],
                'date' => Carbon::parse($data['time'])->format('Y-m-d'),
            ]);
        }

        $this->info('Data imported successfully.');
    }
}

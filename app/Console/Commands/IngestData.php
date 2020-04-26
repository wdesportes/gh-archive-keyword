<?php

namespace App\Console\Commands;

use App\Pipes\PipeChoose;
use App\Pipes\PipeDecode;
use App\Pipes\PipeSaveModels;
use Illuminate\Console\Command;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cache;

class IngestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ingest {--today} {--date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ingest the data from the GitHub archive website';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $dateString = null;
        if ($this->option('today')) {
            $dateString = Carbon::now()->format('Y-m-d');
        } elseif ($this->option('date')) {
            /** @var string $dateInput */
            $dateInput = $this->option('date');
            $dateString = Carbon::parse($dateInput)->format('Y-m-d');
        } else {
            $this->error('Please use --today or --date');
            return 1;
        }
        // Forget all cached data
        Cache::flush();
        for ($i = 0; $i < 24; $i++) {
            $this->warn('Ingesting hour: ' . $i);
            $this->ingestHour($dateString, $i);
        }
        return 0;
    }

    public function ingestHour(string $dateString, int $hour): void
    {
        /** @var Pipeline $pipeline */
        $pipeline = App::make(Pipeline::class);
        $handle = fopen("compress.zlib://https://data.gharchive.org/$dateString-$hour.json.gz", 'r');
        if ($handle === false) {
            throw new Exception('Open stream error !');
        }
        while ($line = stream_get_line($handle, 1024 * 1024, "\n")) {
            $eventId = $pipeline->send($line)->through([
                PipeDecode::class,
                PipeChoose::class,
                PipeSaveModels::class,
            ])->thenReturn();
            $this->info('Processed: ' . $eventId);
        }
        fclose($handle);
    }
}

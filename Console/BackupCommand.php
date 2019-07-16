<?php

namespace Modules\Backup\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class BackupCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database.';


    protected $process;

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

        try {
            $options = $this->options();
            $command = "mysqldump -u %s -p %s ";

            if (isset($options['data']))
                $command = "mysqldump --no-create-db --no-create-info -u%s -p%s ";

            if (isset($options['table'])) {

                $this->process = new Process(sprintf(
                    $command . "%s  %s > %s",
                    config('database.connections.mysql.username'),
                    config('database.connections.mysql.password'),
                    config('database.connections.mysql.database'),
                    $options['table'],
                    storage_path('backups/' . config('database.connections.mysql.database') . "-" . $options['table'] . "-" . Carbon::now()->format("Y-m-d-h:i") . ".sql")
                ));
            } else {
                $this->process = new Process(sprintf(
                    $command . "%s > %s",
                    config('database.connections.mysql.username'),
                    config('database.connections.mysql.password'),
                    config('database.connections.mysql.database'),
                    storage_path('backups/' . config('database.connections.mysql.database') . "-" . Carbon::now()->format("Y-m-d-h:i") . ".sql")
                ));
            }

            $this->process->mustRun();
            $this->info('The backup has been proceed successfully.');
        } catch (ProcessFailedException $exception) {
            $this->error('The backup process has been failed.');
        }
    }


    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['table', '-t', InputOption::VALUE_OPTIONAL, 'Backup table name.', null],
            ['data', '-d', InputOption::VALUE_OPTIONAL, 'Backup only data.', null],
        ];
    }
}

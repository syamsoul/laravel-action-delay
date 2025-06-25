<?php

namespace SoulDoit\ActionDelay\Commands;

use Illuminate\Console\Command;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use SoulDoit\ActionDelay\Jobs\DatabaseQueryJob;
use SoulDoit\ActionDelay\Jobs\PhpCodeJob;
use SoulDoit\ActionDelay\Jobs\ExternalProcessJob;
use ReflectionClass;

class ActionDelayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'souldoit:action-delay {--action=} {--job=} {--job-parameter=*} {--db-query=} {--php-code=} {--command=} {--command-timeout=} {--delay-time=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delay an action on specific time.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $actionCmd = $this->option('action');
        $jobCmd = $this->option('job');
        $jobParametersCmd = $this->option('job-parameter');
        $dbQueryCmd = $this->option('db-query');
        $phpCodeCmd = $this->option('php-code');
        $commandCmd = $this->option('command');
        $commandTimeoutCmd = $this->option('command-timeout');
        $delayTimeCmd = $this->option('delay-time');

        $action_choices = [
            1 => 'Laravel Jobs',
            2 => 'Database Query',
            3 => 'PHP Code',
            4 => 'External Process',
        ];

        $action = !empty($actionCmd) ? intval($actionCmd) : array_flip($action_choices)[$this->choice("What action you want to delay?", $action_choices, 1, 1)];

        if ($action === 1) {
            if (!empty($jobCmd)) {
                $job = $jobCmd;
            } else {
                $job_choices = ClassFinder::getClassesInNamespace('App\Jobs');

                if (empty($job_choices)) {
                    $this->components->error("There are no jobs available.");
                    return;
                }

                $job_choices = array_combine(range(1, count($job_choices)), $job_choices);

                $job = "\\" . $this->choice("What job you want to delay?", $job_choices, 1, 1);
            }

            if (!empty($jobParametersCmd)) {
                $param_values = $jobParametersCmd;
            } else {
                $job_reflection_class = new ReflectionClass($job);
                $job_constructor_parameters = $job_reflection_class->getConstructor()->getParameters();

                $param_values = [];

                foreach ($job_constructor_parameters as $key => $jc_param) {
                    $type_hint = $jc_param->getType();

                    $type_hint_name_arr = [];

                    if (method_exists($type_hint,'getName')) {
                        array_push($type_hint_name_arr, $type_hint->getName());
                        if ($type_hint->allowsNull()) array_push($type_hint_name_arr, "null");
                    } else if (method_exists($type_hint,'getTypes')) {
                        foreach ($type_hint->getTypes() as $thn) array_push($type_hint_name_arr, $thn->getName());
                    } else {
                        $this->components->error("Something's wrong.");
                    }

                    $type_hint_name = join("|", $type_hint_name_arr);

                    $param_value = $this->ask("Please insert #" . ($key + 1) . " parameter: `$jc_param->name` (Type: $type_hint_name)");

                    if (count(array_diff($type_hint_name_arr, ["string", "null"])) > 0) {
                        array_push($param_values, eval("return $param_value;"));
                    } else {
                        if (in_array("null", $type_hint_name_arr)) {
                            if (empty($param_value)) $param_value = null;
                        }
                        array_push($param_values, $param_value);
                    }
                }   
            }
        } else if ($action === 2) {
            $query = !empty($dbQueryCmd) ? $dbQueryCmd : $this->ask("Enter MySQL query");
        } else if ($action === 3) {
            $code = !empty($phpCodeCmd) ? $phpCodeCmd : $this->ask("Enter PHP code");
        } else if ($action === 4) {
            $command = !empty($commandCmd) ? $commandCmd : $this->ask("Enter command");
            $timeout = intval(!empty($commandTimeoutCmd) ? $commandTimeoutCmd : $this->ask("Process timeout (in seconds)", 600));
        } else {
            $this->components->error("Something's wrong.");
        }

        $datetime_string = !empty($delayTimeCmd) ? $delayTimeCmd : $this->ask("What time to execute (in " . config('app.timezone') . " time, format:Y-m-d H:i:s)");

        $validator = Validator::make(['datetime_string' => $datetime_string], [
            'datetime_string' => ['required', 'date_format:Y-m-d H:i:s'],
        ]);

        if ($validator->fails()) {
            $this->components->error($validator->errors()->first());
            return;
        }

        if ($action === 1) {
            ($job)::dispatch(...$param_values)->delay(Carbon::parse($datetime_string));
        } else if ($action === 2) {
            DatabaseQueryJob::dispatch($query)->delay(Carbon::parse($datetime_string));
        } else if ($action === 3) {
            PhpCodeJob::dispatch($code)->delay(Carbon::parse($datetime_string));
        } else if ($action === 4) {
            ExternalProcessJob::dispatch($command, $timeout)->delay(Carbon::parse($datetime_string));
        } else {
            $this->components->error("Something's wrong.");
        }
    }
}
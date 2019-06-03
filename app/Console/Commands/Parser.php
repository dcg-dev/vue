<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Parser extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parser';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle($repeat = false)
    {
        if (($handle = fopen(__DIR__ . '/users.csv', "r")) !== FALSE) {
            $count = $created = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $count++;
                $this->info($count);
                if ($count == 1) {
                    continue;
                }
                $data = collect($data);
                $user = User::where('email', $data->get(2))->orWhere('username', $data->get(1))->withoutGlobalScopes()->first();
                if (!$user) {
                    $user = new User();
                    $user->email = $data->get(2);
                    $user->password = $data->get(3);
                    $user->username = $data->get(1) ? $data->get(1) : $this->slug(explode('@', $user->email)[0]);
                    if ($user->save()) {
                        $created++;
                    }

                }
                if ($data->get(4)) {
                    $user->gender = $data->get(4) == 'M' ? 'male' : 'female';
                }
                if ($data->get(5)) {
                    $user->firstname = $data->get(5);
                }
                if ($data->get(6)) {
                    $user->lastname = $data->get(6);
                }
                if ($data->get(7)) {
                    $user->company = $data->get(7);
                }
                if ($data->get(9)) {
                    try {
                        $created_at = Carbon::parse($data->get(9));
                    } catch (\Exception $x) {

                    }
                    if ($created_at) {
                        $user->created_at = $created_at;
                    }
                }
                $user->activated = 1;
                $user->save();
            }
            $this->info("Total: $count");
            $this->info("Success: $created");
            fclose($handle);
        }
    }

    protected function slug($slug, $index = 1)
    {
        if (User::where('username', $slug)->withoutGlobalScopes()->count()) {
            return $slug . time();
        }
        return $slug;
    }

}

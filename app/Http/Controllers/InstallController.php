<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;

class InstallController extends Controller
{
    public function step0()
    {
        return view('installation.step0');
    }

    public function step1()
    {
        try {
            $permission['curl_enabled'] = function_exists('curl_version');
            $permission['db_file_write_perm'] = is_writable(base_path('.env'));
            $permission['routes_file_write_perm'] = is_writable(base_path('app/Providers/RouteServiceProvider.php'));
            $permission['phpVersion'] = number_format((float) phpversion(), 2, '.', '');

            return view('installation.step1', compact('permission'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', $e->getMessage());

            return back();
        }
    }

    public function step2()
    {
        // purchase code
        return view('installation.step2');
    }

    public function step3()
    {
        // database credential
        return view('installation.step3');
    }

    public function step4()
    {
        // import database
        return view('installation.step4');
    }

    public function step5()
    {
        // admin account setup
        return view('installation.step5');
    }

    public function purchase_code(Request $request)
    {
        try {
            $purchaseFile = base_path('install/purchase.php');
            $data = include $purchaseFile;
            if ($data['purchase_key'] != $request->purchase_key || $data['username'] != $request->username)
                throw new Exception('Purchase key is not valid!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', $e->getMessage());
            return redirect('step2')->withInput();
        }

        return redirect('step3');
    }

    public function system_settings(Request $request)
    {

        try {
            $role = Role::where('name', 'Owner')->first();

            $user = User::updateOrCreate(['email' => $request['admin_email']], [
                'name' => $request['admin_name'],
                'email' => $request['admin_email'],
                'mobile' => $request['admin_phone'],
                'password' => bcrypt($request['admin_password']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $company = Company::create([
                'name' => $request['site_name'],
                'email' => $request['admin_email'],
                'mobile' => $request['admin_phone'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $user->assignRole($role);

            $previousRouteServiceProvider = base_path('app/Providers/RouteServiceProvider.php');
            $newRouteServiceProvider = base_path('app/Providers/RouteServiceProvider.txt');

            if (file_exists($previousRouteServiceProvider)) {
                if (copy($newRouteServiceProvider, $previousRouteServiceProvider)) {
                } else {
                    echo 'Failed to copy the file.';
                }
            } else {
                echo 'Source file does not exist.';
            }
            Artisan::call('config:cache');
            Artisan::call('config:clear');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            echo 'Failed to copy the file.';
        }

        return view('installation.step6');
    }

    public function database_installation(Request $request)
    {
        // return $request->all();
        try {
            if (self::check_database_connection($request->DB_HOST, $request->DB_DATABASE, $request->DB_USERNAME, $request->DB_PASSWORD)) {

                $key = base64_encode(random_bytes(32));
                $output = 'APP_NAME=flat' . time() . '
                    APP_ENV=live
                    APP_KEY=base64:' . $key . '
                    APP_DEBUG=false
                    APP_INSTALL=true
                    APP_LOG_LEVEL=debug
                    APP_MODE=live
                    APP_URL=' . URL::to('/') . '

                    DB_CONNECTION=mysql
                    LOG_CHANNEL=daily
                    DB_HOST=' . $request->DB_HOST . '
                    DB_PORT=3306
                    DB_DATABASE=' . $request->DB_DATABASE . '
                    DB_USERNAME=' . $request->DB_USERNAME . '
                    DB_PASSWORD=' . $request->DB_PASSWORD . '

                    BROADCAST_DRIVER=log
                    CACHE_DRIVER=file
                    SESSION_DRIVER=file
                    SESSION_LIFETIME=60
                    QUEUE_DRIVER=sync

                    AWS_ENDPOINT=
                    AWS_ACCESS_KEY_ID=
                    AWS_SECRET_ACCESS_KEY=
                    AWS_DEFAULT_REGION=us-east-1
                    AWS_BUCKET=

                    REDIS_HOST=127.0.0.1
                    REDIS_PASSWORD=null
                    REDIS_PORT=6379

                    PUSHER_APP_ID=
                    PUSHER_APP_KEY=
                    PUSHER_APP_SECRET=
                    PUSHER_APP_CLUSTER=mt1

                    PURCHASE_CODE=' . session('purchase_key') . '
                    BUYER_USERNAME=' . session('username') . '
                    SOFTWARE_ID=MzE0NDg1OTc=

                    SOFTWARE_VERSION=1.0
                    ';
                $file = fopen(base_path('.env'), 'w');
                fwrite($file, $output);
                fclose($file);

                $path = base_path('.env');
                if (file_exists($path)) {
                    return redirect('step4');
                } else {
                    throw new Exception("File not exist");
                }
            } else {
                throw new Exception("Database not found!");
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            session()->flash('error', 'Database error!');

            return redirect('step3');
        }
    }

    public function import_sql()
    {
        try {
            $sql_path = base_path('install/db/database.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect('step5');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            session()->flash('error', 'Your database is not clean, do you want to clean database then import?');

            return back();
        }
    }

    public function force_import_sql()
    {
        try {
            Artisan::call('db:wipe');
            $sql_path = base_path('install/db/database.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect('step5');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            session()->flash('error', 'Check your database permission!');

            return back();
        }
    }

    public function check_database_connection($db_host = '', $db_name = '', $db_user = '', $db_pass = '')
    {
        if (@mysqli_connect($db_host, $db_user, $db_pass, $db_name)) {
            return true;
        } else {
            return false;
        }
    }
}

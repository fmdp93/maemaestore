<?php

namespace App\Http\Controllers;

// require( base_path() . '/src/shuttle-export/dumper.php');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function index()
    {
        $data['title'] = 'Backup/Restore Database';
        $data['heading'] = 'Backup/Restore Database';
        return view('pages.admin.settings', $data);
    }

    public function backupDb()
    {
        $wp_dumper = \Shuttle_Dumper::create(array(
            'host' => env('DB_HOST'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'db_name' => 'maemaestore',
        ));
        $file_name = base_path() . '/database/' . date('y_m_d__h_i_s') . '.sql';
        $wp_dumper->dump($file_name);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_name));
        ob_clean();
        flush();
        readfile($file_name);
        unlink($file_name);
    }

    public function restoreDb(Request $request)
    {
        // $extenstion = $request->db->extension();
        $file = $request->file('database');

        $validator = Validator::make($request->all(), [
            'database' => ['required', 'file', function ($attr, $values, $fails) use ($file) {
                if (pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION) !== 'sql') {
                    $fails("File should be .sql type");
                }
            }]
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $file->storeAs('uploads', 'maemaestore.sql');
        $path = storage_path('app\uploads\maemaestore.sql');
        $user = env("DB_USERNAME");
        $password = env("DB_PASSWORD");
        $database = env("DB_DATABASE");

        // $mysql_path = 'C:\xampp-php7.3.28\mysql\bin\mysql';
        $mysql_path = 'mysql';
        $restore_command = $mysql_path . ' -u' . $user . ' -p' . $password . " " . $database . " < " . $path;
        $pw_param = $password != "" ? "-p$password" : "";
        $restore_command = "$mysql_path -u$user $pw_param $database < $path";
        exec($restore_command, $output);
        // dump($restore_command);

        // migrate
        $artisan_path = base_path('artisan');
        exec("php $artisan_path migrate", $output);
        exec("php $artisan_path db:seed POSTransaction2ProductColumnBasePriceSeeder", $output);        
        unlink($path);
        
        // var_dump($output);
        // die();

        $request->session()->flash('msg_success', 'Database restoration completed!');
        return redirect(route('settings'));
    }
}

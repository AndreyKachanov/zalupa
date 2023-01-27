<?php

namespace Database\Seeders;

use App\Models\Admin\Item\Item;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemsSeederNew extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        dd(collect([
            'color' => 'orange',
            'type' => 'fruit',
            'remain' => 6,
        ]));

        //dd(DB::connection('mysql_prod')->table('items')->whereNotNull('deleted_at')->count());

        //dump(Item::count());
        //dd(DB::connection('mysql_prod')->table('items')->count());
        //dump(Item::get()[0]->toArray());
        $itemsProd1 = DB::connection('mysql_prod')->table('items')->whereIn('id', [1, 2])->get()->map(function ($i) {
            return (array)$i;
        })->toArray();
        $itemsProd2 = DB::connection('mysql_prod')->table('items')->whereIn('id', [2])->get()->toArray();
        dump($itemsProd1);
        dd($itemsProd2);
        dd($itemsProd1->diffAssoc($itemsProd2));
        dump($itemsProd);
        $itemLocal = Item::whereIn('id', [1])->get();
        dd($itemLocal);
        //$diff = $itemLocal->diffAssoc($itemsProd);
        dd($diff);
        dd($itemLocal);
        //dd(Item::all()[0]);
        //dd(DB::connection('mysql_prod')->table('items')->get()[0]->toArray());

        $connection = ssh2_connect(config('ssh.url'), config('ssh.port'));

        if (!ssh2_auth_password($connection, config('ssh.username'), config('ssh.password'))) {
            throw new Exception('Unable to connect ' . config('ssh.url') .  'with SSH!');
        }

        // Create our SFTP resource
        if (!$sftp = ssh2_sftp($connection)) {
            throw new Exception('Unable to create SFTP connection.');
        }

        $localDir  =  Storage::disk('database')->path('seeders/seeder_data/test');
        $remoteDir = config('ssh.remote_dir');

        $files = scandir('ssh2.sftp://' . $sftp . $remoteDir);

        dd($files);
        if (!empty($files)) {
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    ssh2_scp_recv($connection, "$remoteDir/$file", "$localDir/$file");
                }
            }
        }

        //ssh2_scp_recv($connection, $fileServ, Storage::disk('database')->path('seeders/seeder_data/test/0a26d351e00c529c626c77e56c964c85.jpg'));





        //if( ! $connection ) {
        //    dd('unable to establish file connection');
        //    return;
        //}
    }
}

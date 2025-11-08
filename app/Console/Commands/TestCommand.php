<?php

namespace App\Console\Commands;

use App\Listeners\ActualiseCommandeFournisseurListener;
use App\Models\Fournisseur;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::transaction(function () {
            Role::create(['name' => 'SUPER ADMIN']);
            $utilisateur = User::withTrashed()
                ->where('email', 'nysainana@dna.mg')
                ->first();

            $utilisateur->restore();
            $utilisateur->syncRoles('SUPER ADMIN');
        });
    }

}

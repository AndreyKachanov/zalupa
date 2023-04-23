<?php

use App\Models\User\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    private $usersTableName;

    public function __construct()
    {
        $this->usersTableName = User::getTableName();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable($this->usersTableName)) {
            Schema::create($this->usersTableName, function (Blueprint $table) {
                $table->smallIncrements('id');
                $table->string('name')->nullable();
                $table->string('password')->nullable();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->unsignedSmallInteger('role_id')->nullable();

                $table->string('phone')->nullable();
                $table->boolean('phone_auth')->default(false);
                $table->boolean('phone_verified')->default(false);
                $table->string('phone_verify_token')->nullable();
                $table->timestamp('phone_verify_token_expire')->nullable();

                $table->rememberToken();

                $table->string('status', 16)->nullable();
                $table->string('verify_token')->nullable()->unique();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->usersTableName);
    }
}

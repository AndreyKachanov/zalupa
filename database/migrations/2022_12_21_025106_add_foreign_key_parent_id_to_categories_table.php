<?php

use App\Models\Admin\Item\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName;

    public function __construct()
    {
        $this->tableName = Category::getTableName();
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->index(['parent_id'], 'items_categories_parent_id_idx');
            // create foreign key with fk_analyse_category_id name
            $table->foreign('parent_id', 'fk_items_categories_id')
                ->references('id')->on($this->tableName);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            if (Schema::hasColumn($this->tableName, 'parent_id')) {
                $table->dropForeign('fk_items_categories_id');
                $table->dropIndex('items_categories_parent_id_idx');
            }
        });
    }
};

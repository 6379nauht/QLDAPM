<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThumbToCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Thêm cột 'thumb' với kiểu dữ liệu string (hoặc text nếu cần lưu URL dài)
            $table->string('thumb')->nullable(); // Nếu thumb có thể để trống
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('thumb'); // Xóa cột 'thumb' khi rollback migration
        });
    }
}

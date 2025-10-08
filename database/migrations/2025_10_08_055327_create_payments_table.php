<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up(): void
{
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->string('item')->nullable();               // نام آیتم انتخاب شده
        $table->string('name')->nullable();
        $table->string('phone')->nullable();
        $table->integer('amount');            // به تومان (عدد صحیح)
        $table->string('authority')->nullable(); // از زرین‌پال
        $table->string('ref_id')->nullable();    // کد تراکنش بعد از تایید
        $table->string('status')->default('pending'); // pending, paid, failed
        $table->text('meta')->nullable();
        $table->text('uuid')->nullable();
        $table->text('transaction_id')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

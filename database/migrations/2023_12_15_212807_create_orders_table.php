
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->json('products');
            $table->string('delivery_name');
            $table->string('delivery_surname');
            $table->string('delivery_phone');
            $table->string('delivery_address');
            $table->string('delivery_email')->nullable();
            $table->string('delivery_note')->nullable();
            $table->decimal('total_amount', 8, 2);
            $table->date('order_date');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};


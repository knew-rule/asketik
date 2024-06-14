<?php
// database/migrations/{timestamp}_create_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_name')->nullable();
            $table->string('order_time')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->default('pending');
            $table->decimal('subtotal', 8, 2);
            $table->decimal('discount', 8, 2);
            $table->decimal('total', 8, 2);
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('coffee_id')->constrained();
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('image')->nullable();
            // Add more payment fields as needed
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseLinesTable extends Migration
{
    public function up()
    {
        Schema::create('expense_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_report_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->date('spent_on')->nullable();
            $table->string('receipt_path')->nullable();  // Pour stocker le chemin/URL du justificatif
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expense_lines');
    }
}

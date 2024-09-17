<?php

	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	return new class extends Migration {
		/**
		 * Run the migrations.
		 */
		public function up(): void
		{
			Schema::create('ratings', function (Blueprint $table) {
				$table->id();                                                                  // Primary key
				$table->foreignId('user_id')->constrained()->onDelete('cascade');              // Foreign key to users table
				$table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Foreign key to services table, referencing the service
				$table->unsignedTinyInteger('rating');                                         // Rating column, using a tiny integer to store the rating (e.g., 1-5 stars)
				$table->string('comments');
				$table->timestamps();                                                          // Timestamps for created_at and updated_at
			});
		}

		/**
		 * Reverse the migrations.
		 */
		public function down(): void
		{
			Schema::dropIfExists('ratings');
		}
	};

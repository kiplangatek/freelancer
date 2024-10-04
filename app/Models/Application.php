<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\BelongsToMany;
	use Illuminate\Database\Eloquent\Relations\HasOneThrough;

	class Application extends Model
	{
		use HasFactory;

		protected $fillable = [
			'applicant_id',
			'freelancer_id',
			'service_id',
		];

		public function applicant(): BelongsTo
		{
			return $this->belongsTo(User::class, 'applicant_id');
		}

		/**
		 * Get the service that the application is for.
		 */
		public function service(): BelongsTo
		{
			return $this->belongsTo(Service::class, 'service_id');
		}

		public function freelancer(): HasOneThrough
		{
			return $this->hasOneThrough(User::class, Service::class, 'id', 'id', 'service_id', 'freelancer_id');
		}

		public function ratings():BelongsTo
		{
			return $this->belongsTo(Rating::class, 'application_id');
		}
	}

<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;

	class Rating extends Model
	{
		use HasFactory;

		protected $fillable = [
			'user_id', 'freelancer_id', 'rating', 'service_id', 'comments'
		];

		public function user(): BelongsTo
		{
			return $this->belongsTo(User::class);
		}

		public function service()
		{
			return $this->belongsTo(Service::class, 'service_id');
		}

		public function freelancer()
		{
			return $this->belongsTo(User::class);
		}

		public function applicant()
		{
			return $this->belongsTo(related: User::class);
		}


	}

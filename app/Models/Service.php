<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\HasMany;

	class Service extends Model
	{
		public $timestamps = false;

		protected $fillable = [
			'title', 'price', 'details', 'image', 'freelancer_id', 'category_id'
		];

		public function freelancer(): BelongsTo
		{
			return $this->belongsTo(User::class, 'freelancer_id');
		}

		public function applications(): HasMany
		{
			return $this->hasMany(Application::class, 'service_id');
		}

		public function applicant(): BelongsTo
		{
			return $this->belongsTo(User::class, 'applicant_id');
		}

		public function category(): BelongsTo
		{
			return $this->belongsTo(Category::class, 'category_id');
		}


	}

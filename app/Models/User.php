<?php

	namespace App\Models;

	// use Illuminate\Contracts\Auth\MustVerifyEmail;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Notifications\Notifiable;

	class User extends Authenticatable
	{
		use HasFactory, Notifiable;

		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array<int, string>
		 */
		protected $fillable = [
			'name',
			'email',
			'password',
			'usertype',
			'photo',
			'email_verified_at',
			'otp',
			'otp_expires_at'
		];

		/**
		 * The attributes that should be hidden for serialization.
		 *
		 * @var array<int, string>
		 */
		protected $hidden = [
			'password',
			'remember_token',
		];

		/**
		 * Get the attributes that should be cast.
		 *
		 * @return array<string, string>
		 */
		protected function casts(): array
		{
			return [
				'email_verified_at' => 'datetime',
				'password' => 'hashed',
				'otp_expires_at' => 'datetime',
			];
		}

		public function services(): HasMany
		{
			return $this->hasMany(Service::class, 'freelancer_id');
		}

		public function ratings(): HasMany
		{
			return $this->hasMany(Rating::class, 'freelancer_id');
		}

		public function averageRating()
		{
			return $this->ratings()->avg('rating');
		}

		public function applications(): HasMany
		{
			return $this->hasMany(Application::class, 'applicant_id');
		}

		public function sentMessages(): HasMany
		{
			return $this->hasMany(Message::class, 'sender_id');
		}

		public function receivedMessages(): HasMany
		{
			return $this->hasMany(Message::class, 'receiver_id');
		}
	}

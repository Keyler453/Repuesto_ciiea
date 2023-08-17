<?php

namespace App\Models;

use App\Traits\HasFile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convocation extends Model
{
	use HasFactory, HasFile;

	protected $fillable = [
		'name',
		'date',
		'time',
		'location',
		'description',
	];

	protected $casts = [
		'date' => 'date:Y-m-d',
	];

	// Se castea la hora proporcionada al atributo 'time' para que no guarde segundos
	protected function time(): Attribute
	{
		return Attribute::make(
			// set: fn (string $value) => Carbon::createFromFormat('H:i:s', $value)->format('H:i'),
			get: fn (string $value) => Carbon::createFromFormat('H:i:s', $value)->format('H:i'),
		);
	}
}
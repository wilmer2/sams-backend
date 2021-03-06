<?php

namespace Sams\Entity;

class Employee extends \Eloquent {
	protected $fillable = ['identity_card', 'full_name', 'date_birth',
	                       'phone', 'address', 'gender', 'degree_instruction', 'civil_status',
	                       'office', 'image_url', 'mime', 'activiti', 'break_out', 'id'];

	public function user() {
		return $this->hasOne('Sams\Entity\User');
	}

	public function schedules() {
		return $this->belongsToMany('Sams\Entity\Schedule')->withTimestamps();
	}

	public function attendances() {
		return $this->hasMany('Sams\Entity\Attendance');
	}

	public function permits() {
		return $this->hasMany('Sams\Entity\Permit');
	}

	public function outputs() {
		return $this->hasMany('Sams\Entity\Output');
	}

	
	
}
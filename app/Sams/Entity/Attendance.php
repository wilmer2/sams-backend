<?php

namespace Sams\Entity;

class Attendance extends \Eloquent {
	protected $fillable = ['employee_id', 'turn', 'state', 'start_time', 'departure_time', 'date_day', 'hour_in',
                         'hour_out'];

  public function employee() {
    return $this->belongsTo('Sams\Entity\Employee');
  }

	public function notifying() {
    return $this->morphTo();
  }

}
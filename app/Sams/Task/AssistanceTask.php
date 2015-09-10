<?php

namespace Sams\Task;

use Sams\Repository\AttendanceRepository;

class AssistanceTask extends BaseTask {
  protected $attendanceRepo;

  public function __construct(AttendanceRepository $attendanceRepo) {
    $this->attendanceRepo = $attendanceRepo;
  }

  public function confirmedAssitance($attendance, $state) {
    $hour = $this->getHour();

    if ($state) {
      $scheduleIn = $attendance->start_time;

      $this->confirmHourIn($hour, $scheduleIn);

      $attendance->hour_in = $hour;
      $attendance->state = 'E';
      $message = 'Entrada confirmada';
    } else {
      $attendance->hour_out = $hour;
      $attendance->state = 'A';
      $message = 'Salida confirmada';
    }

    $attendance->save();

    $response = [
      'status' => 'success',
      'message' => $message
    ];

    return $response;
  }

  public function statusEmployee($employeeState) {
    if (!$employeeState) {
      $message = 'Empleado no activo su asistencia no podra ser modificada';

      $this->hasException($message);
    }
  }

  public function checkAssistance($data, $scheduleIn, $scheduleOut, $employeeId, $turn) {
    if ($turn != 'night') {
      $hourIn = $data['hour_in'];
      $hourOut = $data['hour_out'];

      if ($hourIn >= $hourOut) {
        $message = 'Ingrese horas en el orden correcto';

        $this->hasException($message);
      }

      $this->checkHourIn($hourIn, $scheduleOut);
      $this->checkHourOut($hourOut, $hourIn, $employeeId);
    }
   
  }

  public function confirmHourIn($hourIn, $scheduleIn) {
    $minutes = '15';
    $hourMin = rest_minutes($scheduleIn, $minutes);

    if ($hourIn < $hourMin) {
      $message = 'Asistencia podra ser ingresada '.$minutes.' minutos antes que empieze el horario';

      $this->hasException($message);
    }
  }

  public function checkHourIn($hourIn, $scheduleOut) {
    if ($hourIn >= $scheduleOut) {
      $message = 'Ingrese hora de entrada antes que termina el horario';

      $this->hasException($message);
    }
  }

  public function checkHourOut($hourOut, $hourIn, $employeeId) {
    $date = current_date();
    $checkOut = $this->attendanceRepo->checkHourOut($hourIn, $hourOut, $date, $employeeId);

    if ($checkOut->count() > 0) {
      $message = 'Hora de salida interfiere con hora de entrada de otro horario';

      $this->hasException($message);
    }
  }

  public function getHour() {
    $hour = date('H:i');

    return $hour;
  }

}

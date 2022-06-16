<?php 

namespace App\Http\Traits;

trait SearchTrait{
  
  private function dateFilterSetFrom(&$from)
  {
      $date_filter = request()->input('date_filter');

      switch ($date_filter) {
          case 'daily':
              $dt = new \DateTime();
              $from = $dt->format('Y-m-d') . " 00:00:00";
              break;
          case 'weekly':
              $dt = new \DateTime('monday this week');
              $from = $dt->format('Y-m-d') . " 00:00:00";
              break;
          case 'monthly':
              $dt = new \DateTime('first day of this month');
              $from = $dt->format('Y-m-d') . " 00:00:00";
              break;
          case 'yearly':
              $dt = new \DateTime('first day of January');
              $from = $dt->format('Y-m-d') . " 00:00:00";
              break;
      }
  }

  private function dateFilterSetTo(&$to)
  {
      $date_filter = request()->input('date_filter');
      $dt = new \DateTime();

      switch ($date_filter) {
          case 'daily':
              $dt = new \DateTime();
              $to = $dt->format('Y-m-d') . " 23:59:59";
              break;
          case 'weekly':
              $dt = new \DateTime('sunday this week');
              $to = $dt->format('Y-m-d') . " 23:59:59";
              break;
          case 'monthly':
              $dt = new \DateTime('last day of this month');
              $to = $dt->format('Y-m-d') . " 23:59:59";
              break;
          case 'yearly':
              $dt = new \DateTime('last day of December');
              $to = $dt->format('Y-m-d') . " 23:59:59";
              break;
      }
  }
}
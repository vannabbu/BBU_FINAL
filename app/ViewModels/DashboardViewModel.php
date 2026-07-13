<?php

namespace App\ViewModels;

use Illuminate\Contracts\Support\Arrayable;

class DashboardViewModel implements Arrayable
{
    public function __construct(
        public readonly array $navigation,
        public readonly array $doctor,
        public readonly array $breadcrumbs,
        public readonly array $statistics,
        public readonly array $revenueChart,
        public readonly array $patientChart,
        public readonly array $appointmentSummary,
        public readonly array $performance,
        public readonly array $departments,
        public readonly array $activities,
        public readonly array $quickActions,
    ) {
    }

    public function toArray(): array
    {
        return [
            'navigation' => $this->navigation,
            'doctor' => $this->doctor,
            'breadcrumbs' => $this->breadcrumbs,
            'statistics' => $this->statistics,
            'revenueChart' => $this->revenueChart,
            'patientChart' => $this->patientChart,
            'appointmentSummary' => $this->appointmentSummary,
            'performance' => $this->performance,
            'departments' => $this->departments,
            'activities' => $this->activities,
            'quickActions' => $this->quickActions,
        ];
    }
}

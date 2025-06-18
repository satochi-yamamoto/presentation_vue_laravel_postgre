<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'company' => $this->company,
            'position' => $this->position,
            'description' => $this->description,
            'start_date' => $this->start_date->format('Y-m-d'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'is_current' => $this->is_current,
            'responsibilities' => $this->responsibilities,
            'duration' => $this->getDuration(),
            'display_order' => $this->display_order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    protected function getDuration()
    {
        $start = $this->start_date;
        $end = $this->is_current ? now() : $this->end_date;
        
        $years = $start->diffInYears($end);
        $months = $start->diffInMonths($end) % 12;
        
        return $years > 0 
            ? sprintf('%d ano%s e %d mes%s', $years, $years !== 1 ? 's' : '', $months, $months !== 1 ? 'es' : '')
            : sprintf('%d mes%s', $months, $months !== 1 ? 'es' : '');
    }
}

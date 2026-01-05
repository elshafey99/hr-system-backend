<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'employee_number' => $this->employee_number,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'profile_image' => $this->profile_image ? url($this->profile_image) : null,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),
            'marital_status' => $this->marital_status,
            'basic_salary' => $this->basic_salary,
            'hire_date' => $this->hire_date?->format('Y-m-d'),
            'status' => $this->status,
            
            // Relationships
            'nationality' => $this->whenLoaded('nationality', function () {
                return [
                    'id' => $this->nationality->id,
                    'name' => $this->nationality->name,
                    'country_code' => $this->nationality->country_code,
                ];
            }),
            
            'department' => $this->whenLoaded('department', function () {
                return [
                    'id' => $this->department->id,
                    'name' => $this->department->name,
                ];
            }),
            
            'position' => $this->whenLoaded('position', function () {
                return [
                    'id' => $this->position->id,
                    'name' => $this->position->name,
                ];
            }),
            
            'project' => $this->whenLoaded('project', function () {
                return [
                    'id' => $this->project->id,
                    'name' => $this->project->name,
                    'code' => $this->project->code,
                ];
            }),
            
            'manager' => $this->whenLoaded('manager', function () {
                return [
                    'id' => $this->manager->id,
                    'full_name' => $this->manager->full_name,
                    'email' => $this->manager->email,
                ];
            }),
            
            'work_location' => $this->whenLoaded('workLocation', function () {
                return [
                    'id' => $this->workLocation->id,
                    'name' => $this->workLocation->name,
                    'address' => $this->workLocation->address,
                    'latitude' => $this->workLocation->latitude,
                    'longitude' => $this->workLocation->longitude,
                    'radius' => $this->workLocation->radius,
                ];
            }),
            
            'work_schedule' => $this->whenLoaded('workSchedule', function () {
                return [
                    'id' => $this->workSchedule->id,
                    'name' => $this->workSchedule->name,
                    'start_time' => $this->workSchedule->start_time,
                    'end_time' => $this->workSchedule->end_time,
                    'grace_period' => $this->workSchedule->grace_period,
                    'working_days' => $this->workSchedule->working_days,
                ];
            }),
            
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}

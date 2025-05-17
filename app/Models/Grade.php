<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'assignment_score',
        'mid_exam_score',
        'final_exam_score',
        'final_score',
        'grade_letter',
        'notes',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function calculateFinalScore()
    {
        // Example calculation: 30% assignments, 30% midterm, 40% final
        if ($this->assignment_score !== null && $this->mid_exam_score !== null && $this->final_exam_score !== null) {
            $this->final_score = ($this->assignment_score * 0.3) + ($this->mid_exam_score * 0.3) + ($this->final_exam_score * 0.4);
            $this->calculateGradeLetter();
            return $this->final_score;
        }
        return null;
    }

    public function calculateGradeLetter()
    {
        if ($this->final_score === null) {
            return null;
        }

        if ($this->final_score >= 85) {
            $this->grade_letter = 'A';
        } elseif ($this->final_score >= 80) {
            $this->grade_letter = 'A-';
        } elseif ($this->final_score >= 75) {
            $this->grade_letter = 'B+';
        } elseif ($this->final_score >= 70) {
            $this->grade_letter = 'B';
        } elseif ($this->final_score >= 65) {
            $this->grade_letter = 'B-';
        } elseif ($this->final_score >= 60) {
            $this->grade_letter = 'C+';
        } elseif ($this->final_score >= 55) {
            $this->grade_letter = 'C';
        } elseif ($this->final_score >= 40) {
            $this->grade_letter = 'D';
        } else {
            $this->grade_letter = 'E';
        }

        return $this->grade_letter;
    }
}
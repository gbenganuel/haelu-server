<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class MNA extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'food_intake_decline',
        'weight_loss',
        'mobility',
        'psych_stress_or_acute_disease',
        'neurological_problems',
        'bmi',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'screening_score',
        'screening_score_verdict',
    ];

    /**
     * get mna's screening score.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function screeningScore(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => 
                                            $attributes['food_intake_decline'] 
                                            + $attributes['weight_loss']
                                            + $attributes['mobility']
                                            + $attributes['psych_stress_or_acute_disease']
                                            + $attributes['neurological_problems']
                                            + $attributes['bmi']
                                            ,
        );
    }

    /**
     * get mna's screening score verdict.
     *
     * @return string
     */
    protected function getScreeningScoreVerdictAttribute()
    {
        $screening_score = $this->screening_score;
        $verdict;

        // get verdict for patients with normal nutrition
        if(in_array($screening_score, range(12, 14))) {
            $verdict = 'normal';
        }

        // get verdict for patients at risk of malnutrition
        if(in_array($screening_score, range(8, 11))) {
            $verdict = 'susceptible';
        }

        // get verdict for patients that are malnourished
        if(in_array($screening_score, range(0, 7))) {
            $verdict = 'malnourished';
        }

        return $verdict; 
    }

    /**
     * Get the user who owns the Mini Nutritional Assessment record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

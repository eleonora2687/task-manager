<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $fillable = [
        'title', 'description', 'due_date', 'priority', 'status', 'category_id'
    ];

    // Define the relationship with Category model
    public function category()
    {
        return $this->belongsTo(Category::class); // This assumes the foreign key is 'category_id'
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected static function booted()
    {
        static::saving(function ($task) {
            $minDate = now()->toDateString();
            $maxDate = '2100-12-31';

            if ($task->due_date < $minDate || $task->due_date > $maxDate) {
                throw new \Exception("The due date must be between {$minDate} and {$maxDate}.");
            }
        });
    }



}

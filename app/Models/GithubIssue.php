<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GithubIssue extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'url', 'state', 'issue_created_at', 'package_id'];

    /**
     * Get the package that owns the GitHub issue
     */
    public function package()
    {
        return $this->belongsTo('App\Models\Package');
    }

    /**
     * Calculate the number of days since the issue was created
     */
    public function getDaysOldAttribute() {
        $today = new Carbon;
        $created_date = Carbon::createFromFormat('Y-m-d H:s:i', $this->issue_created_at);
        $diff_in_days = $today->diffInDays($created_date);

        return $diff_in_days;
    }
}

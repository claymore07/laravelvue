<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Profile
 *
 * @property int $id
 * @property int $user_id
 * @property string $Fname نام کوچک
 * @property string $Lname نام خانوادگی
 * @property int|null $base پایه
 * @property int $degree_id مدرک تحصیلی
 * @property int $rank_id
 * @property int $position_id نوع همکاری
 * @property int $faculty_id نام دانشکده
 * @property int $department_id نام گروه
 * @property int $member_id نوع عضویت
 * @property string $phone شماره تماس
 * @property string $siba شماره حساب
 * @property string $personal_id شماره دانشجویی یا شماره استادی
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Degree $degree
 * @property-read \App\Department $department
 * @property-read \App\Faculty $faculty
 * @property-read \App\Member $member
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Paper[] $papers
 * @property-read \App\Position $position
 * @property-read \App\Rank $rank
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereDegreeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereFacultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereFname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereLname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile wherePersonalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereRankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereSiba($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile query()
 */
class Profile extends Model
{
    //
    protected $fillable = [
        'user_id', 'Fname', 'Lname', 'base', 'degree_id', 'rank_id',
        'position_id', 'faculty_id', 'department_id', 'member_id',
        'phone', 'siba', 'personal_id',
    ];

    // Forward Relations
    public function papers(){
        return $this->hasMany('App\Paper');
    }

    // Backward Relations
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function rank(){
        return $this->belongsTo('App\Rank');
    }
    public function degree(){
        return $this->belongsTo('App\Degree');
    }
    public function position(){
        return $this->belongsTo('App\Position');
    }
    public function faculty(){
        return $this->belongsTo('App\Faculty');
    }
    public function department(){
        return $this->belongsTo('App\Department');
    }
    public function member(){
        return $this->belongsTo('App\Member');
    }
}

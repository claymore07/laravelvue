<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Files extends Model
{
    //
    protected $table='files';
    protected $fillable = ['name', 'fileable_type', 'fileable_id'];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
    //backward
    public function fileable(){
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::deleted(function ($item){
            $path = '';
            $fileable_type = $item->fileable_type;
            if($fileable_type == 'App\Models\Paper'){
                $path = 'files/papers/';
            }elseif ($fileable_type == 'App\Models\Book'){
                $path = 'files/books/';
            }elseif ($fileable_type == 'App\Models\Reward'){
                $path = 'files/rewards/';
            }elseif ($fileable_type == 'App\Models\Project'){
                $path = 'files/projects/';
            }elseif ($fileable_type == 'App\Models\TEDChair'){
                $path = 'files/tedchairs/';
            }elseif ($fileable_type == 'App\Models\Referee'){
                $path = 'files/referees/';
            }elseif ($fileable_type == 'App\Models\Course'){
                $path = 'files/courses/';
            }elseif ($fileable_type == 'App\Models\Booklet'){
                $path = 'files/booklets/';
            }elseif ($fileable_type == 'App\Models\Invention'){
                $path = 'files/inventions/';
            }elseif ($fileable_type == 'App\Models\Grant'){
                $path = 'files/grants/';
            }elseif ($fileable_type == 'App\Models\ResearchActivity'){
                $path = 'files/research_activity/';
            }

            $filePath = public_path($path).$item->name;
            if(file_exists($filePath)){
                @unlink($filePath);
            }

        });
    }


}

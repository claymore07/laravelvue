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
            if($item->fileable_type == 'App\Models\Paper'){
                $path = 'files/papers/';
            }elseif ($item->fileable_type == 'App\Models\Book'){
                $path = 'files/books/';
            }

            $filePath = public_path($path).$item->name;
            if(file_exists($filePath)){
                @unlink($filePath);
            }

        });
    }


}

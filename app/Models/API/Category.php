<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug', 'description','parent_id'
    ];
    protected $parentColumn = 'parent_id';

    public function parent()
    {
        return $this->belongsTo(Category::class,$this->parentColumn);
    }

    public function children()
    {
        return $this->hasMany(Category::class, $this->parentColumn);
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
    /**

     * Boot the model.

     */

    protected static function boot()
    {
        parent::boot();

        static::created(function ($category) {

            $category->slug = $category->createSlug($category->name);

            $category->save();
        });
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    private function createSlug($name)
    {
        if (static::whereSlug($slug = Str::slug($name))->exists()) {

            $max = static::whereName($name)->latest('id')->skip(1)->value('slug');

            if (isset($max[-1]) && is_numeric($max[-1])) {

                return preg_replace_callback('/(\d+)$/', function ($mathces) {

                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }
        return $slug;
    }
}

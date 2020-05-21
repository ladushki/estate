<?php declare(strict_types = 1);

namespace App;

use App\Traits\ModelValidator;
use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{

    use ModelValidator;

    /**
     * @var string[]
     */
    protected $fillable= ['id', 'title', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'id'=>'required|integer',
            'title'=>'required',
        ];
    }

}

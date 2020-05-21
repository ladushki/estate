<?php declare(strict_types = 1);

namespace App;

use Carbon\Carbon;
use App\Traits\Searchable;
use Illuminate\Support\Str;
use App\Traits\ModelValidator;
use App\Traits\PropertyAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

/**
 * Class Property
 *
 * @package App
 */
class Property extends Model implements \App\Interfaces\Searchable
{
    use Uuid;
    use SoftDeletes;
    use ModelValidator;
    use Searchable;
    use PropertyAttributes;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * @var string[]
     */
    protected $dates = ['last_modified', 'created_at', 'updated_at'];

    /**
     * @var int
     */
    protected $perPage = 24;

    /**
     * @var string[]
     */
    protected $fillable = [
        'uuid',
        'property_type_id',
        'county',
        'country',
        'postcode',
        'town',
        'description',
        'address',
        'image_full',
        'image_thumbnail',
        'latitude',
        'longitude',
        'num_bedrooms',
        'num_bathrooms',
        'price',
        'type',
        'last_modified',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    /**
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function hasExpired(array $data)
    {
        $updated = Carbon::createFromFormat('Y-m-d H:i:s', $data['last_modified']);

        return ! $this->last_modified || $this->last_modified->lessThan($updated);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function needsUpdate(array $data)
    {
        return ! $this->is_locked && $this->hasExpired($data);
    }

    /**
     * @param $image
     * @return string
     */
    private function getImageLink(string $image, array $size): string
    {
        if (! filter_var($image, FILTER_VALIDATE_URL)) {
            return '/images/' . $image;
        }
        [$w, $h] = $size;

        if (Str::contains($image, 'lorem')) {
            return 'https://loremflickr.com/' . $w . '/' . $h . '/arch?random=' . $this->town;
        }

        return $image;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function getModel(): Model
    {
        return new static;
    }
}

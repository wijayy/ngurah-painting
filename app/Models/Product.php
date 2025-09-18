<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama',
                'onUpdate' => true
            ]
        ];
    }

    protected $with = ['transactionDetail'];
    protected $guarded = ['id'];
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class, 'produk_id', 'id_produk');
    }

    public function scopeFilters(Builder $query, array $filters)
    {
        $query->when($filters["search"] ?? false, function ($query, $search) {
            return $query->where("nama", 'like', "%$search%");
        });
    }
}

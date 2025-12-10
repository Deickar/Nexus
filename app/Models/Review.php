<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $table = 'reviews';

    protected $primaryKey = 'review_id';

    // Deshabilitar timestamps automáticos ya que usamos review_date
    public $timestamps = false;

    protected $fillable = [
        'id_producto',
        'id_usuario',
        'review_date',
        'rating',
        'comment',
        'status',
    ];

    protected $casts = [
        'review_date' => 'datetime',
        'rating' => 'integer',
        'status' => 'integer',
    ];

    // Constantes para el estado
    const STATUS_PENDING = 0;

    const STATUS_APPROVED = 1;

    const STATUS_REJECTED = 2;

    // Relaciones
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeByProduct($query, $productId)
    {
        return $query->where('id_producto', $productId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('id_usuario', $userId);
    }
}

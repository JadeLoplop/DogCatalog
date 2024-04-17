<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLikedImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dog_image_id'
    ];

    /**
     * Get the dogImage associated with the UserLikedImage
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dogImage()
    {
        return $this->hasOne(DogImage::class, 'id', 'dog_image_id');
    }
}

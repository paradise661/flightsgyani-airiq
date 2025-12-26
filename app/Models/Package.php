<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(Package::class);
    }

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }

    public function operationalTours()
    {
        return $this->hasMany(OperationalTour::class);
    }

    public function inclusions()
    {
        return $this->hasMany(Inclusion::class);
    }

    public function inclusion()
    {
        return $this->hasOne(Inclusion::class);
    }

    public function exclusions()
    {
        return $this->hasMany(Exclusion::class);
    }

    public function exclusion()
    {
        return $this->hasOne(Exclusion::class);
    }

    public function visas()
    {
        return $this->hasMany(Visa::class);
    }

    public function visa()
    {
        return $this->hasOne(Visa::class);
    }

    public function termsAndConditions()
    {
        return $this->hasMany(TermsAndCondition::class);
    }

    public function term()
    {
        return $this->hasOne(TermsAndCondition::class);
    }

    public function priceDetail()
    {
        return $this->hasOne(PriceDetails::class);
    }

    public function priceDetails()
    {
        return $this->hasMany(PriceDetails::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

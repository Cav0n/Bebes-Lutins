<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class Setting extends Model
{
    public static function getValue(string $key, $default = null): string
    {
        return \App\Setting::where('key', $key)->exists() ? \App\Setting::where('key', $key)->first()->value: $default;
    }

    public function getI18nAttribute()
    {
        return \App\SettingsI18n::where('setting_id', $this->id)->where('locale', 'FR')->first();
    }

    public function getHelpInputAttribute()
    {
        return '<small id="help'.$this->key.'" class="form-text text-muted">'.($this->i18n ? $this->i18n->help : null).'</small>';
    }

    public function getInputAttribute()
    {
        switch ($this->type) {
            case 'text':
                return '<input type="text" class="form-control" name="'.$this->key.'" id="'.$this->key.'" aria-describedby="help'.$this->key.'" value="'.$this->value.'">';
            break;
            case 'textarea':
                return '<textarea class="form-control" name="'.$this->key.'" id="'.$this->key.'" aria-describedby="help'.$this->key.'" rows=6>'.$this->value.'</textarea>';
            break;
            case 'email':
                return '<input type="email" class="form-control" name="'.$this->key.'" id="'.$this->key.'" aria-describedby="help'.$this->key.'" value="'.$this->value.'">';
            break;
            case 'number':
                return '<input type="number" class="form-control" name="'.$this->key.'" id="'.$this->key.'" aria-describedby="help'.$this->key.'" value='.$this->value.'>';
            break;
            case 'price':
                return '<div class="input-group">
                    <input class="form-control" type="number" name="'.$this->key.'" aria-describedby="help'.$this->key.'" value="'.$this->value.'" min=0 step=0.01>
                    <div class="input-group-append">
                        <span class="input-group-text" id="'.$this->key.'">€</span>
                    </div>
                </div>';
            break;
        }
    }
}

<?php

namespace App\Services;

use App\Models\GeneralSetting;
use App\Traits\ImageUpload;

class GeneralSettingService
{
    use ImageUpload;

    public function generalSettingCurrency()
    {
        $data = GeneralSetting::select('key', 'value')
            ->whereIn('key', ['currency_name', 'currency_symbol'])
            ->pluck('value', 'key');

        return $data;
    }

    public function updateCurrency($request)
    {
        $input = $request->validated();
        $nameUpdateData['key'] = 'currency_name';
        $nameUpdateData['value'] = $input['currency_name'];

        $nameUpdate = GeneralSetting::updateOrCreate(
            ['key' => 'currency_name'],
            $nameUpdateData
        );

        $nameUpdateData['key'] = 'currency_symbol';
        $nameUpdateData['value'] = $input['currency_symbol'];

        $symbolUpdate = GeneralSetting::updateOrCreate(
            ['key' => 'currency_symbol'],
            $nameUpdateData
        );
    }

    public function generalSettingDefaultImage()
    {
        $data = GeneralSetting::select('key', 'value')
            ->where('key', 'default_image')
            ->value('value');

        return $data;
    }

    public function updateDefaultImage($request)
    {
        $data['key'] = 'default_image';
        $image = $request->image;
        if ($image) {
            $this->deleteImage($this->generalSettingDefaultImage()); //delete old image
            $data['value'] = $this->uploadImage($image, 'images/default/');
        }

        return GeneralSetting::updateOrCreate(
            ['key' => 'default_image'],
            $data
        );
    }
}

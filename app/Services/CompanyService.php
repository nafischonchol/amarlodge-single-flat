<?php

namespace App\Services;

use App\Models\Company;
use App\Traits\ImageUpload;

class CompanyService
{
    use ImageUpload;

    public function get()
    {
        return Company::select('id', 'name', 'mobile', 'email', 'address', 'image')
            ->first();
    }

    public function update($request)
    {
        $data = $request->validated();
        $image = $request->image;

        if ($image) {
            $data['image'] = $this->uploadImage($image, 'images/company/logo/');
            if ($company = Company::first()) {
                $this->deleteImage($company['image']);
            }
        } else {
            unset($data['image']);
        }

        Company::updateOrCreate([], $data);

        return Company::first();
    }
}

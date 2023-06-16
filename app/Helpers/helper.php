<?php

use App\Models\ImageValues;
use App\Models\Products;
use Carbon\Carbon;

function generateVariant($data)
{
    $aryVariant = [];
    foreach ($data as $type => $aryValue) {
        if (!empty($aryValue)) {
            foreach ($aryValue as $k => $value) {
                if (isset($data[$type + 1])) {
                    foreach ($data[$type + 1] as $t => $nextValue) {
                        $aryVariant[] = [
                            $value, $nextValue
                        ];
                    }
                }
            }
        }
    }

    return $aryVariant;
}


/**
 * Function process image and save image to database
 *
 * @param array $files
 * @param [integer] $related_id
 * @param [integer] $type
 * @param boolean $isPrimary
 * @return boolean
 */
function processImage($files = [], $related_id, $type, $isPrimary = false, $isUpdate = false)
{
    // input dau vao la file (1 file hoac nhieu file)
    try {
        if (is_array($files)) {
            $aryRelatedImageName = [];
            foreach ($files as $key => $image) {
                $isPrimary = false;
                if ($key === 'primary') {
                    $isPrimary = true;
                }

                $destination_path      = config('handle.destination_path');
                $imageName             = $type . '/' . $image->getClientOriginalName();
                $image->storeAs($destination_path, $imageName);
                $aryRelatedImageName[] = [
                    'name'       => $imageName,
                    'is_primary' => $isPrimary
                        ? config('handle.primary_image.primary')
                        : config('handle.primary_image.not_primary'),
                    'related_id' => $related_id,
                    'image_type' => config('handle.image_type.' . $type),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),

                ];
            }
            if ($isUpdate) {
                ImageValues::where('related_id', $related_id)->get()->each(function ($image) {
                    $image->delete();
                });
            }

            return ImageValues::insert($aryRelatedImageName);
        }
    } catch (\Exception $e) {
        Log::error($e->getMessage());
        return false;
    }

    return false;
}

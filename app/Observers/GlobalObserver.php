<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;

class GlobalObserver
{
    private function storeActivityFormat($model)
    {
        $model_name = class_basename($model);
        $formatted_model_name = $this->addSpacesBeforeCapitalLetters($model_name);
        if ($model_name == 'PaymentBill') {
            return 'Bill Paid By Tenant';
        }
        if ($model_name == 'Rent') {
            return 'Rent Generated';
        }
        if ($model_name == 'AccountBalance') {
            if ($model->transaction_type == -1) {
                return 'Use '.$model->bank_type.' balance for '.$model->doc_type;
            }

            return 'Store money to '.$model->bank_type;
        }
        if ($model_name == 'MoveOutRequest') {
            return 'Get move out request from tenant!';
        }
        if ($model_name == 'RoleHasPermission') {
            return 'Permission Granted';
        }

        return $formatted_model_name.' Created';
    }

    public function created($model)
    {
        $this->logActivity($model, 'Stored', $this->storeActivityFormat($model));
    }

    private function updateActivityFormat($model)
    {
        $model_name = class_basename($model);
        $formatted_model_name = $this->addSpacesBeforeCapitalLetters($model_name);
        if ($model_name == 'MoveOutRequest') {
            return 'Update move out request';
        }

        return $formatted_model_name.' Updated';
    }

    public function updated($model)
    {
        $this->logActivity($model, 'Updated', $this->updateActivityFormat($model));
    }

    public function deleted($model)
    {
        $this->logActivity($model, 'Deleted');
    }

    private function addSpacesBeforeCapitalLetters($string)
    {
        return preg_replace('/(?<!\ )[A-Z]/', ' $0', $string);
    }

    private function isExtraInfoRequired($model)
    {
        $model_name = class_basename($model);
        if ($model_name == 'RoleHasPermission') {
            return \json_encode($model);
        }

        return null;
    }

    private function logActivity($model, $activityType, $activity = null)
    {

        $user = auth()->user();
        if (! $user) {
            return; // Unable to log the activity if user data is not available.
        }
        $model_name = class_basename($model);
        $activity = $activity ?? $this->addSpacesBeforeCapitalLetters($model_name).' '.$activityType;
        $extra_info = $this->isExtraInfoRequired($model);
        $data = [
            'user_id' => $user->id,
            'model_id' => $model->id,
            'model_name' => $model_name,
            'activity_type' => $activityType,
            'activity' => $activity,
            'extra_info' => $extra_info,
        ];

        ActivityLog::create($data);
    }
}

<?php

class B24apiUserRequest extends B24Api
{
    public function __construct($memberId)
    {
        parent::__construct($memberId);
        $this->api->onAccessTokenRefresh(function (\Bitrix24Api\Config\Credential $credential) {

        });
    }

    protected static function getSettings($memberId): array
    {
        $data = parent::getSettings($memberId);
        if (!empty($data)) {
            $data['access_token'] = $_REQUEST['AUTH_ID'];
            $data['refresh_token'] = $_REQUEST['REFRESH_ID'];
            $data['application_token'] = $_REQUEST['APP_SID'];
            return $data;
        }
        return [];
    }

    public function getProfile()
    {
        try {
            return $this->api->profile()->call()->toArray();
        } catch (\Exception $exception) {

        }

        return false;
    }
}

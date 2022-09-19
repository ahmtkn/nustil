<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{

    public function up(): void
    {
        foreach (config('nustil.settings') as $setting => $value) {
            $this->migrator->add('general.'.$setting, $value);
        }
    }

}

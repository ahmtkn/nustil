<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Arr;
use App\Settings\GeneralSettings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\LaravelSettings\Settings;

class SettingsController extends Controller
{

    public function index()
    {
        return view('dashboard.settings.index');
    }

    public function update(Request $request, GeneralSettings $settings)
    {
        $rules = [];
        $defaults = config('nustil.settings');
        foreach ($defaults as $setting => $value) {
            $rules[$setting] = 'required';
            if (is_array($value)) {
                $rules[$setting] = 'sometimes|array';
            }
        }
        $validated = $request->validate($rules);

        foreach (drupal_array_merge_deep($defaults, $validated) as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $v = is_bool($settings->$key[$k]) && $v == 'on' ? true : $v;

                    $settings->$key[$k] = $v;
                }
                continue;
            }
            $settings->$key = $value;
        }
        $settings->save();
        cache()->flush();

        return redirect()->back()->with('message', 'Settings updated successfully');
    }

    public function reset(GeneralSettings $settings)
    {
        $settings->reset();
        cache()->flush();

        return redirect()->back()->with('message', 'Settings reset successfully');
    }

}

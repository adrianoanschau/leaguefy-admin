<?php

namespace Leaguefy\LeaguefyAdmin\Controllers;

use Leaguefy\LeaguefyAdmin\Services\SettingsService;
use Leaguefy\LeaguefyAdmin\Requests\SettingsBrandRequest;
use Leaguefy\LeaguefyAdmin\Requests\SettingsStylesRequest;
use Leaguefy\LeaguefyAdmin\Requests\SettingsRoutePrefixRequest;

class SettingsController extends Controller
{
    public function __construct(
        private SettingsService $settingsService,
    ) {
        $this->settingsService = $settingsService;
    }

    public function routePrefixChange(SettingsRoutePrefixRequest $request)
    {
        $this->settingsService->set('route-prefix', $request->prefix);

        $oldPrefix = config('leaguefy-admin.route.prefix');

        preg_match("/(http[s]?:\/\/)?([^\/\s]+\/)(.*)/i", url()->previous(), $matches);
        $path = (function ()  use ($oldPrefix, $request, $matches) {
            if (!is_null($oldPrefix) && $oldPrefix !== "") {
                return str_replace($oldPrefix, $request->prefix, $matches[3]);
            }

            return $request->prefix;
        })();
        $url = url()->to($path);

        return redirect($url)
            ->with('toastr', collect([
                'type' => ['success'],
                'message' => ['Configurações atualizadas!'],
            ]));
    }

    public function routePrefixRemove()
    {
        $this->settingsService->set('route-prefix', '');

        $oldPrefix = config('leaguefy-admin.route.prefix');

        preg_match("/(http[s]?:\/\/)?([^\/\s]+\/)(.*)/i", url()->previous(), $matches);
        $path = str_replace($oldPrefix, '', $matches[3]);
        $url = url()->to($path);

        return redirect($url)
            ->with('toastr', collect([
                'type' => ['success'],
                'message' => ['Configurações atualizadas!'],
            ]));
    }

    public function brandChange(SettingsBrandRequest $request)
    {
        if (!is_null($request->title)) {
            $this->settingsService->set('title', $request->title);
        }
        if (!is_null($request->logo)) {
            $this->settingsService->set('logo', $request->logo);
        }
        if (!is_null($request->get('logo-text-color'))) {
            $this->settingsService->set('topbar.logo_color', $request->get('logo-text-color'));
        }

        return redirect()->back()
            ->with('toastr', collect([
                'type' => ['success'],
                'message' => ['Configurações atualizadas!'],
            ]));
    }

    public function stylesChange(SettingsStylesRequest $request)
    {
        if (!is_null($request->get('topbar-color'))) {
            $this->settingsService->set('topbar-color', $request->get('topbar-color'));
        }

        return redirect()->back()
            ->with('toastr', collect([
                'type' => ['success'],
                'message' => ['Configurações atualizadas!'],
            ]));
    }
}

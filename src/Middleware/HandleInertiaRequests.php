<?php

namespace Leaguefy\LeaguefyAdmin\Middleware;

use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Http\Request;
use JeroenNoten\LaravelAdminLte\AdminLte;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'leaguefy-admin::app';

    public function __construct(private AdminLte $adminLte)
    {
    }

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'alert' => [
                'error' => $request->session()->get('error'),
                'success' => $request->session()->get('success'),
                'info' => $request->session()->get('info'),
                'warning' => $request->session()->get('warning'),
            ],
            'toastr' => $request->session()->get('toastr'),
            'config' => config('leaguefy-admin'),
            'menu' => [
                'sidebar' => $this->adminLte->menu('sidebar'),
                'navbar-left' => $this->adminLte->menu('navbar-left'),
                'navbar-right' => $this->adminLte->menu('navbar-right'),
                'navbar-user' => $this->adminLte->menu('navbar-user'),
            ],
        ]);
    }
}

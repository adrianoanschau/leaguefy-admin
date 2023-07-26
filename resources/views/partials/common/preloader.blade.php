<div class="preloader flex-column justify-content-center align-items-center">

    {{-- Preloader logo --}}
    <img src="{{ asset(config('leaguefy-admin.preloader.img.path', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
         class="{{ config('leaguefy-admin.preloader.img.effect', 'animation__shake') }}"
         alt="{{ config('leaguefy-admin.preloader.img.alt', 'AdminLTE Preloader Image') }}"
         width="{{ config('leaguefy-admin.preloader.img.width', 60) }}"
         height="{{ config('leaguefy-admin.preloader.img.height', 60) }}">

</div>

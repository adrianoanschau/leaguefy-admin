<div>
    <h4 class="px-3 py-2 m-0">
        <span>Settings</span>
        <button type="button" class="btn btn-light btn-sm close px-2 py-1" aria-label="Close"
            data-widget="control-sidebar">
            <span aria-hidden="true">&times;</span>
        </button>
    </h4>

    <hr class="mt-1 mb-2">

    <small class="form-text text-muted text-center">
        Ao submeter alterações a página será recarregada.
    </small>

    <hr class="mb-2">

    <div class="accordion" id="settingsSidebar">
        <div class="card rounded-0 elevation-0">
          <div class="card-header p-0" id="brandSettings">
            <h2 class="mb-0">
              <button class="btn btn-link btn-block text-left"
                type="button" data-toggle="collapse" data-target="#collapseBrand"
                aria-expanded="true" aria-controls="collapseBrand">
                Marca
              </button>
            </h2>
          </div>

          <div id="collapseBrand" class="collapse show" aria-labelledby="brandSettings" data-parent="#settingsSidebar">
            <div class="card-body">
                @include('leaguefy-admin::partials.settings.brand')
            </div>
          </div>
        </div>

        <div class="card rounded-0 elevation-0">
            <div class="card-header p-0" id="stylesSettings">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left"
                  type="button" data-toggle="collapse" data-target="#collapseStyles"
                  aria-expanded="true" aria-controls="collapseStyles">
                  Estilos
                </button>
              </h2>
            </div>

            <div id="collapseStyles" class="collapse " aria-labelledby="stylesSettings" data-parent="#settingsSidebar">
              <div class="card-body">
                  @include('leaguefy-admin::partials.settings.styles')
              </div>
            </div>
          </div>

        <div class="card rounded-0 elevation-0">
            <div class="card-header p-0" id="routesSettings">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left"
                  type="button" data-toggle="collapse" data-target="#collapseRoutes"
                  aria-expanded="true" aria-controls="collapseRoutes">
                  Rotas
                </button>
              </h2>
            </div>

            <div id="collapseRoutes" class="collapse " aria-labelledby="routesSettings" data-parent="#settingsSidebar">
              <div class="card-body">
                  @include('leaguefy-admin::partials.settings.route-prefix')
              </div>
            </div>
          </div>
      </div>
</div>

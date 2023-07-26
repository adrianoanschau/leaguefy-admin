@php
    $topbarColor = config('leaguefy-admin.topbar.color', null);
@endphp

<form method="post" action="{{ route('leaguefy.admin.settings.styles.change') }}">
    @csrf
    <fieldset>
        <h6>Cores de Fundo</h6>

        <div class="form-group">
            <label for="topbar-color">Barra de Topo</label>
            <select
                class="custom-select mb-3 border-0"
                id="topbar-color"
                name="topbar-color"
                value="{{$topbarColor}}"
                aria-describedby="topbar-color"
                data-selectable="colors">
                <option value="">--</option>
                <option value="bg-primary" class="bg-primary">Primary</option>
                <option value="bg-secondary" class="bg-secondary">Secondary</option>
                <option value="bg-info" class="bg-info">Info</option>
                <option value="bg-success" class="bg-success">Success</option>
                <option value="bg-danger" class="bg-danger">Danger</option>
                <option value="bg-indigo" class="bg-indigo">Indigo</option>
                <option value="bg-purple" class="bg-purple">Purple</option>
                <option value="bg-pink" class="bg-pink">Pink</option>
                <option value="bg-navy" class="bg-navy">Navy</option>
                <option value="bg-lightblue" class="bg-lightblue">Lightblue</option>
                <option value="bg-teal" class="bg-teal">Teal</option>
                <option value="bg-cyan" class="bg-cyan">Cyan</option>
                <option value="bg-dark" class="bg-dark">Dark</option>
                <option value="bg-gray" class="bg-gray">Gray</option>
                <option value="bg-gray-dark" class="bg-gray-dark">Gray Dark</option>
                <option value="bg-light" class="bg-light">Light</option>
                <option value="bg-warning" class="bg-warning">Warning</option>
                <option value="bg-white" class="bg-white">White</option>
                <option value="bg-orange" class="bg-orange">Orange</option>
            </select>
        </div>
    </fieldset>

    <button type="submit" class="btn btn-primary btn-sm mb-1 w-100">
        <i class="fas fa-fw fa-sm fa-save"></i>
        <span>Salvar</span>
    </button>
</form>

@push('js')
<script>
    document.querySelectorAll("[data-selectable='colors']").forEach((el) => {
        const value = el.getAttribute('value');
        if (value !== '') {
            el.classList.add(value);
            el.querySelector(`option.${value}`).selected = true;
        }
        el.addEventListener('change', function (event, val) {
            const oldValue = event.target.getAttribute('value');
            const value = event.target.value;
            if (oldValue !== '') event.target.classList.remove(oldValue);
            event.target.classList.add(value);
            event.target.setAttribute('value', value);
            event.target.querySelector(`option.${value}`).selected = true;
        });
    })
</script>
@endpush

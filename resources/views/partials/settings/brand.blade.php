@php
    $title = config('leaguefy-admin.title', null);
    $logo = config('leaguefy-admin.logo', null);
    $topbarColor = config('leaguefy-admin.topbar.color', null);
    $logoTextColor = config('leaguefy-admin.topbar.logo_color', 'text-dark');
@endphp

<form method="post" action="{{ route('leaguefy.admin.settings.brand.change') }}">
    @csrf

    <div class="form-group">
        <label for="title">Título</label>
        <input type="text"
            class="form-control"
            id="title"
            name="title"
            aria-describedby="title"
            value="{{$title}}"
            placeholder="Título">
    </div>

    <div class="form-group">
        <label for="logo">Logo</label>
        <input type="text"
            class="form-control"
            id="logo"
            name="logo"
            aria-describedby="logo"
            value="{{$logo}}"
            placeholder="Logo">
    </div>

    <div class="form-group">
        <label for="logo-text-color">Cor do Logo</label>
        <select
            @class(["custom-select mb-3 border-0", $topbarColor])
            id="logo-text-color"
            name="logo-text-color"
            value="{{$logoTextColor}}"
            aria-describedby="logo-text-color"
            data-selectable="colors">
            <option value="">--</option>
            <option value="text-primary" class="text-primary">Primary</option>
            <option value="text-secondary" class="text-secondary">Secondary</option>
            <option value="text-info" class="text-info">Info</option>
            <option value="text-success" class="text-success">Success</option>
            <option value="text-danger" class="text-danger">Danger</option>
            <option value="text-indigo" class="text-indigo">Indigo</option>
            <option value="text-purple" class="text-purple">Purple</option>
            <option value="text-pink" class="text-pink">Pink</option>
            <option value="text-navy" class="text-navy">Navy</option>
            <option value="text-lightblue" class="text-lightblue">Lightblue</option>
            <option value="text-teal" class="text-teal">Teal</option>
            <option value="text-cyan" class="text-cyan">Cyan</option>
            <option value="text-dark" class="text-dark">Dark</option>
            <option value="text-gray" class="text-gray">Gray</option>
            <option value="text-gray-dark" class="text-gray-dark">Gray Dark</option>
            <option value="text-light" class="text-light">Light</option>
            <option value="text-warning" class="text-warning">Warning</option>
            <option value="text-white" class="text-white">White</option>
            <option value="text-orange" class="text-orange">Orange</option>
        </select>
    </div>

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

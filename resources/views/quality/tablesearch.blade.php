<form method="GET" class="d-flex">
    <input type="text" 
           name="search" 
           class="form-control" 
           placeholder="{{ $placeholder ?? 'Search...' }}"
           value="{{ request('search') }}"
           oninput="this.form.submit()">

    <button class="btn btn-primary ms-2">
        <i class="bi bi-search"></i>
    </button>
</form>

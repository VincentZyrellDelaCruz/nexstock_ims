@props(['placeholder' => 'Search...'])

<div class="mb-3">
    <input type="search" {{ $attributes->merge([ 'class' => 'form-control table-search', 'placeholder' => $placeholder ]) }} />
</div>

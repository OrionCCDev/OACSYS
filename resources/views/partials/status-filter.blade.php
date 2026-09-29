{{--
    Status filter for a list page. One button per status with how many rows
    it has, so picking one is a single click and an empty status is obvious
    before clicking it.

    $filter  App\Support\StatusFilter
    $route   name of the list's index route
--}}
<div class="status-filter d-flex flex-wrap align-items-center mb-20">
    <span class="font-weight-600 mr-10 mb-1">Status</span>

    <a href="{{ route($route) }}"
       class="btn btn-sm mr-1 mb-1 {{ $filter->current === null ? 'btn-primary' : 'btn-secondary' }}">
        All <span class="badge badge-light ml-1">{{ $filter->total }}</span>
    </a>

    @foreach($filter->statuses as $value => $label)
    <a href="{{ route($route, ['status' => $value]) }}"
       class="btn btn-sm mr-1 mb-1 {{ $filter->current === $value ? 'btn-primary' : 'btn-secondary' }}">
        {{ $label }} <span class="badge badge-light ml-1">{{ $filter->count($value) }}</span>
    </a>
    @endforeach
</div>

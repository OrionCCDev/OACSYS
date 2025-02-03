<div class="col-12 col-md-4 my-15">
    <form action="{{ route('employees.updateFromExcel') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" class="form-control mb-2">
        <button type="submit" style="width: 100%;height:150px;display:flex;justify-content: center;align-items: center;" class="btn btn-gradient-warning btn-wth-icon btn-lg">
            <span class="icon-label">
                <span class="feather-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                        <line x1="1" y1="10" x2="23" y2="10"></line>
                    </svg>
                </span>
            </span>
            <span class="btn-text" style="font-size: 25px">Update Employees From Excel</span>
        </button>
    </form>
</div>

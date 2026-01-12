@extends('admin.layout')

@section('content')
    <div class="main-content">
        <section class="section">

            <div class="section-header">
                <h1>My Students Report</h1>
            </div>

            {{-- FILTERS --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h4>Filters</h4>
                </div>
                <div class="card-body">
                    <form id="filtersForm" class="row align-items-end">

                        <div class="col-md-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">All</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <button class="btn btn-primary">
                                <i class="fas fa-filter"></i> Apply
                            </button>
                        </div>

                    </form>
                </div>
            </div>

           {{-- STATS CARDS --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Students</h4>
                </div>
                <div class="card-body" id="stat-total">{{ $stats['total'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Active</h4>
                </div>
                <div class="card-body" id="stat-active">{{ $stats['active'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Inactive</h4>
                </div>
                <div class="card-body" id="stat-inactive">{{ $stats['inactive'] }}</div>
            </div>
        </div>
    </div>
</div>


            {{-- TABLE --}}
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between">
                    <h4>Students Overview</h4>

                    <a id="exportBtn"
   href="{{ route('trainer.reports.export.pdf', ['type'=>'students']) }}"
   class="btn btn-danger btn-sm">
    <i class="fas fa-file-pdf"></i> Export PDF
</a>
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Courses</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="reportTable">
                            @include('trainer.reports.partials.students-table', ['reports' => $reports])
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>
@endsection

@push('scripts')
<script>
document.getElementById('filtersForm').addEventListener('submit', function(e){
    e.preventDefault();

    const params = new URLSearchParams(new FormData(this)).toString();

    // update table
    fetch("{{ route('trainer.reports',['type'=>'students']) }}?"+params,{
        headers:{
            "X-Requested-With":"XMLHttpRequest",
            "Accept":"application/json"
        }
    })
    .then(r=>r.json())
    .then(res=>{
        document.getElementById('reportTable').innerHTML = res.table;
        document.getElementById('stat-total').innerText = res.stats.total;
        document.getElementById('stat-active').innerText = res.stats.active;
        document.getElementById('stat-inactive').innerText = res.stats.inactive;
    });

    // update PDF link
    document.getElementById('exportBtn').href =
        "{{ route('trainer.reports.export.pdf',['type'=>'students']) }}?"+params;
});
</script>
@endpush

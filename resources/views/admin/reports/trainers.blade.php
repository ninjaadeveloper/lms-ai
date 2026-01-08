@extends('admin.layout')

@section('content')
<div class="main-content">
<section class="section">

    {{-- HEADER --}}
    <div class="section-header">
        <h1>Trainers Report</h1>
    </div>

    {{-- ================= FILTERS ================= --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header"><h4>Filters</h4></div>
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

    {{-- ================= STATS CARDS ================= --}}
    <div class="row mb-4">
    <div class="col-md-4">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary"><i class="fas fa-chalkboard-teacher"></i></div>
            <div class="card-wrap">
                <div class="card-header"><h4>Total Trainers</h4></div>
                <div class="card-body" id="stat-total">{{ $stats['total'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success"><i class="fas fa-check-circle"></i></div>
            <div class="card-wrap">
                <div class="card-header"><h4>Active Trainers</h4></div>
                <div class="card-body" id="stat-active">{{ $stats['active'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger"><i class="fas fa-times-circle"></i></div>
            <div class="card-wrap">
                <div class="card-header"><h4>Inactive Trainers</h4></div>
                <div class="card-body" id="stat-inactive">{{ $stats['inactive'] }}</div>
            </div>
        </div>
    </div>
</div>


    {{-- ================= TABLE ================= --}}
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-0">Trainers Overview</h4>

            {{-- EXPORT BUTTON --}}
            <a href="{{ route('admin.reports.export.pdf', ['type' => 'trainers']) }}"
   class="btn btn-danger btn-sm">
    <i class="fas fa-file-pdf"></i> Export PDF
</a>

        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Trainer</th>
                            <th>Email</th>
                            <th>Total Courses</th>
                            <th>Total Quizzes</th>
                        </tr>
                    </thead>
                    <tbody id="reportTable">
                        @include('admin.reports.partials.trainers-table', ['reports' => $reports])
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('filtersForm');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const params = new URLSearchParams(new FormData(form)).toString();

        fetch("{{ route('admin.reports.type','trainers') }}?" + params, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(res => {
            document.getElementById('reportTable').innerHTML = res.table;

            document.getElementById('stat-total').innerText   = res.stats.total;
            document.getElementById('stat-courses').innerText = res.stats.courses;
            document.getElementById('stat-quizzes').innerText = res.stats.quizzes;
        });
    });

});
</script>
@endpush


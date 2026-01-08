@extends('admin.layout')

@section('content')
<div class="main-content">
<section class="section">

{{-- ================= HEADER ================= --}}
<div class="section-header">
    <h1>Courses Report</h1>
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
                <label>Trainer</label>
                <select name="trainer" class="form-control">
                    <option value="">All Trainers</option>
                    @foreach($trainers as $t)
                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label>From</label>
                <input type="date" name="from" class="form-control">
            </div>

            <div class="col-md-2">
                <label>To</label>
                <input type="date" name="to" class="form-control">
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Apply
                </button>
                <button type="button" id="resetBtn" class="btn btn-light">
                    Reset
                </button>
            </div>

        </form>
    </div>
</div>

{{-- ================= STATS CARDS ================= --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary"><i class="fas fa-book"></i></div>
            <div class="card-wrap">
                <div class="card-header"><h4>Total Courses</h4></div>
                <div class="card-body" id="stat-total">{{ $stats['total'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success"><i class="fas fa-check-circle"></i></div>
            <div class="card-wrap">
                <div class="card-header"><h4>Active</h4></div>
                <div class="card-body" id="stat-active">{{ $stats['active'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger"><i class="fas fa-times-circle"></i></div>
            <div class="card-wrap">
                <div class="card-header"><h4>Inactive</h4></div>
                <div class="card-body" id="stat-inactive">{{ $stats['inactive'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-statistic-1">
            <div class="card-icon bg-info"><i class="fas fa-users"></i></div>
            <div class="card-wrap">
                <div class="card-header"><h4>Total Students</h4></div>
                <div class="card-body" id="stat-students">{{ $stats['students'] }}</div>
            </div>
        </div>
    </div>
</div>

{{-- ================= TABLE ================= --}}
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between">
        <h4>Courses Overview</h4>
        <a href="{{ route('admin.reports.export.pdf', ['type' => 'courses']) }}"
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
                        <th>Course</th>
                        <th>Trainer</th>
                        <th>Quizzes</th>
                        <th>Students</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="reportTable">
                    @include('admin.reports.partials.courses-table', ['reports' => $reports])
                </tbody>
            </table>
        </div>
    </div>
</div>

</section>
</div>
@endsection

{{-- ================= PURE JS (NO REFRESH) ================= --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('filtersForm');
    const resetBtn = document.getElementById('resetBtn');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        loadReport(new URLSearchParams(new FormData(form)).toString());
    });

    resetBtn.addEventListener('click', function () {
        form.reset();
        loadReport('');
    });

    function loadReport(query) {
        fetch("{{ route('admin.reports.type','courses') }}?" + query, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('reportTable').innerHTML = data.table;

            document.getElementById('stat-total').innerText = data.stats.total;
            document.getElementById('stat-active').innerText = data.stats.active;
            document.getElementById('stat-inactive').innerText = data.stats.inactive;
            document.getElementById('stat-students').innerText = data.stats.students;
        });
    }

});
</script>
@endpush

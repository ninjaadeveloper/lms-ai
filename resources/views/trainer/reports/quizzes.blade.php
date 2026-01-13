@extends('admin.layout')

@section('content')
    <div class="main-content">
        <section class="section">

            {{-- ================= HEADER ================= --}}
            <div class="section-header">
                <h1>My Quizes Reports</h1>
            </div>

            {{-- ================= FILTERS ================= --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h4>Filters</h4>
                </div>
                <div class="card-body">
                    <form id="filtersForm" class="row">

                        <div class="col-md-3">
                            <label>Course</label>
                            <select name="course" class="form-control">
                                <option value="">All Courses</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Date From</label>
                            <input type="date" name="from" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label>Date To</label>
                            <input type="date" name="to" class="form-control">
                        </div>

                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-filter"></i> Apply
                            </button>
                            <button type="button" id="resetBtn" class="btn btn-light">
                                Clear
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            {{-- ================= STATS ================= --}}
            <div class="row" id="statsArea">
                <div class="col-md-4">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info"><i class="fas fa-users"></i></div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Attempts</h4>
                            </div>
                            <div class="card-body" id="stat-attempts">{{ $stats['attempts'] }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success"><i class="fas fa-check-circle"></i></div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pass %</h4>
                            </div>
                            <div class="card-body" id="stat-pass">{{ $stats['pass_percent'] }}%</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger"><i class="fas fa-times-circle"></i></div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Fail %</h4>
                            </div>
                            <div class="card-body" id="stat-fail">{{ $stats['fail_percent'] }}%</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= TABLE ================= --}}
            <div class="card shadow-sm mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Quiz Performance Report</h4>

                    <a id="exportBtn" href="{{ route('trainer.reports.export.pdf', ['type' => 'quizzes']) }}"
                        target="_blank" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>

                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Quiz</th>
                                    <th>Course</th>
                                    <th>Attempts</th>
                                    <th>Avg Score</th>
                                    <th>Pass %</th>
                                </tr>
                            </thead>
                            <tbody id="reportTable">
                                @include('trainer.reports.partials.quizzes-table', ['reports' => $reports])
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
        const form = document.getElementById('filtersForm');
        const resetBtn = document.getElementById('resetBtn');
        const table = document.getElementById('reportTable');

        function loadQuizzes(params = "") {
            fetch("{{ route('trainer.reports.type', 'quizzes') }}?" + params, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(r => r.json())
                .then(res => {
                    table.innerHTML = res.table;
                    document.getElementById('stat-attempts').innerText = res.stats.attempts;
                    document.getElementById('stat-pass').innerText = res.stats.pass_percent + "%";
                    document.getElementById('stat-fail').innerText = res.stats.fail_percent + "%";

                    document.getElementById('exportBtn').href =
                        "{{ route('trainer.reports.export.pdf', ['type' => 'quizzes']) }}?" + params;
                });
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault(); // 

            const params = new URLSearchParams(new FormData(this)).toString();
            loadQuizzes(params);
        });

        resetBtn.addEventListener('click', function () {
            form.reset();
            loadQuizzes("");
        });
    </script>
@endpush
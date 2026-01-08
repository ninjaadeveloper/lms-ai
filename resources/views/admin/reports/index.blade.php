@extends('admin.layout')

@section('content')
  <div class="main-content">
    <section class="section">

      <div class="section-header">
        <h1>Reports</h1>
      </div>

      {{-- FILTERS --}}
      <div class="card mb-4">
        <div class="card-body">
          <form method="GET" class="row">
            <div class="col-md-3">
              <label>Course</label>
              <select name="course" class="form-control">
                <option value="">All Courses</option>
                @foreach($courses as $course)
                  <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>
                    {{ $course->title }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="col-md-3">
              <label>Date From</label>
              <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>

            <div class="col-md-3">
              <label>Date To</label>
              <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>

            <div class="col-md-3 d-flex align-items-end">
              <button class="btn btn-primary mr-2">Apply</button>
              <a href="{{ route('admin.reports.index') }}" class="btn btn-light">Reset</a>
            </div>
          </form>
        </div>
      </div>

      {{-- STATS --}}
      <div class="row">
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">Total Quizzes<br><b>{{ $stats['quizzes'] }}</b></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">Total Attempts<br><b>{{ $stats['attempts'] }}</b></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">Pass %<br><b>{{ $stats['pass_percent'] }}%</b></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">Fail %<br><b>{{ $stats['fail_percent'] }}%</b></div>
          </div>
        </div>
      </div>

      {{-- TABLE --}}
      <div class="card mt-4">
        <div class="card-header d-flex justify-content-between">
          <h4>Quiz Report</h4>
          <a href="{{ route('admin.reports.export.pdf', request()->query()) }}" class="btn btn-danger btn-sm">
            Export PDF
          </a>
        </div>

        <div class="table-responsive">
          <table class="table table-striped">
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
            <tbody>
              @forelse($reports as $i => $row)
                <tr>
                  <td>{{ $i + 1 }}</td>
                  <td>{{ $row->quiz }}</td>
                  <td>{{ $row->course }}</td>
                  <td>{{ $row->attempts }}</td>
                  <td>{{ $row->avg_score }}%</td>
                  <td><span class="badge badge-success">{{ $row->pass_percent }}%</span></td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center">No data</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </section>
  </div>
@endsection
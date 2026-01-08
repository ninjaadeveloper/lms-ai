@extends('admin.layout')

@section('content')
<div class="main-content">
<section class="section">

  <div class="section-header">
    <h1>My Reports</h1>
  </div>

  {{-- STATS --}}
  <div class="row">
    <div class="col-md-4">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary"><i class="fas fa-book"></i></div>
        <div class="card-wrap">
          <div class="card-header"><h4>My Quizzes</h4></div>
          <div class="card-body">{{ $stats['quizzes'] }}</div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-statistic-1">
        <div class="card-icon bg-info"><i class="fas fa-users"></i></div>
        <div class="card-wrap">
          <div class="card-header"><h4>Total Attempts</h4></div>
          <div class="card-body">{{ $stats['attempts'] }}</div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-statistic-1">
        <div class="card-icon bg-success"><i class="fas fa-chart-line"></i></div>
        <div class="card-wrap">
          <div class="card-header"><h4>Avg Score</h4></div>
          <div class="card-body">{{ $stats['avg_score'] }}%</div>
        </div>
      </div>
    </div>
  </div>

  {{-- TABLE --}}
  <div class="card shadow-sm mt-4">
    <div class="card-header d-flex justify-content-between">
      <h4>Quiz Performance</h4>
      <a href="{{ route('trainer.reports.export.pdf', request()->query()) }}"
         class="btn btn-danger btn-sm">
        <i class="fas fa-file-pdf"></i> PDF
      </a>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Quiz</th>
              <th>Attempts</th>
              <th>Avg Score</th>
              <th>Pass %</th>
            </tr>
          </thead>
          <tbody>
          @forelse($reports as $i => $row)
            <tr>
              <td>{{ $i+1 }}</td>
              <td><strong>{{ $row->quiz }}</strong></td>
              <td>{{ $row->attempts }}</td>
              <td>{{ $row->avg_score }}%</td>
              <td>
                <span class="badge badge-success">
                  {{ $row->pass_percent }}%
                </span>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center py-4 text-muted">
                No reports available
              </td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</section>
</div>
@endsection

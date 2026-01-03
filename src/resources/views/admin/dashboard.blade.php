@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Dashboard</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div id="stats-total-users"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div id="stats-revenue"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.dashboardData = {
        totalUsers: {{ $totalUsers ?? 0 }},
        revenue: '{{ $revenue ?? "$0" }}',
        activeUsersPercentage: {{ $activeUsersPercentage ?? 0 }},
        visitorsData: @json($visitorsData ?? []),
        visitorsLastMonthData: @json($visitorsLastMonthData ?? []),
        trends: {
            positive: {{ $trendPositive ?? 0 }},
            negative: {{ $trendNegative ?? 0 }},
            activeUsers: {{ $trendActiveUsers ?? 0 }}
        }
    };
</script>
@endpush
@endsection

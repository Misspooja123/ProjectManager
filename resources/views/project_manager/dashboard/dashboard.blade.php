@extends('project_manager.layouts.master')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle" style="margin-left: -235.5px;">
            <h1>Dashboard</h1>
        </div>
        <section class="section dashboard">
            <div class="row" style="margin-left: -250.5px;">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-xxl-5 col-md-6">
                            <div class="card info-card sales-card">
                                @php
                                    use App\Models\User;
                                    $userCount = User::count();
                                @endphp
                                <div class="card-body">
                                    <h1 class="card-title">Total Employee</h1>
                                    <h1 class="card-text" style="color: rgb(84, 86, 192)">{{ $userCount }}</h1>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </main>
@endsection

@push('scripts')
@endpush

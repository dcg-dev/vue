@extends('layouts.main')
@section('title', $plan->name.' Plan')
@section('subtitle', 'Upgrade your plan anytime')
@section('content')
@include('profile.topbar')
<div id="upgrade-subscriptions-view" class="content content-boxed overflow-hidden">
    <div class="row push-20-t push-20">
        <h3 class="font-w300 animated fadeInUp push-20-l"><i class="si si-graduation"></i> Upgrade your plan to {{$plan->name}} Plan</h3>
        <h6 class="font-w400 animated fadeInUp push-20-l push-20 text-muted">Upgrade your account, grow and pay less commissions</h6>
        
    </div>
</div>
@endsection

@section('before-scripts')
<script type="text/javascript">
    window.currentPlan = {!!$plan->toJson()!!}
</script>
@endsection
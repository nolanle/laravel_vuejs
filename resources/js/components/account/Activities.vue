<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Lịch sử hoạt động</h4>
                    <div class="delete-button"></div>
                </div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Tài khoản</router-link>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Lịch sử hoạt động</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="mb-30">
            <div class="card-statistics h-100 card">
                <div class="card-body">
                    <h5 class="card-title">Lịch sử hoạt động</h5>
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="list list-unstyled mb-30 list-group">
                                @if($activities->count() > 0)
                                @foreach($activities as $activity)
                                <li class="p-0 pl-40 list-group-item">
                                    <i class="{{ $activity->getExtraProperty('icon') }}"></i> {{ $activity->description }} tại địa chỉ IP {{ $activity->getExtraProperty('ip') }} <span class="pull-right">{{ \Carbon\Carbon::instance(new DateTime($activity->created_at))->diffForHumans() }}</span>
                                </li>
                                @endforeach
                                @else
                                <li class="p-0 pl-40 list-group-item" style="border: none;"><i class="fa fa-exclamation-triangle text-warning"></i> Không có lịch sử hoạt động!</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Activities"
    }
</script>

<style scoped>

</style>
@if (session('status'))
    @php
        Toastr::info(session('status'), $title = __('Thao tác thành công!'), $options = [])
    @endphp
@endif
@if (session('success'))
    @php
        Toastr::success(session('success'), $title = __('Thao tác thành công!'), $options = [])
    @endphp
@endif
@if (session('error'))
    @php
        Toastr::error(session('error'), $title = __('Có lỗi xảy ra!'), $options = [])
    @endphp
@endif
@if (session('warning'))
    @php
        Toastr::warning(session('warning'), $title = __('Cảnh báo nguy hiểm'), $options = [])
    @endphp
@endif
@foreach ($errors->all() as $error)
    @php
        Toastr::error($error, $title = __('Có lỗi xảy ra!'), $options = [])
    @endphp
@endforeach
{!! Toastr::render() !!}
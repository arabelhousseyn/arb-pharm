@extends('layouts.app')

@section('content')
 <dashboard-page :user="{{ Auth::guard('admin')->user()  }}" />
</div>
@endsection

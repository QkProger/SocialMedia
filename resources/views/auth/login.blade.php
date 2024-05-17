@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Кіру') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('adminLoginForm') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="iin"
                                    class="col-md-4 col-form-label text-md-end">{{ __('ИИН') }}</label>

                                <div class="col-md-6">
                                    <input id="iin" type="number"
                                        class="form-control @error('iin') is-invalid @enderror" name="iin"
                                        value="{{ old('iin') }}" required autocomplete="iin" autofocus>

                                    @error('iin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Құпия сөз') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Кіру') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

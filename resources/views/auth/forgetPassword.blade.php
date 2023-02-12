@extends('layouts.app')

@section('content')
    <main class="login-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Восстановление пароля</div>
                        <div class="card-body">
                            @include('layouts.errors')
                            @include('layouts.messages')

                            @if(!session()->has('message'))
                                <form action="{{ route('forget.password.post') }}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail
                                            Address</label>
                                        <div class="col-md-6">
                                            <input type="text" id="email_address" class="form-control" name="email"
                                                   required autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Отправить ссылку на восстановление
                                        </button>
                                    </div>
                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@extends('home_themes.example.master.index')
@section('extra_sections')
    <section id="intro" class="odd-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Authorization Request
                        </div>
                        <div class="panel-body">
                            <!-- Introduction -->
                            <p><strong>{{ $client->name }}</strong> is requesting permission to access your account.</p>

                            <!-- Scope List -->
                            @if (count($scopes) > 0)
                                <div class="scopes">
                                    <p><strong>This application will be able to:</strong></p>

                                    <ul>
                                        @foreach ($scopes as $scope)
                                            <li>{{ $scope->description }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="buttons">
                                <!-- Authorize Button -->
                                <form method="post" action="/oauth/authorize">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="state" value="{{ $request->state }}">
                                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                                    <button type="submit" class="btn btn-success btn-approve">Authorize</button>
                                </form>

                                <!-- Cancel Button -->
                                <form method="post" action="/oauth/authorize">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="state" value="{{ $request->state }}">
                                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                                    <button class="btn btn-danger">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
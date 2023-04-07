@extends('layouts/base')

@section('content')
    <div class="row d-flex mt-5">
        <div class="col col-12">
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach

            <form class="card" enctype="multipart/form-data" action="{{ route('api-key-store') }}"
                  method="post">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="">
                                <label for="api-key-raw" class="form-label">API Key</label>
                                <input type="text" id="api-key-raw" name="api-key-raw"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-1 h-100">
                            <div class="vr"></div>
                        </div>
                        <div class="col-5">
                            <div class="">
                                <label class="form-label" for="api-key-file">API Key File</label>
                                <input type="file" class="form-control" id="api-key-file" name="api-key-file"
                                       accept=".txt"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3 ps-3">
                    <p>Generate your keys <a href="https://dashboard.mailerlite.com/integrations/api" target="_blank"
                                             class="link">here</a></p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button class="btn btn-success" type="submit">Submit</button>

                    @if($mailerLiteService->ready())
                        <a class="btn btn-outline-success" href="{{ route('subscribers') }}">
                            Continue with existing key
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection

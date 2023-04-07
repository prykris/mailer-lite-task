@extends('layouts/base')

@section('content')

    <div class="row">
        <div class="card mt-5">
            <div class="card-body">
                <form action="/subscribers/create" id="create-subscriber-form">
                    <div class="input-group mb-3">
                        <div class="col-8">
                            <input type="email" name="email" class="form-control" placeholder="E-Mail Address"
                                   aria-label="E-Mail Address"
                                   aria-describedby="create-button">
                        </div>
                        <div class="col-3">
                            <select class="countrypicker w-100 px-2" name="country" title="Country"></select>
                        </div>

                        <div class="col">
                            <input type="submit" class="btn btn-success" type="button" id="create-button" value="Create">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card mt-5">
            <div class="card-body">
                <table class="table table-responsive table-striped w-100" id="subscribers-table">
                    <thead>
                    <tr>
                        <th>E-Mail</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Subscribed At</th>
                        <th>Subscribed Time</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>E-Mail</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Subscribed Date</th>
                        <th>Subscribed Time</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    @include('components/edit-subscriber-modal')

    <script src="{{ asset('scripts/pages/subscribers.js') }}"></script>
@endsection

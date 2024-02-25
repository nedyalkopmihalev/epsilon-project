@extends('layouts.layout')
@section('content')
    <!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="header-icon">
            </div>
            <div class="header-title">
                <ol class="breadcrumb">
                    <li>Services</li>
                </ol>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-sm-9">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <small>Service</small>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Service</th>
                                        <th>Details</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php  $count = 1; @endphp

                                    @if ($responseBody)
                                        <tr>
                                            <th scope="row">@php echo $count @endphp</th>
                                            <td>{{ $responseBody->name }}</td>
                                            <td>
                                                Type: {{ $responseBody->type }}<br />
                                                Status: {{ $responseBody->status }}<br />
                                                @if ($responseBody->port)
                                                    Port: {{ $responseBody->port->name }}<br />
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- /.row -->
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
@endsection
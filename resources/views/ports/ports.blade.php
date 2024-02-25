@extends('layouts.layout')
@section('content')
    <!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="header-icon">
            </div>
            <div class="header-title"></div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-sm-9">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <small>Ports</small>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ports</th>
                                        <th>Services</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php  $count = 1; @endphp

                                    @if (count($responseBody) > 0)
                                        @foreach ($responseBody as $responseBodyItem)
                                            <tr>
                                                <th scope="row">@php echo $count @endphp</th>
                                                <td>{{ $responseBodyItem->name }}</td>
                                                <td>
                                                    @if (count($responseBodyItem->services) > 0)
                                                        @foreach ($responseBodyItem->services as $responseBodyServicesItem)
                                                            <a href="/service/{{ $responseBodyServicesItem->id }}">{{ $responseBodyServicesItem->name }}</a><br />
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>
                                            @php $count++; @endphp
                                        @endforeach
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
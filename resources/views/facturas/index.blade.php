@extends('master')

@section('titulo', 'Listado de facturas')
    @section('contenido')
        <div class="container text-center">

            <h2>Listado de Facturas</h2>
            <!-- Button Crear factura modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createFacturaModal">
                Crear Nueva Factura
            </button>
            <p></p>

            <div class="container text-center">
                <!--Formulario de Búsqueda-->
                {!! Form::open(['route'=>'facturas.index', 'method'=>'GET', 'class'=>'navbar-form']) !!}
                <div class="input-group mb-3">
                    {!! Form::text('numero', null, ['class'=>'form-control', 'id'=>'numero', 'placeholder'=>'Buscar Factura']) !!}
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
                {!! Form::close() !!}
            </div>

            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">Actualizar</th>
                        <th scope="col" class="text-center">Eliminar</th>
                        <th scope="col" class="text-start">Numero</th>
                        <th scope="col" class="text-start">Detalles</th>
                        <th scope="col" class="text-start">Valor</th>
                        <th scope="col" class="text-center">Archivo</th>
                        <th scope="col" class="text-start">Cliente</th>
                        <th scope="col" class="text-start">Forma Pago</th>
                        <th scope="col" class="text-start">Estado Factura</th>
                    </tr>
                </thead>
                @foreach($facturas as $factura)
                    <tr>
                        <td class="text-center">
                            <!--Boton Actualizar factura -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateFacturaModal{{$factura->id}}">
                                <i class="bi bi-pencil-square edit-btn"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            {!! Form::open(['route' => ['facturas.destroy', $factura->id], 'method' => 'DELETE']) !!}
                                <!-- Boton eliminar factura -->
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteFacturaModal{{$factura->id}}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            {!! Form::close() !!}
                        </td>
                        <td class="text-start">{{ $factura->numero }}</td>
                        <td class="text-start">{!! html_entity_decode($factura->detalles) !!}</td>
                        <td class="text-start">${{number_format($factura->valor)}}</td>
                        <td class="text-center"><img src="{{asset('archivos/'.$factura->archivo.'')}}" width="150"></td>
                        <td class="text-start">{{ $factura->idcliente }}</td>
                        <td class="text-start">{{ $factura->idforma }}</td>
                        <td class="text-start">{{ $factura->idestado }}</td>
                    </tr>
                    <!-- Modal Update -->
                    <div class="modal fade" id="updateFacturaModal{{$factura->id}}" tabindex="-1" role="dialog" aria-labelledby="updateFacturaModalLabel{{$factura->id}}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateFacturaModalLabel{{$factura->id}}">Actualizar Factura</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {!! Form::model($factura, ['route' => ['facturas.update', $factura->id], 'method' => 'PUT', 'files' => true]) !!}
                                        <div class="form-group">
                                            {!! Form::number('numero', null, array(
                                                    'class'=>'form-control',
                                                    'placeholder'=>'Numero de factura...'
                                                )) 
                                            !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Detalles</label>
                                            {!! Form::textarea('detalles', null, array(
                                                    'class'=>'form-control ckeditor',
                                                    'placeholder'=>'Detalles de la factura...'
                                                )) 
                                            !!}
                                        </div>
                                        <div class="form-group">
                                            {!! Form::number('valor', null, array(
                                                    'class'=>'form-control',
                                                    'placeholder'=>'Valor de la factura...'
                                                )) 
                                            !!}
                                        </div>
                                        <div class="form-group">
                                            {!! Form::file('archivo') !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Clientes</label>
                                            {!! Form::select('idcliente', $clientes, null, array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Formas de Pago</label>
                                            {!! Form::select('idforma', $formaspago, null, array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Estados Factura</label>
                                            {!! Form::select('idestado', $estadosfacturas, null, array('class' => 'form-control')) !!}
                                        </div>
                                    {!! Form::submit('Actualizar Factura', array('class'=>'btn btn-success')) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </table>
            {{ $facturas->links()}}
            <hr>
        </div>
        
        <!-- Modal Insert-->
        <!-- Modal Create Factura -->
        <div class="modal fade" id="createFacturaModal" tabindex="-1" role="dialog" aria-labelledby="createFacturaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createFacturaModalLabel">Crear Factura</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['route' => 'facturas.store','method' => 'POST', 'files' => true]) !!}
                            <div class="form-group">
                                {!! Form::number('numero', null, [
                                        'class'=>'form-control',
                                        'required'=>'required',
                                        'placeholder'=>'Numero de la factura...'
                                    ])
                                !!}
                            </div>
                            <div class="form-group">
                                {!! Form::textarea('detalles', null, [
                                        'class'=>'form-control ckeditor',
                                        'placeholder'=>'Detalles de la factura...'
                                    ])
                                !!}
                            </div>
                            <div class="form-group">
                                {!! Form::number('valor', null, [
                                        'class'=>'form-control',
                                        'required'=>'required',
                                        'placeholder'=>'Valor de la factura...'
                                    ])
                                !!}
                            </div>
                            <div class="form-group">
                                {!! Form::file('archivo') !!}
                            </div>
                            <div class="form-group">
                                <label>Clientes</label>
                                {!! Form::select('idcliente', $clientes, null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                <label>Forma de Pago</label>
                                {!! Form::select('idforma', $formaspago, null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                <label>Estados</label>
                                {!! Form::select('idestado', $estadosfacturas, null, ['class' => 'form-control']) !!}
                            </div>
                        {!! Form::submit('Guardar Perfil', array('class'=>'btn btn-success'))!!}
                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal delete -->
        @foreach($facturas as $factura)
            <div class="modal fade" id="deleteFacturaModal{{$factura->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteFacturaModalLabel{{$factura->id}}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteFacturaModalLabel{{$factura->id}}">Eliminar Factura</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Deseas eliminar la factura "{{ $factura->numero }}"?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            {!! Form::open(['route' => ['facturas.destroy', $factura->id], 'method' => 'DELETE']) !!}
                                {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
         @endforeach   
@endsection


<table>
    <thead style="height: 25px">
        <tr>
            <th colspan="17" style="text-align: center; background: #a8d9ff; border: 1px solid #000; font-style: italic; font-size:25px; font-weight: bold">
                {{ $tipo_permiso }}
            </th>
        </tr>
        <tr>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 129px; border: 1px solid #000;">Tipo
                de Documento</th>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 154px; border: 1px solid #000;">
                Número de Documento</th>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 400px; border: 1px solid #000;">
                Nombre de Persona</th>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 450px; border: 1px solid #000;">
                Unidad Organica</th>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 144px; border: 1px solid #000;">
                Fecha Ingreso Labores</th>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 101px; border: 1px solid #000;">
                Estado Persona</th>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 320px; border: 1px solid #000;">
                Concepto Permiso</th>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 100px; border: 1px solid #000;">
                Fecha de Inicio</th>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 100px; border: 1px solid #000;">
                Fecha de Fin</th>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 350px; border: 1px solid #000;">
                Documento sustentatorio</th>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 200px; border: 1px solid #000;">
                Año Periodo</th>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 350px; border: 1px solid #000;">
                Concepto</th>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 200px; border: 1px solid #000;">
                Número de Contacto</th>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 77px; border: 1px solid #000;">
                Codigo PDT</th>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 109px; border: 1px solid #000;">
                Cantidad de Días</th>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 127px; border: 1px solid #000;">
                Fecha de Creación</th>
            <th scope="col" style="text-align: center; background: #a8d9ff; width: 194px; border: 1px solid #000;">
                Fecha de Ultima Actualización</th>
        </tr>
    </thead>
    <tbody>
        @if (count($query) > 0)
        @foreach ($query as $q)
        <tr>
            <td style="text-align: center;border: 1px solid #000">{{ $q->tipo_documento_persona }}</td>
            <td style="text-align: center;border: 1px solid #000">{{ $q->documento_persona }}</td>
            <td style="text-align: center;border: 1px solid #000">{{ $q->nombre_persona }}</td>
            <td style="text-align: center;border: 1px solid #000">{{ $q->uniorg_persona }}</td>
            <td style="text-align: center;border: 1px solid #000">{{ $q->fecha_inicio_persona }}</td>
            @if ($q->estado_persona == '')
            <td style="text-align: center;border: 1px solid #000">INACTIVO</td>
            @else
            <td style="text-align: center;border: 1px solid #000">ACTIVO</td>
            @endif
            <td style="text-align: center;border: 1px solid #000">{{ $q->descripcion }}</td>
            <td style="text-align: center;border: 1px solid #000">{{ $q->fecha_inicio }}</td>
            <td style="text-align: center;border: 1px solid #000">{{ $q->fecha_fin }}</td>
            <td style="text-align: center;border: 1px solid #000">{{ $q->documento }}</td>
            @if ($q->anio_periodo == '')
            <td style="text-align: center;border: 1px solid #000">NO REGISTRADO</td>
            @else
            <td style="text-align: center;border: 1px solid #000">{{ $q->anio_periodo }}</td>
            @endif
            <td style="text-align: center;border: 1px solid #000">{{ $q->comentario }}</td>
            @if ($q->numero_contacto == '')
            <td style="text-align: center;border: 1px solid #000">NO REGISTRADO</td>
            @else
            <td style="text-align: center;border: 1px solid #000">{{ $q->numero_contacto }}</td>
            @endif
            <td style="text-align: center;border: 1px solid #000">{{ $q->codigo_pdt }}</td>
            <td style="text-align: center;border: 1px solid #000">{{ $q->dias }}</td>
            <td style="text-align: center;border: 1px solid #000">{{ $q->created_at }}</td>
            <td style="text-align: center;border: 1px solid #000">{{ $q->updated_at }}</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="17" style="text-align: center;border: 1px solid #000">No se encontraron datos</td>
        </tr>
        @endif
    </tbody>
    <tfoot>
        <tr>
            <th colspan="17" style="text-align: center; background: #a8d9ff; border: 1px solid #000; font-style: italic; font-size:25px; font-weight: bold">
            </th>
        </tr>
    </tfoot>
</table>

@extends('pdf.layout.main')
@section('content')
    <br>
    <div class="w-100">
        <div class="bg-warning text-white p-2 rounded text-center text-uppercase">
            Bítacora del sistema
        </div>
        <div class="w-100">
            <table class="table table-bordered">
                <thead class="border-b">
                    <tr>
                        <th class="text-center font-bold py-3">
                            Modulo
                        </th>
                        <th class="text-center font-bold py-3">
                            Usuario
                        </th>
                        <th class="text-center font-bold py-3">
                            Sujeto
                        </th>
                        <th class="text-center font-bold py-3">
                            Fecha
                        </th>
                        <th class="text-center font-bold py-3">
                            Plataforma
                        </th>
                        <th class="text-center font-bold py-3">
                            IP
                        </th>
                        <th class="text-center font-bold py-3">
                            Proceso
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{ $log['module'] }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{ $log['user'] }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{ $log['subject'] }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{ $log['date_report'] }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{ $log['user_agent'] }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{ $log['ip'] }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{ $log['proceso'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
